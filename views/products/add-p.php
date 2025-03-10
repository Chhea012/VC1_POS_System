<?php require_once 'Models/add-productModel.php'?> 

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

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form id="productForm" method="POST" action="" enctype="multipart/form-data">

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
                            <div class="mb-3">
                                <div class="rounded-circle bg-light p-3 d-inline-block">
                                    <i class="bi bi-image text-secondary fs-4"></i>
                                </div>
                            </div>
                            <p class="text-secondary mb-1">Drop your image here</p>
                            <p class="text-muted small mb-3">or</p>
                            <div class="input-group">
                                <input type="file" name="product_image" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
