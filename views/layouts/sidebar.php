<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/dashboard" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="../../views/assets/modules/img/logo/logo.png" alt="Logo">
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <span class="app-title">Mak Oun Sing</span>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-list">
        <li class="menu-item">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-i18n="dashboard"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/products" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                <div data-i18n="products"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="inventory"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/drink" class="menu-link">
                        <div data-i18n="drink"></div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/food" class="menu-link">
                        <div data-i18n="fastfood"></div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/ice" class="menu-link">
                        <div data-i18n="freshice"></div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="/category" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="category"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/orders/barcode" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="orders"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/orders" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="historyorders"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/users" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="user"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/weather" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cloud"></i>
                <div data-i18n="weather"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/calendar" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="calendar"></div>
            </a>
        </li>
    </ul>
</aside>

<!-- Combined Script -->
<script>
    // Notification badge update
    function updateNotificationBadge() {
        let events = JSON.parse(localStorage.getItem("events")) || [];
        let unreadCount = events.filter(event => !event.isRead).length;
        let badge = document.getElementById("notification-count");
        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = "inline-block";
            } else {
                badge.style.display = "none";
            }
        }
    }
</script>