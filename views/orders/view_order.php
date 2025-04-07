<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
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
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        @media (max-width: 768px) {
    .container-xxl {
        padding: 10px;
    }

    .modal-body, .order-details {
        padding: 10px;
    }

    .order-items-table {
        font-size: 10px;
    }

    .order-items-table th, .order-items-table td {
        padding: 4px;
    }

    .product-image {
        width: 35px;
        height: 35px;
    }

    .order-items .table-responsive {
        overflow-x: auto;
    }

    .modal-header h5 {
        font-size: 16px;
    }

    .btn-outline-secondary {
        padding: 4px 8px;
        font-size: 12px;
    }

    .grand-total {
        font-size: 14px;
    }
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
                    <p><strong>Order Date:</strong> <span class="text-muted"><?php echo htmlspecialchars($order['order_date']); ?></span></p>
                    <p><strong>Payment Mode:</strong> <i class="bi bi-cash-coin me-1"></i> <?php echo htmlspecialchars(ucfirst($order['payment_mode'])); ?></p>
                </div>
                
                <!-- Order Items Details -->
                <div class="order-items mt-4">
                    <h3 class="section-title mb-3">Order Items Details</h3>
                    <div class="table-responsive">
                        <table class="table order-items-table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="color: white;">#</th>
                                    <th style="color: white;">Image</th>
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
                                            <td>
                                                <img src="<?php echo htmlspecialchars($item['image'] ? '/views/products/' . $item['image'] : '/views/products/default.jpg'); ?>" 
                                                     class="product-image" 
                                                     alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                     onerror="this.src='/views/products/default.jpg'">
                                            </td>
                                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                            <td><?php echo number_format($item['price'], 2); ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No items found for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
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
</body>
</html>