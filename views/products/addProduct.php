<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<div class="m-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal"> Import Excel </button>
        <div class="d-flex gap-2">
            <a href="/products" class="btn btn-outline-secondary" >Discard</a>
            
            <button type="submit" form="productForm" class="btn btn-primary">Publish Product</button>
        </div>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form id="productForm" method="POST" action="/products/store" enctype="multipart/form-data">
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
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>Select a category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="barcode" class="form-label small text-secondary">Barcode</label>
                                <input type="text" name="barcode" class="form-control" id="barcode" placeholder="0123-3434-2323">
                                <span id="barcode-error" style="color: red;"></span>
                                <div id="barcodeError" class="invalid-feedback">Barcode already exists!</div>
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
                            <label class="form-label small text-secondary">Cost Price</label>
                            <input type="number" name="cost_price" class="form-control" placeholder="Cost ..." min="0" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Base Price</label>
                            <input type="number" name="base_price" class="form-control" placeholder="Price..." min="0" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Discounted Price</label>
                            <input type="number" name="discounted_price" class="form-control" placeholder="Discounted price..." min="0" step="0.01">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-4">Product Image</h2>

                        <div class="border border-2 border-dashed rounded p-4 text-center">
                            <div class="mb-3" id="imagePreviewContainer">
                                <div class="rounded-circle bg-light p-3 d-inline-block" id="defaultIcon">
                                    <i class="bi bi-image text-secondary fs-4"></i>
                                </div>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded d-none" style="max-width: 100px;">
                            </div>

                            <p class="text-secondary mb-1">Drop your image here</p>
                            <p class="text-muted small mb-3">or</p>

                            <div class="input-group">
                                <input type="file" name="product_image" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="image/*">
                            </div>

                            <small id="fileError" class="text-danger d-none">Invalid file type. Please upload a JPG, PNG, or GIF.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal: Import Products -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Products from Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/products/import" method="POST" enctype="multipart/form-data" id="importForm">
          <div class="mb-3 text-center">
            <!-- Hidden file input -->
            <input type="file" name="excel_file" id="excel_file" class="d-none" accept=".xlsx,.xls" required>
            <!-- Clickable icon to trigger file input -->
            <div class="import-icon-container">
              <i class="bi bi-file-earmark-arrow-up import-icon" id="importIcon"></i>
              <p class="mt-2" id="fileName">Click the icon to select an Excel file</p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="importForm" class="btn btn-primary" id="importButton">Import</button>
      </div>
    </div>
  </div>
</div>
<script>
    // Image Preview Handling
    document.getElementById("inputGroupFile04").addEventListener("change", function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById("imagePreview");
        const defaultIcon = document.getElementById("defaultIcon");
        const fileError = document.getElementById("fileError");

        if (file) {
            const validTypes = ["image/jpeg", "image/png", "image/gif"];
            if (!validTypes.includes(file.type)) {
                fileError.classList.remove("d-none");
                preview.classList.add("d-none");
                defaultIcon.classList.remove("d-none");
                return;
            }

            fileError.classList.add("d-none");
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

    // Form Validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('productForm');
        const barcodeInput = document.getElementById('barcode');
        const barcodeError = document.getElementById('barcodeError');

        barcodeInput.addEventListener('input', function() {
            barcodeInput.classList.remove('is-invalid');
            barcodeError.style.display = 'none';
        });

        form.addEventListener('submit', function(event) {
            // Add custom validation if needed, otherwise let it submit
        });
    });
</script>
<!-- Custom CSS for Icon Styling -->
<style>
  .import-icon-container {
    cursor: pointer;
    padding: 20px;
    border: 2px dashed #ccc;
    border-radius: 8px;
    transition: border-color 0.3s ease;
  }
  .import-icon-container:hover {
    border-color: #007bff;
  }
  .import-icon {
    font-size: 3rem;
    color: #007bff;
  }
  #fileName {
    color: #6c757d;
    font-size: 0.9rem;
  }
</style>

<!-- JavaScript for Icon Click and File Selection -->
<script>
document.getElementById('importIcon').addEventListener('click', function () {
  document.getElementById('excel_file').click();
});

document.getElementById('excel_file').addEventListener('change', function () {
  const fileNameElement = document.getElementById('fileName');
  if (this.files.length > 0) {
    fileNameElement.textContent = this.files[0].name;
  } else {
    fileNameElement.textContent = 'Click the icon to select an Excel file';
  }
});

// Reset form on modal close
document.getElementById('importModal').addEventListener('hidden.bs.modal', function () {
  const form = document.getElementById('importForm');
  const fileNameElement = document.getElementById('fileName');
  form.reset();
  fileNameElement.textContent = 'Click the icon to select an Excel file';
});
</script>