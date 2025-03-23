<!DOCTYPE html>
<html lang="en">
<head>
  <title>Export Data to excel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h4 class="date-time">DateTime: <?= date('l, F jS, Y') ?></h4>
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
                    <td>
                        <?= isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>    
    </div>
</body>
</html>
