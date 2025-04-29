<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<?php
require_once './Models/CategorysModel.php';

// Fetch existing categories from the database
$existingCategories = array_map(function ($product) {
    return strtoupper($product['category_name']);
}, $products);
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm">
        <!-- Filters and Actions -->
        <div class="card-header border-0 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                        <div class="input-group input-group-sm flex-grow-1 flex-md-grow-0" style="max-width: 220px; margin-right: 10px;">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search Category" id="productSearch" onkeyup="searchProduct()" aria-label="Search categories">
                        </div>
                        <div class="dropdown flex-md-grow-0" style="margin-right: 10px;">
                            <button class="btn btn-outline-secondary btn-sm w-100 w-md-auto d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 120px; height: 32px;">
                                <span id="selectedStock">Stock</span>
                                <i class="bi bi-chevron-down ms-2"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="filterStock('')"><i class="bi bi-filter me-2"></i>All</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterStock('Low Stock')"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Low Stock</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterStock('High Stock')"><i class="bi bi-check-circle me-2 text-success"></i>High Stock</a></li>
                            </ul>
                        </div>
                        <div class="d-flex gap-2 ms-md-auto">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal" data-bs-toggle="tooltip" title="Add a new category">
                                <i class="bi bi-plus-lg"></i> Create
                            </button>
                            <a href="/category/export" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Export categories to Excel">
                                <i class="bi bi-upload"></i> Export
                            </a>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importCategoryModal" data-bs-toggle="tooltip" title="Import categories from Excel">
                                <i class="bi bi-download"></i> Import
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Category Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fw-semibold">
                            <th width="40px" style="color: #000000;">#</th>
                            <th style="color: #000000;">CATEGORY</th>
                            <th style="color: #000000;">STOCK</th>
                            <th style="color: #000000;">QTY</th>
                            <th style="color: #000000;">TOTAL-PRICE</th>
                            <th style="color: #000000;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTable">
                        <?php foreach ($products as $product): ?>
                            <?php
                            $stock_product = isset($product['total_quantity']) && $product['total_quantity'] < 5 ? 'Low Stock' : 'High Stock';
                            ?>
                            <tr data-category="<?php echo htmlspecialchars($product['category_name']) ?>" data-stock="<?php echo $stock_product ?>">
                                <td class="text-center row-number"></td>
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
                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-category-id="<?php echo $product['category_id']; ?>" data-category-name="<?php echo htmlspecialchars($product['category_name']); ?>">
                                                    <i class="bi bi-pencil me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete(<?php echo $product['category_id'] ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                                <form id="delete-form-<?php echo $product['category_id'] ?>" action="/category/delete/<?php echo $product['category_id'] ?>" method="POST" style="display:none;">
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
    <!-- Modal for importing categories -->
    <div class="modal fade" id="importCategoryModal" tabindex="-1" aria-labelledby="importCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="importCategoryModalLabel">
                        <i class="bi bi-download"></i> Import Categories
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="/category/import" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="category_file" class="form-label fw-semibold">Upload Excel File</label>
                            <input type="file" class="form-control form-control-lg rounded-3" id="category_file" name="category_file" accept=".xlsx, .xls" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-3 shadow-sm">
                                <i class="bi bi-download"></i> Import Categories
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for editing a category -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editCategoryModalLabel">
                        <i class="bi bi-pencil me-2"></i> Edit Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" id="editCategoryForm">
                        <input type="hidden" id="edit_category_id" name="category_id">
                        <div class="mb-3">
                            <label for="edit_category_name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" class="form-control form-control-lg rounded-3" id="edit_category_name" name="category_name" placeholder="Enter category name" required>
                            <div id="editCategoryNameError" class="invalid-feedback">
                                Category name already exists!
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
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
    <!-- Message alert for edit, delete, import, and export -->
    <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var toastElement = document.getElementById("toastMessage");
                var toastText = document.getElementById("toastText");

                <?php if (isset($_SESSION['success_message'])): ?>
                    toastText.innerHTML = "<?php echo htmlspecialchars($_SESSION['success_message']); ?>";
                    toastElement.classList.add("bg-success");
                    toastElement.classList.remove("bg-danger");
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    toastText.innerHTML = "<?php echo htmlspecialchars($_SESSION['error_message']); ?>";
                    toastElement.classList.add("bg-danger");
                    toastElement.classList.remove("bg-success");
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                var toast = new bootstrap.Toast(toastElement, {
                    delay: 3000
                });
                toast.show();
            });
        </script>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // Modal and form variables
            const editCategoryModal = document.getElementById('editCategoryModal');
            const editCategoryForm = document.getElementById('editCategoryForm');
            const editCategoryNameInput = document.getElementById('edit_category_name');
            const editCategoryNameError = document.getElementById('editCategoryNameError');
            const existingCategories = <?php echo json_encode($existingCategories); ?>;

            // Function to reset the form
            function resetEditForm() {
                editCategoryNameInput.classList.remove('is-invalid');
                editCategoryNameError.style.display = 'none';
                editCategoryNameInput.value = '';
            }

            // Reset the form when the modal is closed
            editCategoryModal.addEventListener('hidden.bs.modal', function() {
                resetEditForm();
            });

            // Populate the form when the modal is opened
            editCategoryModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const categoryId = button.getAttribute('data-category-id');
                const categoryName = button.getAttribute('data-category-name');

                // Dynamically set the form action
                editCategoryForm.action = `/category/update/${categoryId}`;
                document.getElementById('edit_category_id').value = categoryId;
                editCategoryNameInput.value = categoryName;
            });

            // Form submit handler
            editCategoryForm.addEventListener('submit', function(event) {
                const categoryName = editCategoryNameInput.value.trim().toUpperCase();
                const originalCategoryName = editCategoryModal.querySelector('a[data-bs-toggle="modal"]')?.getAttribute('data-category-name')?.toUpperCase() || '';

                // Allow the original name to be submitted without triggering the duplicate error
                if (categoryName !== originalCategoryName && existingCategories.includes(categoryName)) {
                    event.preventDefault();
                    editCategoryNameInput.classList.add('is-invalid');
                    editCategoryNameError.style.display = 'block';
                } else {
                    editCategoryNameInput.classList.remove('is-invalid');
                    editCategoryNameError.style.display = 'none';
                }
            });

            // Clear validation error when the user starts typing
            editCategoryNameInput.addEventListener('input', function() {
                editCategoryNameInput.classList.remove('is-invalid');
                editCategoryNameError.style.display = 'none';
            });
        });

        function confirmDelete(categoryId) {
            document.getElementById('delete-form-' + categoryId).submit();
        }

        function searchProduct() {
            const input = document.getElementById('productSearch').value.toLowerCase();
            const rows = document.querySelectorAll('#categoryTable tr');
            rows.forEach(row => {
                const category = row.getAttribute('data-category').toLowerCase();
                row.style.display = category.includes(input) ? '' : 'none';
            });
        }

        function filterStock(status) {
            const rows = document.querySelectorAll('#categoryTable tr');
            document.getElementById('selectedStock').textContent = status || 'Stock';
            rows.forEach(row => {
                const stock = row.getAttribute('data-stock');
                row.style.display = status === '' || stock === status ? '' : 'none';
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.row-number').forEach((cell, index) => {
                cell.textContent = index + 1;
            });
        });
    </script>