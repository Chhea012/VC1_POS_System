

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Export Products to Excel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge { background-color: #007bff; color: white; padding: 5px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .product-image { width: 50px; height: 50px; object-fit: contain; }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="date-time">DateTime: <?= date('l, F jS, Y') ?></h4>
        <h1>Products List</h1>
        <a href="/products/create" class="btn btn-success mb-3">Create New Product</a>
        <a href="/ExportExcelController.php" class="btn btn-primary mb-3">Export to Excel</a>
        <table>
            <thead>
                <tr>
                    <th>product_name</th>
                    <th>description</th>
                    <th>category_name</th>
                    <th>price</th>
                    <th>cost_product</th>
                    <th>quantity</th>
                    <th>image</th>
                    <th>barcode</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once __DIR__ . '/Models/ProductsModel.php';
                $productManager = new ProductManager();
                $products = $productManager->getAllProducts();
                foreach ($products as $product):
                ?>
                <tr>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><span class="badge"><?= htmlspecialchars($product['category_name']) ?></span></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td>$<?= number_format($product['cost_product'], 2) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                    <td>
                        <?php if (!empty($product['image']) && $product['image'] !== "views/products/uploads/default.png" && file_exists(__DIR__ . "/" . $product['image'])): ?>
                            <img src="/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="product-image">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars((string)$product['barcode']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>