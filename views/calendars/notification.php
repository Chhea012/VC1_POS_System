<div class="container-xxl flex-grow-1 container-p-y">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit();
    }
    ?>

    <!-- Notifications Section -->
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-gradient">Notifications</h2>
            <button id="mark-all-read" class="btn btn-outline-primary btn-sm" style="display: none;">
                <i class="bi bi-check-all me-1"></i> Mark All as Read
            </button>
        </div>
        <div id="notifications-list" class="notification-container"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            loadNotifications();
            updateNotificationBadge();

            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => new bootstrap.Dropdown(dropdown));
        });

        function loadNotifications() {
            const notificationList = document.getElementById("notifications-list");
            const markAllButton = document.getElementById("mark-all-read");
            let events = JSON.parse(localStorage.getItem("events")) || [];

            if (!events.length) {
                notificationList.innerHTML = `
                    <div class="text-center py-5 animate__animated animate__fadeIn">
                        <i class="bx bx-bell" style="font-size: 3rem; color: #666;"></i>
                        <p class="mt-3" style="color: #333;">No notifications yet</p>
                        <small style="color: #666;">We'll let you know when something happens!</small>
                    </div>`;
                markAllButton.style.display = "none";
                updateNotificationBadge();
                return;
            }

            events = events.map((event, index) => ({
                ...event,
                isRead: event.isRead || false,
                timestamp: event.timestamp || new Date().toISOString(),
                id: event.id || index,
                product_id: event.product_id || '',
                description: event.description || (event.title.toLowerCase().includes("low stock") 
                    ? `Low stock alert! Only ${event.quantity} units remaining. Suggest reordering at least ${Math.max(10, event.quantity * 2)} units to maintain inventory levels.`
                    : '')
            }));
            localStorage.setItem("events", JSON.stringify(events));

            const groupedEvents = groupByDayOfWeek(events);
            let html = "";

            for (const [dayLabel, eventGroup] of Object.entries(groupedEvents)) {
                if (!eventGroup.length) continue;
                html += `<h5 class="mt-4 fw-semibold" style="color: #444;">${dayLabel}</h5>`;
                html += eventGroup.map((event, index) => {
                    const icon = event.title.toLowerCase().includes("birthday") 
                        ? ["🎂", "bg-primary text-white"]
                        : event.title.toLowerCase().includes("low stock") 
                        ? ["📉", "bg-danger text-white"]
                        : ["💼", "bg-success text-white"];
                    
                    const timeAgo = getTimeAgo(new Date(event.timestamp));
                    const statusClass = event.isRead ? "read" : "unread";

                    return `
                        <div class="card notification-card ${statusClass} animate__animated animate__fadeInUp" data-index="${index}">
                            <div class="card-body d-flex align-items-start justify-content-between p-3">
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <div class="notification-icon ${icon[1]}">${icon[0]}</div>
                                    <div>
                                        <h6 class="mb-1 fw-bold" style="color: #222;">${event.title}</h6>
                                        <p class="mb-1" style="color: #555;">${event.start}</p>
                                        ${event.quantity !== undefined ? `
                                            <span class="badge" style="background-color: #ffe6e6; color: #d32f2f;">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Stock: ${event.quantity}
                                            </span>` : ""}
                                        ${event.description ? `
                                            <p class="mb-1 small" style="color: #444;">${event.description}</p>` : ""}
                                        <small style="color: #777;">${timeAgo}</small>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" 
                                            type="button" 
                                            id="dropdownMenuButton${index}" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false"
                                            style="color: #666;">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${index}">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="markAsRead(${index}); return false;" style="color: #333;">
                                                <i class="bi ${event.isRead ? 'bi-eye-slash' : 'bi-check'}"></i>
                                                ${event.isRead ? "Mark Unread" : "Mark Read"}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="dismissNotification(${index}); return false;" style="color: #d32f2f;">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="progress-bar ${event.isRead ? 'bg-secondary' : 'bg-primary'}" 
                                 style="width: ${event.isRead ? '100%' : '85%'}"></div>
                        </div>
                    `;
                }).join("");
            }

            notificationList.innerHTML = html;
            markAllButton.style.display = events.some(event => !event.isRead) ? "block" : "none";
            updateNotificationBadge();

            markAllButton.onclick = () => {
                events = events.map(event => ({ ...event, isRead: true }));
                localStorage.setItem("events", JSON.stringify(events));
                loadNotifications();
            };
        }

        function dismissNotification(index) {
            try {
                const events = JSON.parse(localStorage.getItem("events")) || [];
                if (index >= 0 && index < events.length) {
                    events.splice(index, 1);
                    localStorage.setItem("events", JSON.stringify(events));
                    loadNotifications();
                }
            } catch (error) {
                console.error("Error dismissing notification:", error);
            }
        }

        function markAsRead(index) {
            try {
                const events = JSON.parse(localStorage.getItem("events")) || [];
                if (index >= 0 && index < events.length) {
                    events[index].isRead = !events[index].isRead;
                    localStorage.setItem("events", JSON.stringify(events));
                    loadNotifications();
                }
            } catch (error) {
                console.error("Error marking as read:", error);
            }
        }

        function updateNotificationBadge() {
            try {
                const events = JSON.parse(localStorage.getItem("events")) || [];
                const unreadCount = events.filter(event => !event.isRead).length;
                const badge = document.getElementById("notification-count");
                if (badge) {
                    badge.textContent = unreadCount;
                    badge.style.display = unreadCount > 0 ? "inline-block" : "none";
                }
            } catch (error) {
                console.error("Error updating badge:", error);
            }
        }

        function groupByDayOfWeek(events) {
            const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const grouped = {};

            events.forEach(event => {
                const eventDate = new Date(event.start);
                if (isNaN(eventDate.getTime())) return; // Skip invalid dates
                const dayIndex = eventDate.getDay();
                const dayLabel = daysOfWeek[dayIndex];
                if (!grouped[dayLabel]) {
                    grouped[dayLabel] = [];
                }
                grouped[dayLabel].push(event);
            });

            return grouped;
        }

        function getTimeAgo(date) {
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            if (seconds < 60) return `${seconds} sec ago`;
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes} min ago`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours} hr ago`;
            const days = Math.floor(hours / 24);
            return `${days} day${days !== 1 ? "s" : ""} ago`;
        }
    </script>
