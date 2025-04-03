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
                <div data-i18n="dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="/products" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                <div data-i18n="Product List">Products</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Inventory">Inventory</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/drink" class="menu-link">
                        <div data-i18n="Drink">Drink</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/food" class="menu-link">
                        <div data-i18n="FastFood">FastFood</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/ice" class="menu-link">
                        <div data-i18n="FreshIce">FreshIce</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="/category" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="category">Category</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="/orders/barcode" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Orders">Orders</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="/topproductorder" class="menu-link">
                <i class="menu-icon tf-icons bx bx-star"></i>
                <div data-i18n="topproductorder">Top Products Ordered</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="/orders" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Product List">History Orders</div>
            </a>
        </li>

        

        <li class="menu-item">
            <a href="/users" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="user">User</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="/weather" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cloud"></i>
                <div data-i18n="weather">Weather</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="/calendar" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Calendar">Calendar</div>
            </a>
        </li>
    </ul>
</aside>

<script>
    // Get current URL
    const currentUrl = window.location.pathname;

    // Get all menu items
    const menuItems = document.querySelectorAll(".menu-item a");

    // Loop through menu items and add active class if URL matches
    menuItems.forEach(item => {
        if (item.getAttribute("href") === currentUrl) {
            item.classList.add("active");
        }
    });
</script>

<style>
    /* Active menu item styles */
    .menu-item .menu-link.active {
        color: #ffffff !important; /* White text */
        background-color:rgba(23, 68, 217, 0.79) !important; /* Blue background */
        font-weight: bold;
        border-radius: 5px;
    }
</style>
