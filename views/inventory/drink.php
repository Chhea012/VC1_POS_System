<?php require_once "Models/drinkModel.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The popular items:</h5>
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <img src="views/assets/modules/img/inventory/drink/.png" class="w-75" alt="Popular Drink">
                <div class="mt-2">⭐⭐⭐⭐⭐</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <img src="views/assets/modules/img/inventory/drink/.png" class="w-75" alt="Popular Drink">
                <div class="mt-2">⭐⭐⭐⭐⭐</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <img src="views/assets/modules/img/inventory/drink/.png" class="w-75" alt="Popular Drink">
                <div class="mt-2">⭐⭐⭐⭐⭐</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <img src="views/assets/modules/img/inventory/drink/.png" class="w-75" alt="Popular Drink">
                <div class="mt-2">⭐⭐⭐⭐⭐</div>
            </div>
        </div>
        <!-- ... other items remain the same ... -->
    </div>

    <h5 class="mt-3">Drinks Transactions:</h5>
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
                            <th>AMOUNT</th>
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
                                        <i class="bi bi-info-circle-fill"></i>
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
                            <td <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'style="color: red;"' : '' ?>>
                                <?= isset($product['quantity']) ? $product['quantity'] : 'N/A' ?>
                            </td>
                            <td></td>
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

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Added Low Stock Alert Logic with Bootstrap Toast -->
<?php
// Check for low stock and prepare alert content
$low_stock_items = [];
foreach ($products as $product) {
    if (isset($product['quantity']) && $product['quantity'] < 5) {
        $low_stock_items[] = htmlspecialchars($product['product_name']) . " (" . $product['quantity'] . " units)";
    }
}
?>

<!-- Bootstrap Toast for Low Stock Alert -->
<?php if (!empty($low_stock_items)): ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="lowStockToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
            <strong class="me-auto">Low Stock Alert</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <ul class="list-unstyled mb-0">
                <?php foreach ($low_stock_items as $item): ?>
                    <li><?php echo $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

/

<!-- JavaScript to Trigger Toast on Page Load -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lowStockToast = new bootstrap.Toast(document.getElementById('lowStockToast'), {
            delay: 5000 // Auto-hide after 5 seconds (optional)
        });
        lowStockToast.show();
    });
</script>
<?php endif; ?>
