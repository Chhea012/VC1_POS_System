<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <style>
                    body {
                        font-family: <?php echo $lang === 'km' ? "'Noto Sans Khmer', sans-serif" : "'Public Sans', sans-serif"; ?>;
                    }
                </style>
                <li class="nav-item dropdown">
                    <!-- Globe Icon that opens the dropdown -->
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/views/assets/modules/img/country/english.png" alt="English" class="flag-icon"> English

                    </a>

                    <!-- Dropdown menu with Khmer and English options -->
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item" href="#" onclick="changeLanguage('km')">
                                <img src="/views/assets/modules/img/country/cambodia.png" alt="Khmer" class="flag-icon"> Khmer
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="changeLanguage('en')">
                                <img src="/views/assets/modules/img/country/english.png" alt="English" class="flag-icon"> English
                            </a>
                        </li>
                    </ul>
                </li>
                <script>
                    // function changeLanguage(lang) {
                    //     localStorage.setItem('selectedLanguage', lang);
                    //     location.reload(); // Reload to apply changes
                    // }

                    // // Function to apply selected language on page load
                    // document.addEventListener("DOMContentLoaded", function() {
                    //     const selectedLanguage = localStorage.getItem('selectedLanguage') || 'en';
                    //     applyLanguage(selectedLanguage);
                    // });

                    // function applyLanguage(lang) {
                    //     // Example of language switching logic
                    //     // You can expand this to fetch translations from a JSON file or API
                    //     if (lang === 'km') {
                    //         document.documentElement.lang = 'km';
                    //         document.getElementById('languageDropdown').innerHTML = '<img src="/views/assets/modules/img/country/cambodia.png" alt="Khmer" class="flag-icon"> Khmer';
                    //     } else {
                    //         document.documentElement.lang = 'en';
                    //         document.getElementById('languageDropdown').innerHTML = '<img src="/views/assets/modules/img/country/english.png" alt="English" class="flag-icon"> English';
                    //     }
                    // }

                    function changeLanguage(lang) {
                        localStorage.setItem('selectedLanguage', lang);
                        applyLanguage(lang); // Apply changes without reloading
                    }

                    // Function to apply selected language on page load
                    document.addEventListener("DOMContentLoaded", function() {
                        const selectedLanguage = localStorage.getItem('selectedLanguage') || 'en';
                        applyLanguage(selectedLanguage);
                    });

                    function applyLanguage(lang) {
                        const languageDropdown = document.getElementById('languageDropdown');
                        const dropdownMenu = document.querySelector('.dropdown-menu');
                        dropdownMenu.innerHTML = ''; // Clear existing menu items

                        if (lang === 'km') {
                            document.documentElement.lang = 'km';
                            languageDropdown.innerHTML = '<img src="/views/assets/modules/img/country/cambodia.png" alt="Khmer" class="flag-icon"> Khmer';
                            dropdownMenu.innerHTML = '<li><a class="dropdown-item" href="#" onclick="changeLanguage(\'en\')">' +
                                '<img src="/views/assets/modules/img/country/english.png" alt="English" class="flag-icon"> English</a></li>';
                        } else {
                            document.documentElement.lang = 'en';
                            languageDropdown.innerHTML = '<img src="/views/assets/modules/img/country/english.png" alt="English" class="flag-icon"> English';
                            dropdownMenu.innerHTML = '<li><a class="dropdown-item" href="#" onclick="changeLanguage(\'km\')">' +
                                '<img src="/views/assets/modules/img/country/cambodia.png" alt="Khmer" class="flag-icon"> Khmer</a></li>';
                        }
                    }
                </script>
                <!-- Notification Bell -->
                <a class="nav-link" href="/notification" id="notificationDropdown" role="button" aria-expanded="false" style="position: relative;">
                    <i class="bx bx-bell bx-sm"></i>
                    <span id="notification-count" class="badge"
                        style="position: absolute; top: -5px; right: -5px; background: red; color: white; padding: 5px; border-radius: 50%; display: none;">
                    </span>
                </a>


                <li class="nav-item lh-1 me-3 p4">
                    <!-- <i class="bx bx-moon" id="darkModeToggle"></i> -->
                </li>



                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="/views/assets/modules/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="/views/assets/modules/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">Chhea</span>
                                        <small class="text-muted">Admin</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./edit_profile">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/users/logout">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>


    <!-- Add this script to manage the notification count -->
    <script>
        // Function to update the notification badge
        function updateNotificationBadge() {
            let events = JSON.parse(localStorage.getItem("events")) || [];
            let unreadCount = events.filter(event => !event.isRead).length;
            let badge = document.getElementById("notification-count");

            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = "inline-block"; // Show the badge
            } else {
                badge.style.display = "none"; // Hide the badge if no unread notifications
            }
        }

        // Call the function on page load
        document.addEventListener("DOMContentLoaded", function() {
            updateNotificationBadge();
        });

        // If you already have functions like loadNotifications, dismissNotification, or markAsRead, 
        // make sure to call updateNotificationBadge() inside them. For example:

        // Example: If you have a loadNotifications function
        function loadNotifications() {
            let notificationList = document.getElementById("notifications-list");
            let events = JSON.parse(localStorage.getItem("events")) || [];

            if (events.length === 0) {
                notificationList.innerHTML = `
            <div class="text-center py-5">
                <i class="bx bx-bell text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No new notifications.</p>
            </div>`;
                updateNotificationBadge(); // Update badge when no notifications
                return;
            }

            // Add a read/unread state and timestamp if not present
            events = events.map(event => ({
                ...event,
                isRead: event.isRead || false,
                timestamp: event.timestamp || new Date().toISOString()
            }));
            localStorage.setItem("events", JSON.stringify(events));

            // Your existing rendering logic for notifications...
            updateNotificationBadge(); // Update badge after loading notifications
        }

        // Example: If you have a dismissNotification function
        function dismissNotification(index) {
            let events = JSON.parse(localStorage.getItem("events")) || [];
            events.splice(index, 1);
            localStorage.setItem("events", JSON.stringify(events));
            loadNotifications();
            updateNotificationBadge(); // Update badge after dismissing
        }

        // Example: If you have a markAsRead function
        function markAsRead(index) {
            let events = JSON.parse(localStorage.getItem("events")) || [];
            events[index].isRead = !events[index].isRead; // Toggle read/unread
            localStorage.setItem("events", JSON.stringify(events));
            loadNotifications();
            updateNotificationBadge(); // Update badge after marking as read/unread
        }
    </script>