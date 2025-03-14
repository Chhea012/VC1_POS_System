<?php require_once 'Models/product-listModel.php' ?> 
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Sales Cards -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- In-store Sales -->
                <div class="col-md-4 border-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">IN-STORE SALES</div>
                            <div class="text-primary fs-4 fw-bold">$<?= $salesData['in_store']['amount'] ?></div>
                            <div class="small">
                                <?= $salesData['in_store']['orders'] ?> orders
                                <span class="ms-2 badge bg-success-subtle text-success">
                                    +<?= $salesData['in_store']['change'] ?>%
                                </span>
                            </div>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <i class="bi bi-shop fs-5"></i>
                        </div>
                    </div>
                </div>

                <!-- Website Sales -->
                <div class="col-md-4 border-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">WEBSITE SALES</div>
                            <div class="fs-4 fw-bold">$<?= $salesData['website']['amount'] ?></div>
                            <div class="small">
                                <?= $salesData['website']['orders'] ?> orders
                                <span class="ms-2 badge bg-success-subtle text-success">
                                    +<?= $salesData['website']['change'] ?>%
                                </span>
                            </div>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <i class="bi bi-laptop fs-5"></i>
                        </div>
                    </div>
                </div>

                <!-- Affiliate -->
                <div class="col-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">AFFILIATE</div>
                            <div class="text-primary fs-4 fw-bold">$<?= $salesData['affiliate']['amount'] ?></div>
                            <div class="small">
                                <?= $salesData['affiliate']['orders'] ?> orders
                                <span class="ms-2 badge bg-danger-subtle text-danger">
                                    -<?= $salesData['affiliate']['change'] ?>%
                                </span>
                            </div>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <i class="bi bi-people fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Filter</h5>
            <div class="row mb-3">
                <!-- Filter Fields -->
                <div class="col-md-4">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            Status
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li><a class="dropdown-item" href="#">Active</a></li>
                            <li><a class="dropdown-item" href="#">Inactive</a></li>
                            <li><a class="dropdown-item" href="#">Confirmed</a></li>
                            <li><a class="dropdown-item" href="#">Schedule</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            Category
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li><a class="dropdown-item" href="#">Drink</a></li>
                            <li><a class="dropdown-item" href="#">Food</a></li>
                            <li><a class="dropdown-item" href="#">Snack</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            Stock
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li><a class="dropdown-item" href="#">In Stock</a></li>
                            <li><a class="dropdown-item" href="#">Out of Stock</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-5">
                        <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search product" id="productSearch" onkeyup="searchProduct()">
            </div>

                <div class="col-md-2 ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            <?= $itemsPerPage ?>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?items=5">5</a></li>
                            <li><a class="dropdown-item" href="?items=10">10</a></li>
                            <li><a class="dropdown-item" href="?items=20">20</a></li>
                            <li><a class="dropdown-item" href="?items=50">50</a></li>
                        </ul>
                    </div>
                </div> 
                <div class="col-md-2 dropdown">
                    <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" id="exportPDF">PDF</a></li>
                        <li><a class="dropdown-item" id="exportExcel">Excel</a></li>
                        <li><a class="dropdown-item" id="exportCSV">CSV</a></li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <a href="./addproduct" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i> Add product
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40px">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>PRODUCT</th>
                            <th>CATEGORY</th>
                            <th>STOCK</th>
                            <th>PRICE</th>
                            <th>QTY</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2 text-primary">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="card-img-top w-px-50" alt="Product Image" >
                                        <span class="ms-3"><?= htmlspecialchars($product['product_name']) ?></span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-primary-subtle text-primary rounded-pill">
                                    <i class="bi bi-cup-hot me-1"></i>
                                    <?= $product['category_name'] ?>
                                </span>
                            </td>
                            <td>
                                
                                <span style="color: <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'red' : 'green' ?>;">
                                <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'Low stock' : 'High stock' ?>
                                </span>
                        
                            </td>
                            <td>$<?= isset($product['price']) ? number_format($product['price'], 2) : '0.00' ?></td>
                            <td><?= isset($product['quantity']) ? $product['quantity'] : 'N/A' ?></td>
                            <td>
                                <div class="dropdown">
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="view_product.php?id=<?= $product['product_id'] ?>"><i class="bi bi-eye me-2"></i>View</a></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $product['product_id'] ?>)">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $currentPage - 1 ?>&items=<?= $itemsPerPage ?>">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&items=<?= $itemsPerPage ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $currentPage + 1 ?>&items=<?= $itemsPerPage ?>">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>


