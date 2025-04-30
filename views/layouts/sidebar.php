<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
        <?php if (isset($_SESSION['user']['role_id']) && $_SESSION['user']['role_id'] == 1): ?>
        <li class="menu-item">
            <a href="/calendar" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="calendar"></div>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</aside>

<!-- Combined Styles -->
<style>
    .menu-item .menu-link.active {
        color: #ffffff !important;
        background-color: rgba(23, 68, 217, 0.79) !important;
        font-weight: bold;
        border-radius: 5px;
        margin-right: 35px;
    }

    .flag-icon {
        width: 20px;
        height: 20px;
        margin-right: 8px;
    }

    .menu-link {
        display: flex;
        align-items: center;
    }

    .menu-icon {
        margin-right: 10px;
    }
</style>

<!-- Combined Script -->
<script>
    const translations = {
        en: {
            dashboard: "Dashboard",
            products: "Products",
            inventory: "Stock list",
            drink: "Drink",
            fastfood: "FastFood",
            freshice: "FreshIce",
            category: "Category",
            orders: "Orders",
            topproductorder: "Top Products Ordered",
            historyorders: "Orders History",
            user: "Users",
            weather: "Weather",
            calendar: "Calendar"
        },
        km: {
            dashboard: "ផ្ទាំងគ្រប់គ្រង",
            products: "ផលិតផល",
            inventory: "ស្តុកទំនិញ",
            drink: "ភេសជ្ជៈ",
            fastfood: "អាហារ",
            freshice: "ទឹកកកស្រស់",
            category: "ប្រភេទ",
            orders: "ការបញ្ជាទិញ",
            topproductorder: "ផលិតផលលក់ដាច់ជាងគេ",
            historyorders: "ប្រវត្តិការបញ្ជាទិញ",
            user: "អ្នកប្រើប្រាស់",
            weather: "អាកាសធាតុ",
            calendar: "ប្រតិទិន"
        }
    };

    function applyTranslations(lang) {
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                element.textContent = translations[lang][key];
            }
        });
    }

    function updateFontFamily(lang) {
        document.documentElement.style.fontFamily = lang === 'km'
            ? "'Noto Sans Khmer', sans-serif"
            : "'Public Sans', sans-serif";
    }

    function changeLanguage(lang) {
        localStorage.setItem('selectedLanguage', lang);
        applyTranslations(lang);
        updateFontFamily(lang);
        updateLanguageDropdown(lang); // Refresh dropdown display too
    }

    // On page load, initialize language and active sidebar
    document.addEventListener("DOMContentLoaded", function() {
        const selectedLanguage = localStorage.getItem('selectedLanguage') || 'en';
        changeLanguage(selectedLanguage);

        // Highlight active menu item
        const currentUrl = window.location.pathname;
        document.querySelectorAll(".menu-item a").forEach(item => {
            if (item.getAttribute("href") === currentUrl) {
                item.classList.add("active");
            }
        });
    });
</script>