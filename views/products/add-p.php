<?php

    require_once __DIR__ . "/../../Models/add_productModel.php";

?>

<div class="m-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-secondary">Add a new product</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary">Discard</button>
            <button type="button" class="btn btn-outline-primary">Save draft</button>
            <button type="submit" form="productForm" class="btn btn-primary">Publish Product</button>
        </div>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

    <form id="productForm" method="POST" action="/addProduct/store" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Product Information -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-4">Product Information</h2>

                        <div class="mb-3">
                            <input type="text" name="title" class="form-control" placeholder="Product title..." required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="Drinks">Drinks</option>
                                    <option value="Noodle">Noodle</option>
                                    <option value="Pizza">Pizza</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Barcode</label>
                                <input type="text" name="barcode" class="form-control" placeholder="0123-3434-2323">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Quantity New</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Quantity" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Description (Optional)</label>
                            <div class="border rounded">
                                <div class="border-bottom p-2 bg-light">
                                    <button type="button" class="btn btn-sm btn-light me-1"><i class="bi bi-type-bold"></i></button>
                                    <button type="button" class="btn btn-sm btn-light me-1"><i class="bi bi-type-italic"></i></button>
                                    <button type="button" class="btn btn-sm btn-light me-1"><i class="bi bi-list-ul"></i></button>
                                    <button type="button" class="btn btn-sm btn-light me-1"><i class="bi bi-list-ol"></i></button>
                                    <button type="button" class="btn btn-sm btn-light me-1"><i class="bi bi-link"></i></button>
                                    <button type="button" class="btn btn-sm btn-light"><i class="bi bi-image"></i></button>
                                </div>
                                <textarea name="description" class="form-control border-0" rows="6" placeholder="Product Description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price and Image -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h5 mb-4">Price</h2>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Base Price</label>
                            <input type="number" name="base_price" class="form-control" placeholder="Price..." min="0" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Discounted Price</label>
                            <input type="number" name="discounted_price" class="form-control" placeholder="Discounted price..." min="0" step="0.01">
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">In-stock</label>
                            <div class="form-check form-switch">
                                <input name="in_stock" class="form-check-input" type="checkbox" role="switch" checked>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-4">Product Image</h2>

                        <div class="border border-2 border-dashed rounded p-4 text-center">
                            <!-- Image Preview Container -->
                            <div class="mb-3" id="imagePreviewContainer">
                                <div class="rounded-circle bg-light p-3 d-inline-block" id="defaultIcon">
                                    <i class="bi bi-image text-secondary fs-4"></i>
                                </div>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded d-none" style="max-width: 100px;">
                            </div>

                            <p class="text-secondary mb-1">Drop your image here</p>
                            <p class="text-muted small mb-3">or</p>

                            <!-- File Input -->
                            <div class="input-group">
                                <input type="file" name="product_image" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="image/*">
                            </div>

                            <!-- Error Message -->
                            <small id="fileError" class="text-danger d-none">Invalid file type. Please upload a JPG, PNG, or GIF.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("inputGroupFile04").addEventListener("change", function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById("imagePreview");
        const defaultIcon = document.getElementById("defaultIcon");
        const fileError = document.getElementById("fileError");

        if (file) {
            // Validate image type
            const validTypes = ["image/jpeg", "image/png", "image/gif"];
            if (!validTypes.includes(file.type)) {
                fileError.classList.remove("d-none"); // Show error message
                preview.classList.add("d-none"); // Hide preview
                defaultIcon.classList.remove("d-none"); // Show default icon
                return;
            }

            fileError.classList.add("d-none"); // Hide error if valid

            // Read and show image preview
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove("d-none");
                defaultIcon.classList.add("d-none");
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add("d-none");
            defaultIcon.classList.remove("d-none");
        }
    });
});

</script>