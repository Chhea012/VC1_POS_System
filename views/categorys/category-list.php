<?php require_once './Models/categoryModel.php';


?> 

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Filter</h5>
            <div class="row mb-3">
                <!-- Filter Fields -->
                <div class="col-md-6">
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
                <div class="col-md-6">
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

                <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#categoryModal">
            Add Category
        </button>
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
                            <th>CATEGORY</th>
                            <th>STOCK</th>
                            <th>QTY</th>
                            <th>PRICE</th>
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
                                <span class="badge bg-primary-subtle text-primary rounded-pill">
                                    <?= isset($product['category_name']) ? htmlspecialchars($product['category_name']) : 'N/A' ?>
                                </span>
                            </td>

                            <td>
                            <?php
                                // Determine stock status based on total_quantity
                                $stock_product = 'N/A'; // Default value

                                if (isset($product['total_quantity'])) {
                                    $stock_product = ($product['total_quantity'] < 5) ? 'Low Stock' : 'High Stock';
                                }
                                ?>
                                <span class="badge <?= $stock_product === 'Low Stock' ? 'text-danger' : 'text-success' ?>">
                                    <?= $stock_product ?>
                                </span>
                            </td>
                            <td><?= isset($product['total_quantity']) ? htmlspecialchars($product['total_quantity']) : 'N/A' ?></td>

                            <td>$<?= isset($product['Price_Total']) ? number_format($product['Price_Total'], 2) : '0.00' ?></td>
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

<!-- Modal for adding a new category -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header ">
                <h5 class="modal-title fw-bold" id="categoryModalLabel">
                    <i class="bi bi-folder-plus me-2"></i> Add New Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
            <form action="/category/store" method="POST">
                    <div class="mb-3">
                        <label for="category_name" class="form-label fw-semibold">Category Name</label>
                        <input type="text" class="form-control form-control-lg rounded-3" id="category_name" name="category_name" placeholder="Enter category name" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow-sm">
                            <i class="bi bi-check-circle me-2"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



