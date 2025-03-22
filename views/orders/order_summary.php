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
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .summary-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #ff6f61, #6b48ff);
        }
        .header-title {
            font-weight: 700;
            color: #2c3e50;
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        .header-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50%;
            height: 3px;
            background: #ff6f61;
        }
        .company-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .info-section {
            background: #e9ecef;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .table-custom th {
            background: #6b48ff;
            color: white;
            border: none;
        }
        .btn-custom {
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-save {
            background: linear-gradient(45deg, #28a745, #34c759);
            color: white;
        }
        .btn-save:hover {
            background: linear-gradient(45deg, #218838, #2db34a);
            transform: translateY(-2px);
        }
        .btn-print {
            background: linear-gradient(45deg, #ff6f61, #ff9f43);
            color: white;
        }
        .btn-print:hover {
            background: linear-gradient(45deg, #e65a50, #e68a3a);
            transform: translateY(-2px);
        }
        .btn-download {
            background: linear-gradient(45deg, #6b48ff, #a855f7);
            color: white;
        }
        .btn-download:hover {
            background: linear-gradient(45deg, #5a3ed1, #9333ea);
            transform: translateY(-2px);
        }
        .back-link {
            color: #ff6f61;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #e65a50;
        }
        #qrcode {
            text-align: center;
            margin-top: 30px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <div class="py-5">
        <div class="summary-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="header-title">Order Summary</h2>
                <a href="/orders/create" class="back-link"><i class="bi bi-arrow-left me-1"></i> Back to create order</a>
            </div>

            <!-- Company Info -->
            <div class="company-info">
                <h4 class="mb-1">Company XYZ</h4>
                <p class="mb-0 text-muted">#555, 1st street, 3rd cross, Bangalore, India</p>
                <p class="mb-0 text-muted">company_xyz pvt ltd.</p>
            </div>

            <!-- Customer and Invoice Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="text-primary mb-3"><i class="bi bi-person-fill me-2"></i>Customer Details</h5>
                        <p class="mb-1"><strong>Customer Name:</strong> User Ved</p>
                        <p class="mb-1"><strong>Customer Phone No:</strong> 9876549879</p>
                        <p class="mb-0"><strong>Customer Email Id:</strong> userved@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="text-primary mb-3"><i class="bi bi-receipt me-2"></i>Invoice Details</h5>
                        <p class="mb-1"><strong>Invoice No:</strong> INV-4407051</p>
                        <p class="mb-1"><strong>Invoice Date:</strong> 14 Aug 2023</p>
                        <p class="mb-0"><strong>Address:</strong> 1st main road, Bangalore, India</p>
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
                <h5 class="text-success"><strong>Grand Total:</strong> 32,399</h5>
                <p class="mb-0"><strong>Payment Mode:</strong> Cash Payment</p>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-3 mt-4">
                <form action="/orders">
                    <button class="btn btn-custom btn-save"><i class="bi bi-floppy-fill me-2"></i>Save</button>
                    <button class="btn btn-custom btn-print"><i class="bi bi-printer-fill me-2"></i>Print</button>
                    <button class="btn btn-custom btn-download"><i class="bi bi-file-earmark-arrow-down-fill me-2"></i>Download PDF</button>
                </form>
            </div>

            <!-- QR Code for Grand Total -->
            <div id="qrcode"></div>
        </div>
    </div>

    <script>
        window.onload = function() {
            const totalPrice = "32,399";  // The grand total or product price

            // Generate the QR code after the page has fully loaded
            QRCode.toCanvas(document.getElementById('qrcode'), totalPrice, function (error) {
                if (error) console.error(error);
                console.log('QR code generated!');
            });
        }
    </script>
</div>
