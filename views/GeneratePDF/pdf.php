<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 2.5rem;
            color: #2C3E50;
        }

        h4 {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #7F8C8D;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2980B9;
            color: white;
            font-size: 1.1rem;
        }

        td {
            background-color: #f9f9f9;
            font-size: 1rem;
            color: #34495E;
        }

        tr:hover {
            background-color: #ecf0f1;
        }

        .badge {
            background-color: #e9ecef;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.9rem;
            color: #2980B9;
        }

        .low-stock {
            color: red;
            font-weight: bold;
        }

        .high-stock {
            color: green;
            font-weight: bold;
        }

        .date-time {
            font-size: 1rem;
            color: #7F8C8D;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        /* Add responsive styling */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
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
