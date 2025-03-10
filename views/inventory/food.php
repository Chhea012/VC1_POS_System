<?php
// Sample array to store product data (in a real application, this would come from a database)
$products = [
    ['id' => 1, 'name' => 'Seafood Pizza', 'price' => 5.00, 'quantity' => 5, 'stock' => 'HIGH STOCK', 'status' => 'Available', 'amount' => 95.2],
    ['id' => 2, 'name' => 'Hot Dog Pizza', 'price' => 5.00, 'quantity' => 4, 'stock' => 'HIGH STOCK', 'status' => 'Available', 'amount' => 96.3],
    ['id' => 3, 'name' => 'Mixed Pizza', 'price' => 3.50, 'quantity' => 1, 'stock' => 'LOW STOCK', 'status' => 'Unavailable', 'amount' => 96.3],
    ['id' => 4, 'name' => 'Pineapple flavored pizza', 'price' => 5.00, 'quantity' => 2, 'stock' => 'LOW STOCK', 'status' => 'Available', 'amount' => 95.2],
    ['id' => 5, 'name' => 'Mama Noodles', 'price' => 1.00, 'quantity' => 3, 'stock' => 'HIGH STOCK', 'status' => 'Unavailable', 'amount' => 50],
    ['id' => 6, 'name' => 'Mama Duck Noodles', 'price' => 1.00, 'quantity' => 0, 'stock' => 'HIGH STOCK', 'status' => 'Unavailable', 'amount' => 100],
];

// Function to check and update stock status
function updateStockStatus(&$product) {
    if ($product['quantity'] < 2) {
        $product['stock'] = 'LOW STOCK';
        // Return alert message
        return "<script>alert('Low stock alert: " . $product['name'] . " has only " . $product['quantity'] . " items left!');</script>";
    } else {
        $product['stock'] = 'HIGH STOCK';
        return '';
    }
}

// Process all products and collect alerts
$alerts = '';
foreach ($products as &$product) {
    $alerts .= updateStockStatus($product);
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The popular items:</h5>
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <img src="views/assets/modules/img/food/1.png" class="w-75" alt="Orange Juice">
                <div class="mt-2">⭐⭐⭐⭐⭐</div>
            </div>
        </div>
        <!-- ... other items remain the same ... -->
    </div>

    <!-- Drinks Transactions Table -->
    <h5 class="mt-5">Drinks transactions</h5>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-white">
                <tr>
                    <th>#</th>
                    <th>Products</th>
                    <th>Prices</th>
                    <th>Quantity</th>
                    <th>Stocks</th>
                    <th>Status</th>
                    <th>Barcode</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><span class="status <?php echo strtolower(str_replace(' ', '-', $product['stock'])); ?>">
                            <?php echo $product['stock']; ?>
                        </span></td>
                        <td><span class="status <?php echo strtolower($product['status']); ?>">
                            <?php echo $product['status']; ?>
                        </span></td>
                        <td></td>
                        <td>$<?php echo number_format($product['amount'], 1); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Output all alerts -->
<?php echo $alerts; ?>