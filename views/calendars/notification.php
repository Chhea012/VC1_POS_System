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

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Notifications</h2>
            <button id="mark-all-read" class="btn btn-link text-primary" style="display: none;">Mark All as Read</button>
        </div>
        <div id="notifications-list"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            loadNotifications();
            checkTodayEvents();
        });

        function loadNotifications() {
            let notificationList = document.getElementById("notifications-list");
            let markAllButton = document.getElementById("mark-all-read");
            let events = JSON.parse(localStorage.getItem("events")) || [];

            if (events.length === 0) {
                notificationList.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-bell text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">No new notifications.</p>
                    </div>`;
                markAllButton.style.display = "none";
                return;
            }

            // Add a read/unread state and timestamp if not present
            events = events.map(event => ({
                ...event,
                isRead: event.isRead || false,
                timestamp: event.timestamp || new Date().toISOString()
            }));
            localStorage.setItem("events", JSON.stringify(events));

            // Group notifications by date
            const groupedEvents = groupByDate(events);

            let html = "";
            for (const [dateLabel, eventGroup] of Object.entries(groupedEvents)) {
                html += `<h5 class="mt-4">${dateLabel}</h5>`;
                html += eventGroup.map((event, index) => {
                    const icon = event.title.toLowerCase().includes("birthday") ? "🎂" : "💼";
                    const timeAgo = getTimeAgo(new Date(event.timestamp));
                    const bgClass = event.isRead ? "bg-light" : "bg-primary-subtle";
                    return `
                        <div class="card mb-2 ${bgClass}" style="border-radius: 10px;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="me-3" style="font-size: 1.5rem;">${icon}</span>
                                    <div>
                                        <strong>${event.title}</strong> - ${event.start}
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">${timeAgo}</p>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary me-2" onclick="markAsRead(${index})">
                                        ${event.isRead ? "Mark as Unread" : "Mark as Read"}
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="dismissNotification(${index})">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join("");
            }

            notificationList.innerHTML = html;
            markAllButton.style.display = events.some(event => !event.isRead) ? "block" : "none";

            // Add event listener for "Mark All as Read"
            markAllButton.onclick = () => {
                events = events.map(event => ({ ...event, isRead: true }));
                localStorage.setItem("events", JSON.stringify(events));
                loadNotifications();
            };
        }

        function dismissNotification(index) {
            let events = JSON.parse(localStorage.getItem("events")) || [];
            events.splice(index, 1);
            localStorage.setItem("events", JSON.stringify(events));
            loadNotifications();
            checkTodayEvents();
        }

        function markAsRead(index) {
            let events = JSON.parse(localStorage.getItem("events")) || [];
            events[index].isRead = !events[index].isRead; // Toggle read/unread
            localStorage.setItem("events", JSON.stringify(events));
            loadNotifications();
        }

        function groupByDate(events) {
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            const grouped = { "Today": [], "Yesterday": [], "Earlier": [] };

            events.forEach(event => {
                const eventDate = new Date(event.timestamp);
                if (isSameDay(eventDate, today)) {
                    grouped["Today"].push(event);
                } else if (isSameDay(eventDate, yesterday)) {
                    grouped["Yesterday"].push(event);
                } else {
                    grouped["Earlier"].push(event);
                }
            });

            return grouped;
        }

        function isSameDay(date1, date2) {
            return date1.toDateString() === date2.toDateString();
        }

        function getTimeAgo(date) {
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            if (seconds < 60) return `${seconds} seconds ago`;
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes} minute${minutes !== 1 ? "s" : ""} ago`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours} hour${hours !== 1 ? "s" : ""} ago`;
            const days = Math.floor(hours / 24);
            return `${days} day${days !== 1 ? "s" : ""} ago`;
        }

        function checkTodayEvents() {
            // This function can be expanded to update a notification badge
            console.log("Checking today's events...");
        }
    </script>
</div>