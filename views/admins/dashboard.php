<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (! isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            <!-- Welcome Card (Full Width Hero) -->
            <div class="col-lg-12 order-0 mt-4">
                <div class="card p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h2 class="card-title text-primary fw-bold fs-3">
                                    <div data-i18n="welcome">WELCOME! 🎉🚀</div>
                                </h2>
                                <p class="mb-4 fs-5">
                                <div data-i18n="orderPerformance">Boom! You've smashed it with</div>
                                <span class="fw-bold text-success"><?php echo $orderIncrease ?>% <span data-i18n="moreOrders">% more orders</span></span>
                                <span data-i18n="checkOrders">today. Check your orders now!</span>
                                </p>
                                <a href="/orders/barcode" class="btn btn-primary fs-6">
                                    <div data-i18n="viewOrders">View Orders</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="views/assets/modules/img/illustrations/dashoad.png" height="200" alt="Illustration">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Sale Card -->
            <div class="col-lg-4 order-1 mt-4">
                <div class="card p-2 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-cylinder fs-2 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <div data-i18n="today">Today</div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <div data-i18n="tomorrow">Tomorrow</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">
                            <div data-i18n="productSales">Product Sales 📈</div>
                        </span>
                        <h1 class="card-title mb-2 text-primary">
                            <?php echo htmlspecialchars($totalOrderedQuantity) ?>
                        </h1>
                        <?php if ($orderIncrease >= 0): ?>
                            <small class="text-success fs-6">
                                <i class="bx bx-up-arrow-alt"></i> +<?= $orderIncrease ?>% 🔥
                            </small>
                        <?php else: ?>
                            <small class="text-muted fs-6">
                                <i class="bx bx-minus"></i> 0%
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Total Stock Card -->
            <div class="col-lg-4 order-1 mt-4">
                <div class="card p-2 border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-box fs-2 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="/category">
                                        <div data-i18n="view-more">View More</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">
                            <div data-i18n="totalStock">Total Stock 📦</div>
                        </span>
                        <h1 class="card-title mb-2 text-warning"><?php echo htmlspecialchars($totalStock['total'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <?php if ($addedStock >= 0): ?>
                            <small class="text-success fs-6">
                                <i class="bx bx-up-arrow-alt"></i> +<?php echo $addedStock ?> ⚡
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Weather Widget -->
            <div class="col-lg-8 mb-4 order-2 w-100">
                <div class="card p-3">
                    <h4 class="card-title text-primary text-center mb-3">
                        <div data-i18n="weatherToday">Weather Today ☀️🌧️</div>
                    </h4>
                    <div class="text-center">
                        <div id="weatherapi-weather-widget-3"></div>
                        <script type="text/javascript" src="https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3" async></script>
                        <noscript>
                            <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Phnum Penh Weather">
                                <div data-i18n="phnom-penh-weather">10 days hour by hour Phnom Penh weather</div>
                            </a>
                        </noscript>
                    </div>
                </div>
            </div>

            <!-- Money Get from Order -->
            <div class="col-lg-4 order-1 mt-4">
                <div class="card p-2 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-credit-card-alt fs-2 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <div data-i18n="today">Today</div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <div data-i18n="tomorrow">Tomorrow</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">
                            <div data-i18n="incomeMoney">Income Money 💰</div>
                        </span>
                        <h1 class="card-title mb-2 text-primary">
                            <?= htmlspecialchars($totalMoneyorder) ?>$
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Expenses -->
            <div class="col-lg-4 order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-money fs-2 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <div data-i18n="today">Today</div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <div data-i18n="tomorrow">Tomorrow</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">
                            <div data-i18n="expenses">Expenses💰</div>
                        </span>
                        <h1 class="card-title mb-2 text-info">
                            $<?= htmlspecialchars($totalCost) ?>
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Total Money -->
            <div class="col-lg-4 order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-wallet fs-2 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);" id="today">
                                        <div data-i18n="today">Today</div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" id="tomorrow">
                                        <div data-i18n="tomorrow">Tomorrow</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">
                            <div data-i18n="totalMoney">Total Money 💰</div>
                        </span>
                        <h1 class="card-title mb-2 text-info"><?php echo number_format($totalMoney['grand_total'], 2); ?>$</h1>
                        <?php if ($increment >= 0): ?>
                            <small class="text-success fs-6">
                                <i class="bx bx-up-arrow-alt"></i>
                                +<?php echo number_format($increment ?? 0, 2); ?> $ 💸
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-header text-white d-flex align-items-center justify-content-between pb-0 rounded-top">
                        <h5 class="m-0 me-2">
                            <div data-i18n="orderStatistics"></div>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="text-center">
                                <h2 class="mb-1 text-primary fw-bold"><?php echo array_sum(array_column($categoriesOrderedToday, 'total_orders')) ?></h2>
                                <span class="text-muted">
                                    <div data-i18n="totalOrders"></div>
                                </span>
                            </div>
                            <div id="orderStatisticsChart" style="min-width: 130px;"></div>
                        </div>
                        <!-- Categories List -->
                        <ul class="list-group list-group-flush mt-4">
                            <?php foreach ($categoriesOrderedToday as $category): ?>
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded-circle bg-light p-2 shadow-sm">
                                                <i class="bx bx-category fs-5 text-primary"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($category['category_name']) ?></h6>
                                            <small class="text-muted">
                                                <div data-i18n="orders"><?php echo $category['total_orders'] ?></div>
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill px-3 py-2"><?php echo $category['total_orders'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Stock -->
            <div class="col-md-6 col-lg-4 order-1 mb-4">
                <div class="card h-100 shadow-sm border-light rounded-3">
                    <div class="card-header d-flex justify-content-between align-items-center text-white rounded-top">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active btn-outline-info mx-1" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#low-stock" aria-controls="low-stock" aria-selected="true">
                                    <i class="bx bx-down-arrow-circle"></i>
                                    <div data-i18n="lowStock">Low Stock</div>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link btn-outline-info" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#high-stock" aria-controls="high-stock" aria-selected="false">
                                    <i class="bx bx-up-arrow-circle"></i>
                                    <div data-i18n="highStock">High Stock</div>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content p-0">
                        <!-- Low Stock Tab -->
                        <div class="tab-pane fade show active" id="low-stock" role="tabpanel">
                            <ul class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                                <?php foreach ($lowStockProducts as $product): ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between p-3 mb-3 shadow-sm border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars('views/products/' . $product['image']) ?>"
                                                class="rounded-circle"
                                                style="width: 50px;"
                                                alt="Product Image" />
                                            <div class="ms-3">
                                                <h6 class="mb-1 text-dark fw-bold"><?php echo $product['product_name'] ?></h6>
                                                <small class="text-muted">
                                                    <div data-i18n="stock">Stock: <span class="fw-semibold text-danger"><?php echo $product['quantity'] ?></span></div>
                                                </small>
                                            </div>
                                        </div>
                                        <a href="/products" class="btn btn-sm btn-warning px-3 fw-semibold">
                                            <div data-i18n="restore">Restore</div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- High Stock Tab -->
                        <div class="tab-pane fade m-1" id="high-stock" role="tabpanel">
                            <ul class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                                <?php foreach ($highStockProducts as $product): ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between p-3 mb-3 mx- shadow-sm border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars('views/products/' . $product['image']) ?>"
                                                class="rounded-circle"
                                                style="width: 50px;"
                                                alt="Product Image" />
                                            <div class="ms-3">
                                                <h6 class="mb-1 text-dark fw-bold"><?php echo $product['product_name'] ?></h6>
                                                <small class="text-muted">
                                                    <div data-i18n="stock">Stock: <span class="fw-semibold text-success"><?php echo $product['quantity'] ?></span></div>
                                                </small>
                                            </div>
                                        </div>
                                        <a href="/products" class="btn btn-sm btn-success px-3 fw-semibold">
                                            <div data-i18n="manage">Manage</div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphic Sale -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>
                            <div data-i18n="graphicSales">Graphic Sales</div>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            <div class="d-flex p-4 pt-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="views/assets/modules/img/icons/unicons/wallet.png" alt="User" />
                                </div>
                                <div>
                                    <small class="text-muted d-block">
                                        <div data-i18n="totalMoneyOrder">Total Money Order</div>
                                    </small>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1"><?= htmlspecialchars($totalMoneyorder) ?>$</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Income Chart -->
                            <div id="incomeChart"></div>
                            <div class="d-flex justify-content-center pt-4 gap-2">
                                <div class="flex-shrink-0">
                                    <!-- Expenses this week -->
                                    <div id="expensesOfWeek"></div>
                                </div>
                                <div>
                                    <p class="mb-n1 mt-1">
                                    <div data-i18n="quantityOrderWeek">Quantity Order this week</div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


const translations = {
        en: {
            welcome: "WELCOME! 🎉🚀",
            orderPerformance: "Boom! You've smashed it with",
            moreOrders: "% more orders",
            checkOrders: "today. Check your orders now!",
            viewOrders: "View Orders",
            productSales: "Product Sales 📈",
            incomeMoney: "Income Money 💰",
            expenses: "Expenses💰",
            totalMoney: "Total Money 💰",
            totalStock: "Total Stock 📦",
            weatherToday: "Weather Today ☀️🌧️",
            phnomPenhWeather: "10 days hour by hour Phnom Penh weather",
            orderStatistics: "📊 Order Statistics",
            totalOrders: "Total Orders",
            orders: "{0} orders",
            lowStock: "Low Stock",
            highStock: "High Stock",
            stock: "Stock:",
            restore: "Restore",
            manage: "Manage",
            graphicSales: "Graphic Sales",
            totalMoneyOrder: "Total Money Order",
            quantityOrderWeek: "Quantity Order this week",
            today: "Today",
            tomorrow: "Tomorrow",
            viewMore: "View More"
        },
        km: {
            welcome: "សូមស្វាគមន៍! 🎉🚀",
            orderPerformance: "វាយប្រហារដោយជោគជ័យជាមួយ",
            moreOrders: "% បញ្ជាទិញបន្ថែម",
            checkOrders: "ថ្ងៃនេះ។ ពិនិត្យការបញ្ជាទិញឥឡូវនេះ!",
            viewOrders: "មើលការបញ្ជាទិញ",
            productSales: "ការលក់ផលិតផល 📈",
            incomeMoney: "ប្រាក់ចំណូល 💰",
            expenses: "ចំណាយ💰",
            totalMoney: "ប្រាក់សរុប 💰",
            totalStock: "ស្តុកទំនិញសរុប 📦",
            weatherToday: "អាកាសធាតុថ្ងៃនេះ ☀️🌧️",
            phnomPenhWeather: "អាកាសធាតុ ១០ ថ្ងៃជាម៉ោងនៅភ្នំពេញ",
            orderStatistics: "📊 ស្ថិតិការបញ្ជាទិញ",
            totalOrders: "ការបញ្ជាទិញសរុប",
            orders: "{0} ការបញ្ជាទិញ",
            lowStock: "ស្តុកទាប",
            highStock: "ស្តុកខ្ពស់",
            stock: "ស្តុក៖",
            restore: "ស្ដារ",
            manage: "គ្រប់គ្រង",
            graphicSales: "ក្រាហ្វិកលក់",
            totalMoneyOrder: "ប្រាក់សរុបពីការបញ្ជាទិញ",
            quantityOrderWeek: "បរិមាណការបញ្ជាទិញសប្ដាហ៍នេះ",
            today: "ថ្ងៃនេះ",
            tomorrow: "ថ្ងៃស្អែក",
            viewMore: "មើលបន្ថែម"
        }
    };

    // Object to map languages to flag image paths
    const languageFlags = {
        en: "path/to/english-flag.png",
        km: "path/to/khmer-flag.png"
    };

    function applyTranslations(lang) {
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                // Handle keys with dynamic content
                if (key === 'orders') {
                    const orderCount = element.closest('li')?.querySelector('.badge')?.textContent || '0';
                    element.textContent = translations[lang][key].replace('{0}', orderCount);
                } else if (key === 'stock') {
                    const quantity = element.querySelector('span')?.textContent || '0';
                    element.textContent = translations[lang][key] + ' ' + quantity;
                } else if (key === 'moreOrders' || key === 'checkOrders') {
                    // Preserve surrounding dynamic content (e.g., $orderIncrease)
                    element.textContent = translations[lang][key];
                } else {
                    element.textContent = translations[lang][key];
                }
            } else {
                console.warn(`Translation key "${key}" not found for language "${lang}"`);
            }
        });
    }

    function updateFontFamily(lang) {
        document.documentElement.style.fontFamily = lang === 'km' ?
            "'Noto Sans Khmer', sans-serif" :
            "'Public Sans', sans-serif";
    }

    function updateLanguageSelector(lang) {
        const flagElement = document.getElementById('languageFlag');
        const langElement = document.getElementById('currentLang');
        if (flagElement && langElement) {
            flagElement.src = languageFlags[lang] || languageFlags['en'];
            langElement.textContent = lang.toUpperCase();
        }
    }

    function changeLanguage(lang) {
        applyTranslations(lang);
        updateFontFamily(lang);
        updateLanguageSelector(lang);
        localStorage.setItem('selectedLanguage', lang);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const selectedLanguage = localStorage.getItem('selectedLanguage') || 'en';
        changeLanguage(selectedLanguage);

        // Add event listeners for language switching
        document.querySelectorAll('#languageDropdownMenu .dropdown-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default link behavior
                const lang = e.target.getAttribute('data-lang');
                if (lang) {
                    changeLanguage(lang);
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {

        var labels = <?php echo json_encode(array_column($categoriesOrderedToday, 'category_name')); ?>;
        var series = <?php echo json_encode(array_map('intval', array_column($categoriesOrderedToday, 'total_orders'))); ?>;

        var chartOrderStatistics = document.querySelector('#orderStatisticsChart');
        var orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: labels,
            series: series,
            colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
            stroke: {
                width: 3,
                colors: ['#fff']
            },
            dataLabels: {
                enabled: false,
                formatter: function(val) {
                    return parseInt(val);
                }
            },
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                color: '#000',
                                offsetY: -15,
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function() {
                                    return '<?php echo array_sum(array_column($categoriesOrderedToday, 'total_orders')) ?>';
                                }
                            }
                        }
                    }
                }
            }
        };

        if (chartOrderStatistics) {
            var statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
            statisticsChart.render();
        }
    });

    document.getElementById('today').addEventListener('click', function() {
        fetchTotalMoney('today');
    });

    document.getElementById('tomorrow').addEventListener('click', function() {
        fetchTotalMoney('tomorrow');
    });

    function fetchTotalMoney(date) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'path_to_your_controller_method', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 1000) {
                var data = JSON.parse(xhr.responseText);
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('totalMoney').innerText = data.grand_total + '$';
                }
            }
        };

        xhr.send('date=' + date);
    }


    // ......Grapic orders ..........
    document.addEventListener("DOMContentLoaded", function() {
        var orderData = [<?php echo implode(',', array_column($orderData, 'order_count')); ?>];

        var defaultDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        // Ensure data matches default days, filling missing ones with 0
        var chartData = defaultDays.map((day, index) => orderData[index] ?? 0);

        console.log("Processed Order Data:", chartData);

        const incomeChartEl = document.querySelector("#incomeChart");

        const incomeChartConfig = {
            series: [{
                data: chartData
            }],
            chart: {
                height: 215,
                parentHeightOffset: 0,
                parentWidthOffset: 0,
                toolbar: {
                    show: false
                },
                type: "area"
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: "smooth"
            },
            legend: {
                show: false
            },
            markers: {
                size: 6,
                colors: "transparent",
                strokeColors: "transparent",
                strokeWidth: 4,
                discrete: [{
                    fillColor: "#FFF",
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    strokeColor: "#7367F0",
                    strokeWidth: 2,
                    size: 6,
                    radius: 8
                }],
                hover: {
                    size: 7
                }
            },
            colors: ["#7367F0"],
            fill: {
                type: "gradient",
                gradient: {
                    shade: "light",
                    shadeIntensity: 0.6,
                    opacityFrom: 0.5,
                    opacityTo: 0.25,
                    stops: [0, 95, 100]
                }
            },
            grid: {
                borderColor: "#ddd",
                strokeDashArray: 3,
                padding: {
                    top: -20,
                    bottom: -8,
                    left: -10,
                    right: 8
                }
            },
            xaxis: {
                categories: ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat", "Sun"],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    show: true,
                    style: {
                        fontSize: "13px",
                        colors: "#666"
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                },
                min: 0,
                tickAmount: 5
            }
        };

        if (incomeChartEl !== null) {
            const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
            incomeChart.render();
        }
    });

</script>

<style>
    /* Custom scrollbar */
    .list-group-flush::-webkit-scrollbar {
        width: 8px;
    }

    .list-group-flush::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .list-group-flush::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .list-group-flush::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>