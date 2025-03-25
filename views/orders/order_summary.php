<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="summary-card" id="receipt-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="header-title">Order Summary</h2>
        </div>
        <div class="container py-5">
            <!-- Company Info -->
            <div class="company-info">
                <img src="/views/assets/modules/img/logo/logo.png" alt="Company Logo" width="100px">
                <h4 class="mb-1">Mak Oun Sing</h4>
                <p class="mb-0 text-muted">BP 511, Phum Tropeang Chhuk (Borey Sorla) Sangtak, Street 371, Phnom Penh</p>
            </div>

            <!-- Customer and Invoice Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="text-primary mb-3"><i class="bi bi-receipt me-2"></i>Invoice Details</h5>
                        <p class="mb-1"><strong>Invoice No:</strong> INV-4407051</p>
                        <p class="mb-1"><strong>Invoice Date:</strong> <?php echo date('d M Y', strtotime($order_date)); ?></p>
                    </div>
                </div>
            </div>

            <!-- Order Table -->
            <div class="table-responsive">
            <table class="table table-custom table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grandTotal = 0;
                        foreach ($orderItems as $index => $item) {
                            $totalPrice = $item['price'] * $item['quantity'];
                            $grandTotal += $totalPrice;
                            echo "<tr>
                                <td>" . ($index + 1) . "</td>
                                <td>" . htmlspecialchars($item['product_name']) . "</td>
                                <td>" . number_format($item['price'], 2) . "</td>
                                <td>" . $item['quantity'] . "</td>
                                <td>" . number_format($totalPrice, 2) . "</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Grand Total and Payment Mode -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5 id="grand-total"><strong>Grand Total:</strong> <?php echo number_format($grandTotal, 2); ?></h5>
                <p class="mb-0"><strong>Payment Mode:</strong> <?php echo htmlspecialchars($payment_mode); ?></p>
            </div>
        </div>
    </div>
    <!-- Action Buttons -->
    <div class="d-flex justify-content-end gap-3 mt-4">
        <a href="javascript:history.back()" class="btn btn btn-outline-secondary">CANCEL</a>
        <button type="button" id="print-btn" class="btn btn-primary"><i class="bi bi-printer-fill me-2"></i>Receipt</button>
        <a href="/orders/create/QR" class="btn btn-primary"onclick="return placeOrder()">Pay Money</a>
    </div>
</div>