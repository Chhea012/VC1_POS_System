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
                             #
                            </th>
                            <th>CATEGORY</th>
                            <th>STOCK</th>
                            <th>QTY</th>
                            <th>TOTAL-PRICE</th>
                            <th>ACTION</th>
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
                                <td>$<?php echo number_format($product['Price_Total'] * $product['total_quantity'], 2) ?></td>
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
                    <form action="/category/update/<?php echo $product['category_id']; ?>" method="POST" id="editCategoryForm">
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
    <!-- message alert edit and delete -->
    <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
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
        document.addEventListener('DOMContentLoaded', function() {
        // Modal and form variables
        const editCategoryModal = document.getElementById('editCategoryModal');
        const editCategoryForm = document.getElementById('editCategoryForm');
        const editCategoryNameInput = document.getElementById('edit_category_name');
        const editCategoryNameError = document.getElementById('editCategoryNameError');
        const existingCategories = <?php echo json_encode($existingCategories); ?>; // Use PHP to pass existing categories

        // Function to reset the form
        function resetEditForm() {
            editCategoryNameInput.classList.remove('is-invalid');
            editCategoryNameError.style.display = 'none';
            editCategoryNameInput.value = ''; // Clear the input field
        }

        // Reset the form when the modal is closed
        editCategoryModal.addEventListener('hidden.bs.modal', function() {
            resetEditForm();
        });

        // Reset the form when the modal is opened
        editCategoryModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const categoryId = button.getAttribute('data-category-id');
            const categoryName = button.getAttribute('data-category-name');

            // Populate the form with the existing category data
            document.getElementById('edit_category_id').value = categoryId;
            editCategoryNameInput.value = categoryName;
        });

        // Form submit handler
        editCategoryForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            const categoryName = editCategoryNameInput.value.trim().toUpperCase();

            // Check if category name already exists
            if (existingCategories.includes(categoryName)) {
                // Show validation error inside the input field
                editCategoryNameInput.classList.add('is-invalid');
                editCategoryNameError.style.display = 'block';
            } else {
                // Hide validation error if it was shown earlier
                editCategoryNameInput.classList.remove('is-invalid');
                editCategoryNameError.style.display = 'none';
                // Proceed with form submission
                editCategoryForm.submit();
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

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.row-number').forEach((cell, index) => {
            cell.textContent = index + 1; // Adds numbering starting from 1
            });
        });
    </script>
    <style>
        
        .plus-btn {
        width: 18px;
        height: 18px;
        background: #696cff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        box-shadow: 
            0 3px 5px rgba(0, 0, 0, 0.2), 
            0 0 10px rgba(108, 99, 255, 0.4),
            inset 0 1px 2px rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease-in-out;
        position: relative;
    }
    
    .plus-btn:hover {
        background: linear-gradient(135deg, #5a54e0, #4038c9);
        box-shadow: 
            0 5px 10px rgba(0, 0, 0, 0.3), 
            0 0 15px rgba(108, 99, 255, 0.6);
        transform: scale(1.15) rotate(5deg);
    }
    
    </style>
