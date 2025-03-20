<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (! isset($_SESSION['user'])) {
        header("Location: /");
        exit();
    }

?>
<?php require_once 'Models/productModel.php'?>
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
                            <div class="text-primary fs-4 fw-bold">$<?php echo $salesData['in_store']['amount']?></div>
                            <div class="small">
                                <?php echo $salesData['in_store']['orders']?> orders
                                <span class="ms-2 badge bg-success-subtle text-success">
                                    +<?php echo $salesData['in_store']['change']?>%
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
                            <div class="fs-4 fw-bold">$<?php echo $salesData['website']['amount']?></div>
                            <div class="small">
                                <?php echo $salesData['website']['orders']?> orders
                                <span class="ms-2 badge bg-success-subtle text-success">
                                    +<?php echo $salesData['website']['change']?>%
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
                            <div class="text-primary fs-4 fw-bold">$<?php echo $salesData['affiliate']['amount']?></div>
                            <div class="small">
                                <?php echo $salesData['affiliate']['orders']?> orders
                                <span class="ms-2 badge bg-danger-subtle text-danger">
                                    -<?php echo $salesData['affiliate']['change']?>%
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
                <!-- Category Filter -->
                <div class="col-md-4 w-50">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            <?php echo isset($_GET['category_id']) ? htmlspecialchars($categories[array_search($_GET['category_id'], array_column($categories, 'category_id'))]['category_name']) : 'Category'?>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <!-- Show "All Categories" Option -->
                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['category_id' => null]))?>">All Categories</a></li>

                            <!-- Loop through categories -->
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['category_id' => $category['category_id']]))?>">
                                        <?php echo htmlspecialchars($category['category_name'])?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <!-- stock  -->
                <div class="col-md-4 w-50">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            <?php echo isset($_GET['stock']) ? ucfirst($_GET['stock']) . ' Stock' : 'Stock'?>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['stock' => null]))?>">All Stock</a></li>
                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['stock' => 'high']))?>">High Stock</a></li>
                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['stock' => 'low']))?>">Low Stock</a></li>
                        </ul>
                    </div>
                </div>

            <div class="row align-items-center mt-5 mx-0">
                        <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search product" id="productSearch" onkeyup="searchProduct()">
            </div>

                <div class="col-md-2 ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            <?php echo $itemsPerPage?>
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
                    <li>
                        <form method="POST" action="/generate/generatepdf" class="d-inline">
                            <button type="submit" class="dropdown-item" id="exportPDF">Generate PDF</button>
                        </form>
                    </li>
                        <li><a class="dropdown-item" id="exportExcel">Excel</a></li>
                    </ul>
                </div>

                <div class="col-md-2 mx-0">
                    <a href="./products/create" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#updateQuantityModal">
                        <i class="bi bi-plus-lg me-1"></i>Update QTY
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="./products/create" class="btn btn-primary w-100">
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
                                        <img src="<?php echo htmlspecialchars('views/products/' . $product['image'])?>" class="card-img-top w-px-50" alt="Product Image" >
                                        <span class="ms-3"><?php echo htmlspecialchars($product['product_name'])?></span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-primary-subtle text-primary rounded-pill">
                                    <i class="bi bi-cup-hot me-1"></i>
                                    <?php echo $product['category_name']?>
                                </span>
                            </td>
                            <td>
                                <span style="color: <?php echo isset($product['quantity']) && $product['quantity'] < 5 ? 'red' : 'green'?>;">
                                <?php echo isset($product['quantity']) && $product['quantity'] < 5 ? 'Low stock' : 'High stock'?>
                                </span>
                            </td>
                            <td>$<?php echo isset($product['price']) ? number_format($product['price'], 2) : '0.00'?></td>
                            <td><?php echo isset($product['quantity']) ? $product['quantity'] : 'N/A'?></td>
                            <td>
                                <div class="dropdown">
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/products/view/<?php echo $product['product_id']?>"><i class="bi bi-eye me-2"></i>View</a></li>
                                        <li>
                                        <a class="dropdown-item" href="/products/edit/<?php echo $product['product_id']?>">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                        </li>
                                        <li>
                                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete(<?php echo $product['product_id']?>)">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </a>
                                        <form id="delete-form-<?php echo $product['product_id']?>" action="/products/delete/<?php echo $product['product_id']?>" method="POST" style="display:none;">
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
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
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''?>">
                <a class="page-link" href="?page=<?php echo $currentPage - 1?>&items=<?php echo $itemsPerPage?>">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''?>">
                    <a class="page-link" href="?page=<?php echo $i?>&items=<?php echo $itemsPerPage?>"><?php echo $i?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''?>">
                <a class="page-link" href="?page=<?php echo $currentPage + 1?>&items=<?php echo $itemsPerPage?>">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- update quantity product -->
<div class="modal fade" id="updateQuantityModal" tabindex="-1" aria-labelledby="updateQuantityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateQuantityModalLabel">Update Product Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateQuantityForm" method="POST" action="/products/updateQuantity">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <select name="product_id" class="form-select" id="productSelect" required>
                            <option value="" selected disabled>Choose product</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?php echo htmlspecialchars($product['product_id']); ?>" 
                                        data-quantity="<?php echo htmlspecialchars($product['quantity']); ?>">
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="currentQuantity" class="form-label">Current Quantity</label>
                        <input type="number" id="currentQuantity" class="form-control" 
                               placeholder="Select a product" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="newQuantity" class="form-label">New Quantity</label>
                        <input type="number" name="new_quantity" id="newQuantity" class="form-control" 
                               placeholder="Enter new quantity" min="0" required>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="updateQuantityForm" class="btn btn-primary">Update Quantity</button>
            </div>
        </div>
    </div>
</div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
        <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastText">
                    Success message here
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var toastElement = document.getElementById("toastMessage");
            var toastText = document.getElementById("toastText");

            <?php if (isset($_SESSION['success_message'])): ?>
                toastText.innerHTML = "<?php echo $_SESSION['success_message']; ?>";
                toastElement.classList.add("bg-success");
            <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                toastText.innerHTML = "<?php echo $_SESSION['error_message']; ?>";
                toastElement.classList.add("bg-danger");
            <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            var toast = new bootstrap.Toast(toastElement, {
                delay: 1000 // Set delay to 1000ms (1 second)
            });
            toast.show();
        });
    </script>
<?php endif; ?>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("productSelect");
    const currentQuantityInput = document.getElementById("currentQuantity");

    productSelect.addEventListener("change", function () {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const quantity = selectedOption.getAttribute("data-quantity");
        
        if (quantity !== null) {
            currentQuantityInput.value = quantity;
        } else {
            currentQuantityInput.value = "";
        }
    });
});
</script>


<script>
function confirmDelete(product_id) {
    if (confirm('Are you sure you want to delete this product?')) {
        document.getElementById('delete-form-' + product_id).submit();
    }
}

document.getElementById('barcode').addEventListener('blur', function() {
    const barcode = this.value;
    const errorElement = document.getElementById('barcode-error');

    if (barcode) {
        fetch(`/products/check-barcode?barcode=${barcode}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    errorElement.textContent = 'This barcode already exists!';
                    document.getElementById('barcode').classList.add('is-invalid');
                } else {
                    errorElement.textContent = '';
                    document.getElementById('barcode').classList.remove('is-invalid');
                }
            })
            .catch(() => {
                errorElement.textContent = 'Error checking barcode.';
            });
    }
});

</script>


