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
                                <h2 class="card-title text-primary fw-bold fs-3" data-i18n="welcome"></h2>
                                <p class="mb-4 fs-5" data-i18n="welcome_message"><span class="fw-bold text-success"><?php echo isset($orderIncrease) ? $orderIncrease : 0; ?>% more orders</span> today. Check your orders now!</p>
                                <a href="/orders/barcode" class="btn btn-primary fs-6" data-i18n="orders"></a>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="/views/assets/modules/img/illustrations/dashoad.png" height="200" alt="Illustration">
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
                                    <a href="/products" class="dropdown-item" data-i18n="view_more"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5" data-i18n="products"></span>
                        <h1 class="card-title mb-2 text-primary"><?php echo htmlspecialchars($totalOrderedQuantity) ?></h1>
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
                                    <a class="dropdown-item" href="/products" data-i18n="view_more"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5" data-i18n="inventory"></span>
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
                    <h4 class="card-title text-primary text-center mb-3" data-i18n="weathertoday"></h4>
                    <div class="text-center">
                        <div id="weatherapi-weather-widget-3"></div>
                        <script type="text/javascript" src="https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3" async></script>
                        <noscript>
                            <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Phnum Penh Weather"></a>
                        </noscript>
                    </div>
                </div>
            </div>

            <!-- Income Money Card -->
            <div class="col-lg-4 order-1 mt-4">
                <div class="card p-2 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class='bx bxs-credit-card fs-2 text-warning'></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="/products" data-i18n="view_more"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5" data-i18n="income_money"></span>
                        <h1 class="card-title mb-2 text-primary"><?= htmlspecialchars($totalMoneyorder) ?>$</h1>
                    </div>
                </div>
            </div>

            <!-- Profit Money Card -->
            <div class="col-lg-4 order-1 mt-4">
                <div class="card p-2 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class='bx bx-credit-card-alt fs-2 text-warning'></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="?date=today" data-i18n="today"></a>
                                    <a class="dropdown-item" href="?date=yesterday" data-i18n="yesterday"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5" data-i18n="profit_money">Profit Money 💰</span>
                        <h1 class="card-title mb-2 text-primary">$<?php echo isset($_GET['date']) && $_GET['date'] === 'yesterday' ? number_format($profitYesterday, 2) : number_format($profitToday, 2); ?></h1>
                    </div>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="col-lg-4 order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <a href="/products"><i class='bx bx-money fs-2 text-warning'></i></a>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="/products" data-i18n="view_more"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5" data-i18n="expenses"></span>
                        <h1 class="card-title mb-2 text-info">$<?= htmlspecialchars($totalCost) ?></h1>
                    </div>
                </div>
            </div>

            <!-- Total Money Card -->
            <div class="col-lg-4 order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-wallet fs-2 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="/products" data-i18n="view_more"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5" data-i18n="total_money"></span>
                        <h1 class="card-title mb-2 text-info"><?php echo number_format($totalMoney['grand_total'], 2); ?>$</h1>
                        <?php if ($increment >= 0): ?>
                            <small class="text-success fs-6">
                                <i class="bx bx-up-arrow-alt"></i> +<?php echo number_format($increment ?? 0, 2); ?> $ 💸
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
                        <h5 class="m-0 me-2" data-i18n="orders"></h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="text-center">
                                <h2 class="mb-1 text-primary fw-bold"><?php echo array_sum(array_column($categoriesOrderedToday, 'total_orders')) ?></h2>
                                <span class="text-muted" data-i18n="total_orders"></span>
                            </div>
                            <div id="orderStatisticsChart" style="min-width: 130px;"></div>
                        </div>
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
                                            <small class="text-muted"><?php echo $category['total_orders'] ?> <span data-i18n="orders"></span></small>
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
                                <button type="button" class="nav-link active btn-outline-info mx-1" role="tab" data-bs-toggle="tab" data-bs-target="#low-stock" aria-controls="low-stock" aria-selected="true">
                                    <i class="bx bx-down-arrow-circle"></i> <span data-i18n="low_stock"></span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link btn-outline-info" role="tab" data-bs-toggle="tab" data-bs-target="#high-stock" aria-controls="high-stock" aria-selected="false">
                                    <i class="bx bx-up-arrow-circle"></i> <span data-i18n="high_stock"></span>
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
                                            <img src="<?php echo htmlspecialchars('/views/products/' . $product['image']) ?>" class="rounded-circle" style="width: 50px;" alt="Product Image" />
                                            <div class="ms-3">
                                                <h6 class="mb-1 text-dark fw-bold"><?php echo htmlspecialchars($product['product_name']) ?></h6>
                                                <small class="text-muted" data-i18n="stock"><span class="fw-semibold text-danger"><?php echo $product['quantity'] ?></span></small>
                                            </div>
                                        </div>
                                        <a href="/products" class="btn btn-sm btn-warning px-3 fw-semibold" data-i18n="restore"></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- High Stock Tab -->
                        <div class="tab-pane fade m-1" id="high-stock" role="tabpanel">
                            <ul class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                                <?php foreach ($highStockProducts as $product): ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between p-3 mb-3 shadow-sm border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars('/views/products/' . $product['image']) ?>" class="rounded-circle" style="width: 50px;" alt="Product Image" />
                                            <div class="ms-3">
                                                <h6 class="mb-1 text-dark fw-bold"><?php echo htmlspecialchars($product['product_name']) ?></h6>
                                                <small class="text-muted" data-i18n="stock">Stock: <span class="fw-semibold text-success"><?php echo $product['quantity'] ?></span></small>
                                            </div>
                                        </div>
                                        <a href="/products" class="btn btn-sm btn-success px-3 fw-semibold" data-i18n="manage"></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphic Sales -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 data-i18n="graphic_sales">Graphic Sales</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded fs-4"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" id="today" data-i18n="this_week"></a>
                                <a class="dropdown-item" id="tomorrow" data-i18n="last_week"></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            <div class="d-flex p-4 pt-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="/views/assets/modules/img/icons/unicons/wallet.png" alt="User" />
                                </div>
                                <div>
                                    <small class="text-muted d-block" data-i18n="total_money_order"></small>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1" id="totalMoneyDisplay"><?= htmlspecialchars($totalMoneyThisWeek) ?>$</h6>
                                    </div>
                                </div>
                            </div>
                            <div id="incomeChart"></div>
                            <div class="d-flex justify-content-center pt-4 gap-2">
                                <div class="flex-shrink-0">
                                    <div id="expensesOfWeek"></div>
                                </div>
                                <div>
                                    <p class="mb-n1 mt-1" data-i18n="quantity_order_this_week"></p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // ----- Donut Chart -----
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

        // ----- Date Filter Buttons -----
        document.getElementById('today').addEventListener('click', function() {
            fetchTotalMoney('today');
        });

        document.getElementById('tomorrow').addEventListener('click', function() {
            fetchTotalMoney('tomorrow');
        });

        function fetchTotalMoney(date) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_money.php'); // Make sure this is the correct URL to handle the request
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
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

        // ----- Weekly Income Chart -----
        const thisWeekData = [<?php echo $jsOrderDataThisWeek; ?>];
        const lastWeekData = [<?php echo $jsOrderDataLastWeek; ?>];
        const totalMoneyThisWeek = <?php echo $totalMoneyThisWeek; ?>;
        const totalMoneyLastWeek = <?php echo $totalMoneyLastWeek; ?>;

        const incomeChartEl = document.querySelector("#incomeChart");
        const totalMoneyDisplay = document.querySelector("#totalMoneyDisplay");

        const incomeChartConfig = {
            series: [{
                name: "Total Sales $",
                data: thisWeekData
            }],
            chart: {
                height: 215,
                type: "area",
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: "smooth"
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
                labels: {
                    style: {
                        fontSize: "13px",
                        colors: "#666"
                    }
                }
            },
            yaxis: {
                labels: {
                    show: true
                },
                min: 0,
                tickAmount: 5
            }
        };

        if (incomeChartEl !== null) {
            const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
            incomeChart.render();

            // Handle chart filter dropdowns (This week, Last week) only
            document.querySelectorAll(".dropdown-item").forEach(item => {
                const text = item.textContent.trim();
                if (text === "This week" || text === "Last week") {
                    item.addEventListener("click", function(e) {
                        e.preventDefault();

                        if (text === "This week") {
                            incomeChart.updateSeries([{
                                name: "Total Sales $",
                                data: thisWeekData
                            }]);
                            totalMoneyDisplay.textContent = `${totalMoneyThisWeek}$`;
                        } else if (text === "Last week") {
                            incomeChart.updateSeries([{
                                name: "Total Sales $",
                                data: lastWeekData
                            }]);
                            totalMoneyDisplay.textContent = `${totalMoneyLastWeek}$`;
                        }
                    });
                }
            });
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