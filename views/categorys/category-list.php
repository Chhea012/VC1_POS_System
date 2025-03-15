<?php
require_once './Models/categoryModel.php';

// Fetch existing categories from the database
$existingCategories = array_map(function ($product) {
    return strtoupper($product['category_name']);
}, $products);
?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Filters -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-4 fw-bold">Filter by Category</h5>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search Category" id="productSearch" onkeyup="searchProduct()">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                            <span id="selectedStock">Stock</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="filterStock('')"><i class="bi bi-filter me-2"></i>All</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterStock('Low Stock')"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Low Stock</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterStock('High Stock')"><i class="bi bi-check-circle me-2 text-success"></i>High Stock</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#categoryModal">
                        <i class="bi bi-plus-lg me-1"></i> Add Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fw-semibold">
                            <th width="40px">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>CATEGORY</th>
                            <th>STOCK</th>
                            <th>QTY</th>
                            <th>TOTAL</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTable">
                        <?php foreach ($products as $product): ?>
                            <?php
                            $stock_product = isset($product['total_quantity']) && $product['total_quantity'] < 5 ? 'Low Stock' : 'High Stock';
                            ?>


<tr data-category="<?php echo htmlspecialchars($product['category_name']) ?>" data-stock="<?php echo $stock_product ?>">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        <?php echo htmlspecialchars($product['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo $stock_product === 'Low Stock' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?> px-3 py-2">
                                        <i class="bi <?php echo $stock_product === 'Low Stock' ? 'bi-exclamation-circle' : 'bi-check-circle' ?> me-1"></i>
                                        <?php echo $stock_product ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($product['total_quantity']) ?></td>
                                <td>$<?php echo number_format($product['Price_Total'], 2) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light border-0 p-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"><i class="bi bi-eye me-2"></i> View</a></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="">
                                                    <i class="bi bi-trash me-2"></i> Delete
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

    </tbody>


<!-- Modal for adding a new category -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header">
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
                        <div id="categoryNameError" class="invalid-feedback">
                            Category name already exists!
                        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#categoryModal form');
        const categoryNameInput = document.getElementById('category_name');
        const categoryNameError = document.getElementById('categoryNameError');
        const existingCategories = <?php echo json_encode($existingCategories); ?>; // Use PHP to pass existing categories

        // Function to reset the input field and hide the error message
        function resetForm() {
            categoryNameInput.classList.remove('is-invalid');
            categoryNameError.style.display = 'none';
            categoryNameInput.value = ''; // Clear the input field
        }

        // Reset the form when the modal is closed
        document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function () {
            resetForm();
        });

        // Reset the form when the modal is opened
        document.getElementById('categoryModal').addEventListener('show.bs.modal', function () {
            resetForm();
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            const categoryName = categoryNameInput.value.trim().toUpperCase();

            if (existingCategories.includes(categoryName)) {
                // Show validation error inside the input field
                categoryNameInput.classList.add('is-invalid');
                categoryNameError.style.display = 'block';
            } else {
                // Hide validation error if it was shown earlier
                categoryNameInput.classList.remove('is-invalid');
                categoryNameError.style.display = 'none';
                // Proceed with form submission
                form.submit();
            }
        });

        // Clear validation error when the user starts typing
        categoryNameInput.addEventListener('input', function() {
            categoryNameInput.classList.remove('is-invalid');
            categoryNameError.style.display = 'none';
        });
    });
</script>
