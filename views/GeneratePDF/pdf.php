<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .low-stock { color: red; }
        .high-stock { color: green; }
        .badge { background-color: #e9ecef; padding: 2px 6px; border-radius: 10px; }
    </style>
</head>
<body>
    <h1>Products List</h1>
    <table>
        <thead>
            <tr>
                <th>PRODUCT</th>
                <th>CATEGORY</th>
                <th>STOCK</th>
                <th>PRICE</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><span class="badge"><?= htmlspecialchars($product['category_name']) ?></span></td>
                <td>
                    <span class="<?= isset($product['quantity']) && $product['quantity'] < 5 ? 'low-stock' : 'high-stock' ?>">
                        <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'Low stock' : 'High stock' ?>
                    </span>
                </td>
                <td>$<?= isset($product['price']) ? number_format($product['price'], 2) : '0.00' ?></td>
                <td><?= isset($product['quantity']) ? $product['quantity'] : 'N/A' ?></td>
                <td><?= isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
