<?php require_once "Models/foodModel.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The popular items:</h5>
    <div class="row text-center">
        <?php 
        // Filter popular products where amount > 20
        $popular_products = array_filter($products, function($product) {
            return isset($product['price'], $product['quantity']) && ($product['price'] * $product['quantity']) >= 20;
        });

        // Display the popular products
        foreach ($popular_products as $product): ?>
            <div class="col-md-3">
                <div class="card p-4 shadow-sm">
                    <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="w-100" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <div class="mt-2">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- If no popular products found -->
        <?php if (empty($popular_products)): ?>
            <p class="text-muted">No popular items found.</p>
        <?php endif; ?>
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
                                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="card-img-top w-px-50" alt="Product Image">
                                        <span class="ms-3"><?= htmlspecialchars($product['product_name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">
                                        <i class="bi bi-cup-hot me-1"></i>
                                        <?= htmlspecialchars($product['category_name']) ?>
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
                                <td>$<?= isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00' ?></td>
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

<!-- delete product function  -->
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = 'delete_product.php?id=' + id;
        }
    }
</script>

<!-- Low Stock Alert -->
<?php
$low_stock_items = [];
foreach ($products as $product) {
    if (isset($product['quantity']) && $product['quantity'] < 5) {
        $low_stock_items[] = htmlspecialchars($product['product_name']) . " (" . $product['quantity'] . " units)";
    }
}
?>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lowStockToast = new bootstrap.Toast(document.getElementById('lowStockToast'), {
            delay: 5000 
        });
        lowStockToast.show();
    });
</script>
<?php endif; ?>
