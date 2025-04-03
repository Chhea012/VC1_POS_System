<style>
        .container-p-y {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .modal-body {
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .order-details {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .section-title {
            color: #007bff;
        }
        .order-items-table th {
            background-color: #212529;

        }
        .hover-row:hover {
            background-color: #f5f5f5;
        }
        .grand-total {
            font-weight: bold;
            color: #ff5733;
        }
    </style>
</head>
<body>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                <a href="/orders" type="button" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="modal-body">
                <!-- Order Details -->
                <div class="order-details mt-4 card p-3">
                    <p><strong>Order Date:</strong> <span class="text-muted"><?php echo $order['order_date']; ?></span></p>
                    <p><strong>Payment Mode:</strong> <i class="bi bi-cash-coin me-1"></i> <?php echo ucfirst($order['payment_mode']); ?></p>
                </div>
                
                <!-- Order Items Details -->
                <div class="order-items mt-4">
                    <h3 class="section-title mb-3">Order Items Details</h3>
                    <div class="table-responsive">
                    <table class="table table-hover align-middle table-striped border rounded shadow-sm">
                        <table class="table order-items-table table-bordered">
                            <thead>
                                <tr>
                                    <th style="color: white;">#</th>
                                    <th style="color: white;">Product</th>
                                    <th style="color: white;">Price</th>
                                    <th style="color: white;">Quantity</th>
                                    <th style="color: white;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($orderItems)): ?>
                            <?php $index = 0; ?>
                            <?php foreach ($orderItems as $item): ?>
                                <tr class="hover-row">
                                    <td><?php echo ++$index; ?></td> 
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td><?php echo number_format($item['price'], 2); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No items found for this order.</td>
                            </tr>
                        <?php endif; ?>
                            </tbody>
                        </table>
                    </table>
                    </div>
                    <div class="mt-3 text-end">
                        <h5 class="grand-total">
                            <strong>Grand Total:</strong> $<?php echo number_format($order['total_amount'] ?? 0, 2); ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>