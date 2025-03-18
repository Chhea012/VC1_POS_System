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
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">   WELCOME! 🎉</h5>
                                <p class="mb-4">
                                    You have done <span class="fw-bold">72%</span> more sales today. Check your new orders in
                                     product.
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Order</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="views/assets/modules/img/illustrations/man-with-laptop-light.png"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img
                                            src="views/assets/modules/img/icons/unicons/chart-success.png"
                                            alt="chart success"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button
                                            class="btn p-0"
                                            type="button"
                                            id="cardOpt3"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="javascript:void(0);">Today</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Tomorrow</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Product Sale</span>
                                <h3 class="card-title mb-2">120</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img
                                            src="views/assets/modules/img/icons/unicons/wallet-info.png"
                                            alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button
                                            class="btn p-0"
                                            type="button"
                                            id="cardOpt6"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span>Product Default</span>
                                <h3 class="card-title text-nowrap mb-1">20</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- WeatherAPI Widget -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-3 w-100" >
                <div class="card">
                <h5 class="card-title text-primary text-center">Current Weather</h5>
                <div class="container-xxl flex-grow-1 container-p-y">
                <div id="weatherapi-weather-widget-3"></div>
                <script type='text/javascript' src='https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3' async></script>
                <noscript>
                    <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Hour by hour Phnum Penh weather">10 day hour by hour Phnum Penh weather</a>
                </noscript>
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
                                                <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="avatar-lg rounded-circle me-3" alt="Product Image" />
                                                <div>
                                                    <h6 class="mb-1"><?= $product['product_name'] ?></h6>
                                                    <small class="text-muted">Stock: <?= $product['quantity'] ?></small>
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
                                                <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="avatar-lg rounded-circle me-3" alt="Product Image" />
                                                <div>
                                                    <h6 class="mb-1"><?= $product['product_name'] ?></h6>
                                                    <small class="text-muted">Stock: <?= $product['quantity'] ?></small>
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
