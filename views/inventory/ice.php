<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<?php require_once "Models/iceModel.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The popular items:</h5>
    <div class="row text-center">
        <?php
        $popular_items = [];
        foreach ($products as $product) {
            $amount = isset($product['price'], $product['quantity']) ? ($product['price'] * $product['quantity']) : 0;
            if ($amount > 20) {
                $popular_items[] = $product;
            }
        }

        if (!empty($popular_items)) {
            foreach ($popular_items as $product): ?>
                <div class="col-md-3">
                    <div class="card p-4 shadow-sm">
                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="w-100" alt="Popular IceDessert">
                        <div class="mt-2">⭐⭐⭐⭐⭐</div>
                    </div>
                </div>
            <?php endforeach;
        } else {
            echo "<p class='text-center text-muted'>No popular items yet.</p>";
        }
        ?>
    </div>

    <h5 class="mt-3">Drinks Transactions:</h5>

    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40px"><input class="form-check-input" type="checkbox" id="selectAll"></th>
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
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="w-px-50" alt="Product Image">
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

<!-- Delete Product Function -->
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = 'delete_product.php?id=' + id;
        }
    }
</script>