</div>

<!-- Style cards notification -->
<style>
    .text-gradient {
        background: linear-gradient(45deg, #007bff, #00ff95);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .notification-container {
        max-height: 600px;
        overflow-y: auto;
    }

    .notification-card {
        position: relative;
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .notification-card.unread {
        background: linear-gradient(135deg, #f5f7ff 0%, #e8ebff 100%);
    }

    .notification-card.read {
        background: #ffffff;
    }

    .notification-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .progress-bar {
        height: 4px;
        position: absolute;
        bottom: 0;
        left: 0;
        transition: width 0.3s ease;
    }

    .card-body {
        display: flex;
        align-items: start;
        justify-content: space-between;
        padding: 1rem;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-toggle {
        background: none !important;
        border: none !important;
        padding: 0 !important;
        color: #666 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        line-height: 1;
    }

    .dropdown-toggle i {
        font-size: 1.5rem;
        vertical-align: middle;
    }

    .dropdown-toggle::after {
        display: none !important;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        min-width: 150px;
        border-radius: 8px;
        padding: 5px 0;
        z-index: 1000;
        margin-top: 5px;
    }

    .dropdown-menu.show {
        display: block !important;
        opacity: 1;
        transform: translateY(5px);
        transition: all 0.2s ease-in-out;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 8px 15px;
        font-size: 0.9rem;
        color: #333;
        transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item i {
        margin-right: 8px;
    }

    .dropdown-item.text-danger {
        color: #dc3545 !important;
    }
</style>