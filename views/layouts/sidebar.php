<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="./dashboard" class="app-brand-link">
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

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="./dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        <!-- eCommerce -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-cart-alt'></i>
                <div data-i18n="eCommerce">eCommerce</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="./dashboard" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Products">Products</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="./products" class="menu-link">
                                <div data-i18n="Product List">Product List</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="./products/create" class="menu-link">
                                <div data-i18n="Add Product">Add Product</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="./category" class="menu-link">
                                <div data-i18n="Category List">Category List</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Orders">Orders</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="/orders" class="menu-link">
                                <div data-i18n="Order List">Order List</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/orders/create" class="menu-link">
                                <div data-i18n="Add Order">Add Order</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- Inventory -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Inventory">Inventory</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="./drink" class="menu-link">
                        <div data-i18n="Drink">Drink</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="./food" class="menu-link">
                        <div data-i18n="FastFood">FastFood</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="./ice" class="menu-link">
                        <div data-i18n="FreshIce">FreshIce</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Users -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n="Users">Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/users" class="menu-link" target="_blank">
                        <div data-i18n="All Users">All User</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Weather -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cloud"></i>
                <div data-i18n="Weather">Weather</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/weather" class="menu-link">
                        <div data-i18n="Weather">Weather</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Calendar -->
        <li class="menu-item">
            <a href="/calendar" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Calendar">Calendar</div>
            </a>
        </li>
    </ul>
</aside>