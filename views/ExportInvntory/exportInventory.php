<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// if (!isset($_SESSION['user'])) {
//     header("Location: /");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inventory Report</title>
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

        th,
        td {
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
    <div class="container justify-content-between row">
    <img src="<?php echo $logoSrc . '/views/assets/modules/img/logo/logo.png'; ?>" alt="" class="img-fluid" style="width: 100px;">
            <div class="col-8">
                <p>Street: 2004, Tek Thla, Sen Sok, Phnom Penh</p>
                <p>Phone: (+855) 60 27 22 78</p>
                <p class="date-time">DateTime: <?= date('l, F jS, Y') ?></p>
            </div>
        </div>

        <h1 class="fw-bold text-center mt-3 text-center">Inventory Product Report - IceDessert</h1>
        <table>
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>CATEGORY</th>
                    <th>STOCK</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>TOTAL PRICE</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Filter products for "IceDessert"
                $filteredProducts = array_filter($products, function($product) {
                    return strtolower($product['category_name']) === 'icedessert';
                });
                ?>
                <?php if (!empty($filteredProducts)): ?>
                    <?php foreach ($filteredProducts as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['category_name']) ?></td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                            <td>$<?= number_format($product['price'] * $product['quantity'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No "IceDessert" products available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>