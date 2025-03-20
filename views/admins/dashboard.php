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
                                <h2 class="card-title text-primary fw-bold fs-3">WELCOME! 🎉🚀</h2>
                                <p class="mb-4 fs-5">Boom! You've smashed it with <span class="fw-bold text-success">72% more sales</span> today. Check your orders now!</p>
                                <a href="#" class="btn btn-primary fs-6">View Orders</a>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="views/assets/modules/img/illustrations/man-with-laptop-light.png" height="160" alt="Illustration">
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
                                <img src="views/assets/modules/img/icons/unicons/chart-success.png" alt="Chart Success" class="rounded" width="50" height="50">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Today</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Tomorrow</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">Product Sales 📈</span>
                        <h1 class="card-title mb-2 text-primary">120</h1>
                        <small class="text-success fs-6"><i class="bx bx-up-arrow-alt"></i> +72.80% 🔥</small>
                    </div>
                </div>
            </div>

            <!-- Product Default Card -->
            <div class="col-lg-4 order-1 mt-4">
                <div class="card p-2 border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <img src="views/assets/modules/img/icons/unicons/wallet-info.png" alt="Wallet Info" class="rounded" width="50" height="50">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Today</a>
                                <a class="dropdown-item" href="javascript:void(0);">Tomorrow</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">Default Products 🛒</span>
                        <h1 class="card-title mb-2 text-success">20</h1>
                        <small class="text-success fs-6"><i class="bx bx-up-arrow-alt"></i> +28.42% 🌟</small>
                    </div>
                </div>
            </div>

            <!-- Total Stock Card --> 
            <div class="col-lg-4  order-1 mt-4">
                <div class="card p-2 border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <img src="views/assets/modules/img/icons/unicons/chart-success.png" alt="Chart Success" class="rounded" width="50" height="50">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">views More</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1 fs-5">Total Stock 📦</span>
                        <h1 class="card-title mb-2 text-warning"><?php echo htmlspecialchars($totalStock['total'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <small class="text-success fs-6"><i class="bx bx-up-arrow-alt"></i> +28.42% ⚡</small>
                    </div>
                </div>
            </div>

            <!-- Weather Widget -->
            <div class="col-lg-8 mb-4 order-2 w-100">
                <div class="card p-3">
                    <h4 class="card-title text-primary text-center mb-3">Weather Today ☀️🌧️</h4>
                    <div class="text-center">
                        <div id="weatherapi-weather-widget-3"></div>
                        <script type="text/javascript" src="https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3" async></script>
                        <noscript>
                            <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Phnum Penh Weather">10 day hour by hour Phnum Penh weather</a>
                        </noscript>
                    </div>
                </div>
            </div>

            <!-- Income​​ Card -->
            <div class="col-lg-4  order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <img src="views/assets/modules/img/icons/unicons/wallet-info.png" alt="Wallet Info" class="rounded" width="50" height="50">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Today</a>
                                <a class="dropdown-item" href="javascript:void(0);">Tomorrow</a>
                                </div>
                            </div>
                        </div>  
                        <span class="fw-semibold d-block mb-1 fs-5">Income 💰</span>
                        <h1 class="card-title mb-2 text-info"><?php echo htmlspecialchars($totalStock['total'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <small class="text-success fs-6"><i class="bx bx-up-arrow-alt"></i> +28.42% 💸</small>
                    </div>
                </div>
            </div>
            <!-- Expenses​  Card -->
            <div class="col-lg-4 order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <img src="views/assets/modules/img/icons/unicons/wallet-info.png" alt="Wallet Info" class="rounded" width="50" height="50">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Today</a>
                                <a class="dropdown-item" href="javascript:void(0);">Tomorrow</a>
                                </div>
                            </div>
                        </div>  
                        <span class="fw-semibold d-block mb-1 fs-5">Expenses 💰</span>
                        <h1 class="card-title mb-2 text-info"><?php echo htmlspecialchars($totalStock['total'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <small class="text-success fs-6"><i class="bx bx-up-arrow-alt"></i> +28.42% 💸</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1">
                <div class="card p-2 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="avatar flex-shrink-0">
                                <img src="views/assets/modules/img/icons/unicons/wallet-info.png" alt="Wallet Info" class="rounded" width="50" height="50">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>  
                        <span class="fw-semibold d-block mb-1 fs-5">Total Money 💰</span>
                        <h1 class="card-title mb-2 text-info"><?php echo htmlspecialchars($totalStock['total'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <small class="text-success fs-6"><i class="bx bx-up-arrow-alt"></i> +28.42% 💸</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Order Statistics</h5>
                            <small class="text-muted">42.82k Total Sales</small>
                        </div>
                        <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="orederStatistics"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Today</a>
                                <a class="dropdown-item" href="javascript:void(0);">Tomorrow</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">8,258</h2>
                                <span>Total Orders</span>
                            </div>
                            <div id="orderStatisticsChart"></div>
                        </div>
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Electronic</h6>
                                        <small class="text-muted">Mobile, Earbuds, TV</small>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">82.5k</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Fashion</h6>
                                        <small class="text-muted">T-shirt, Jeans, Shoes</small>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">23.8k</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Decor</h6>
                                        <small class="text-muted">Fine Art, Dining</small>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">849k</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Sports</h6>
                                        <small class="text-muted">Football, Cricket Kit</small>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">99</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Order Statistics -->

            <!-- Product Stock -->
            <div class="col-md-6 col-lg-4 order-1 mb-4">
                <div class="card h-100 shadow-sm border-light rounded-3">
                    <div class="card-header d-flex justify-content-between align-items-center  text-white rounded-top">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active btn btn-outline-info mx-1" role="tab" data-bs-toggle="tab" style="background-color: #;"
                                    data-bs-target="#low-stock" aria-controls="low-stock" aria-selected="true">
                                    <i class="bx bx-down-arrow-circle"></i> Low Stock
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link btn btn btn-outline-info" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#high-stock" aria-controls="high-stock" aria-selected="false">
                                    <i class="bx bx-up-arrow-circle"></i> High Stock
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-3">
                        <div class="tab-content">
                            <!-- Low Stock Tab -->
                            <div class="tab-pane fade show active" id="low-stock" role="tabpanel">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($lowStockProducts as $product): ?>
                                        <li class="list-group-item d-flex align-items-center justify-content-between mb-3 shadow-sm rounded">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo htmlspecialchars('views/products/' . $product['image']) ?>" class="avatar-lg rounded-circle me-3" alt="Product Image" />
                                                <div>
                                                    <h6 class="mb-1"><?php echo $product['product_name'] ?></h6>
                                                    <small class="text-muted">Stock:                                                                                     <?php echo $product['quantity'] ?></small>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-warning">Restock</button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- High Stock Tab -->
                            <div class="tab-pane fade" id="high-stock" role="tabpanel">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($highStockProducts as $product): ?>
                                        <li class="list-group-item d-flex align-items-center justify-content-between mb-3 shadow-sm rounded">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo htmlspecialchars('views/products/' . $product['image']) ?>" class="avatar-lg rounded-circle me-3" alt="Product Image" />
                                                <div>
                                                    <h6 class="mb-1"><?php echo $product['product_name'] ?></h6>
                                                    <small class="text-muted">Stock:                                                                                     <?php echo $product['quantity'] ?></small>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-success">Manage</button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Grapic sale  -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Grapic Sales</h5>
                        <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="transactionID"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                <a class="dropdown-item" href="javascript:void(0);">Last week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                <div class="d-flex p-4 pt-3">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="views/assets/modules/img/icons/unicons/wallet.png" alt="User" />
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Balance</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">$459.10</h6>
                                            <small class="text-success fw-semibold">
                                                <i class="bx bx-chevron-up"></i>
                                                42.9%
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                    <div id="incomeChart"></div>
                                    <div class="d-flex justify-content-center pt-4 gap-2">
                                        <div class="flex-shrink-0">
                                            <div id="expensesOfWeek"></div>
                                        </div>
                                        <div>
                                            <p class="mb-n1 mt-1">Expenses This Week</p>
                                            <small class="text-muted">$39 less than last week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
