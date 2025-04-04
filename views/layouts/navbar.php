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
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- This will be updated dynamically -->
                    </a>

                    <!-- Dropdown menu (only one language option at a time) -->
                    <ul class="dropdown-menu" id="languageDropdownMenu" aria-labelledby="languageDropdown">
                        <!-- This will be updated dynamically -->
                    </ul>
                </li>

                <script>
                    //Change language and update UI
                    function changeLanguage(lang) {
                        localStorage.setItem('selectedLanguage', lang);
                        applyTranslations(lang);
                        updateLanguageDropdown(lang);
                        updateFontFamily(lang);
                    }

                    // // Update language dropdown display
                    document.addEventListener("DOMContentLoaded", function() {
                        const selectedLanguage = localStorage.getItem('selectedLanguage') || 'en';
                        updateLanguageDropdown(selectedLanguage);
                    });

                    function updateLanguageDropdown(lang) {
                        const languageDropdown = document.getElementById('languageDropdown');
                        const dropdownMenu = document.getElementById('languageDropdownMenu');

                        const languages = {
                            en: {
                                name: "English",
                                flag: "/views/assets/modules/img/country/english.png",
                                oppositeLang: "km",
                                oppositeName: "Khmer",
                                oppositeFlag: "/views/assets/modules/img/country/cambodia.png"
                            },
                            km: {
                                name: "ខ្មែរ",
                                flag: "/views/assets/modules/img/country/cambodia.png",
                                oppositeLang: "en",
                                oppositeName: "អង់គ្លេស",
                                oppositeFlag: "/views/assets/modules/img/country/english.png"
                            }

                        };
                        // Function to switch language
                        function changeLanguage(lang) {
                            document.documentElement.lang = lang;
                            updateLanguageDropdown(lang);
                            // You can also save the selected language in local storage or a cookie if needed
                        }

                        // Update the dropdown button
                        languageDropdown.innerHTML = `
            <img src="${languages[lang].flag}" alt="${languages[lang].name}" class="flag-icon"> ${languages[lang].name}
        `;

                        // Show only the opposite language in the dropdown menu
                        dropdownMenu.innerHTML = `
            <li><a class="dropdown-item" href="#" onclick="changeLanguage('${languages[lang].oppositeLang}')">
                <img src="${languages[lang].oppositeFlag}" alt="${languages[lang].oppositeName}" class="flag-icon"> ${languages[lang].oppositeName}
            </a></li>
        `;
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