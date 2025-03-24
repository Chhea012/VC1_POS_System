
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .view-order-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
        }
        .section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            position: relative;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #6b48ff;
        }
        .order-details p, .user-details p {
            margin-bottom: 0.5rem;
        }
        .order-items-table th {
            background: #6b48ff;
            color: white;
            border: none;
        }
        .order-items-table td {
            vertical-align: middle;
        }
        .back-link {
            color: #6b48ff;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #5a3ed1;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="view-order-card">
            <!-- Back Link -->
            <a href="/orders" class="back-link"><i class="bi bi-arrow-left me-1"></i> Back to Orders</a>

            <!-- Order Details -->
            <div class="order-details mt-4">
                <h3 class="section-title">Order Details</h3>
                <p><strong>Tracking No:</strong> 654801845</p>
                <p><strong>Order Date:</strong> 14 Aug. 2023</p>
                <p><strong>Order Status:</strong> booked</p>
                <p><strong>Payment Mode:</strong> Cash Payment</p>
            </div>
            <!-- Order Items Details -->
            <div class="order-items mt-4">
                <h3 class="section-title">Order Items Details</h3>
                <div class="table-responsive">
                    <table class="table order-items-table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mi Note 8 Pro</td>
                                <td>16,000</td>
                                <td>2</td>
                                <td>32,000</td>
                            </tr>
                            <tr>
                                <td>T-Shirt</td>
                                <td>399</td>
                                <td>1</td>
                                <td>399</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-end">
                    <h5 class=""><strong>Grand Total:</strong> $32,399</h5>
                </div>
            </div>
        </div>
    </div>
    