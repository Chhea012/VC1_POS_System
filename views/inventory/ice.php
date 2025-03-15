<?php require_once "Models/iceModel.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The popular items:</h5>
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <img src="views/assets/modules/img/inventory/drink/.png" class="w-75" alt="Popular IceDessert">
                <div class="mt-2">⭐⭐⭐⭐⭐</div>
            </div>
        </div>
        <!-- Repeat for other items -->
    </div>

    <h5 class="mt-3">Drinks Transactions:</h5>
    
    <?php
    // Array to store total amount per category
    $category_totals = [];

    foreach ($products as $product) {
        $category = $product['category_name'];
        $amount = isset($product['price'], $product['quantity']) ? ($product['price'] * $product['quantity']) : 0;

        // Sum amounts per category
        if (!isset($category_totals[$category])) {
            $category_totals[$category] = 0;
        }
        $category_totals[$category] += $amount;
    }
    ?>

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

<?php
$grand_total = 0; // Initialize grand total

foreach ($category_totals as $category => $total) {
    $grand_total += $total; // Sum up all category totals
}

?>
<!-- Delete Product Function -->
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = 'delete_product.php?id=' + id;
        }
    }
</script>

