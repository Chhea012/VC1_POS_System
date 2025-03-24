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
            <a href="/orders/create" class="back-link btn btn-primary"><i class="bi bi-arrow-left me-1"></i> Back to create order</a>
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
                        <p class="mb-1"><strong>Invoice Date:</strong> 14 Aug 2023</p>
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
                        <tr>
                            <td>1</td>
                            <td>Mi Note 8 Pro</td>
                            <td>16,000</td>
                            <td>2</td>
                            <td>32,000</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>T-Shirt</td>
                            <td>399</td>
                            <td>1</td>
                            <td>399</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Grand Total and Payment Mode -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5 id="grand-total"><strong>Grand Total:</strong> 32,399</h5>
                <p class="mb-0"><strong>Payment Mode:</strong> Cash Payment</p>
            </div>
        </div>
    </div>
    <!-- Action Buttons -->
    <div class="d-flex justify-content-end gap-3 mt-4">
        <a href="/orders" class="btn btn-primary"><i class="bi bi-floppy-fill me-2"></i>Save</a>
        <button type="button" id="print-btn" class="btn btn-primary"><i class="bi bi-printer-fill me-2"></i>Print</button>
        <button type="button" id="download-btn" class="btn btn-primary"><i class="bi bi-file-earmark-arrow-down-fill me-2"></i>Download PDF</button>
    </div>
</div>