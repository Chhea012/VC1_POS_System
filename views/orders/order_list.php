

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="orders-card px-0">
        <!-- Search Bar and Create Order Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <input type="text" class="form-control w-75" id="searchInput" placeholder="Search orders...">
            <a href="/orders/create" class="btn btn-primary">
                <i class="bi bi-plus"></i> Create Order
            </a>
        </div>
        <!-- Orders Table -->
        <div class="card border-0 shadow-lg container-fluid px-4">
            <div class="card-body p-4">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order Date</th>
                                <th>Order Time</th>
                                <th>Order Price</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            <?php foreach ($orders as $index => $order): ?>
                                <tr>
                                    <td class="text-secondary"><?php echo $index + 1; ?></td>
                                    <td class="order-date"><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                    <td class="order-time"><?php echo date('H:i:s A', strtotime($order['order_date'])); ?></td>
                                    <td>
                                        <span class="fw-bold"><?php echo htmlspecialchars($order['total_amount']); ?></span>
                                    </td>
                                    <td class="payment-status text-capitalize">
                                        <?php echo htmlspecialchars($order['payment_mode']); ?>
                                    </td>
                                    <td>
                                        <div class="action-dropdown">
                                            <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item text-primary"   data-bs-toggle="modal" data-bs-target="#viewOrderModal">
                                                        <i class="bi bi-eye"></i> View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteOrder(<?php echo $order['order_id']; ?>)">
                                                        <i class="bi bi-trash"></i> Delete Order
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa; border-radius: 8px;">
                <!-- Order Details -->
                <div class="order-details mt-4 card p-3" style="background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px;">
                    <p><strong>Order Date:</strong> <span class="text-muted"><?= $order['order_date']; ?></span></p>
                    <p><strong>Payment Mode:</strong> <i class="bi bi-cash-coin"></i> <?= ucfirst($order['payment_mode']); ?></p>
                </div>
                <!-- Order Items Details -->
                <div class="order-items mt-4">
                    <h3 class="section-title mb-3" style="color: #007bff;">Order Items Details</h3>
                    <div class="table-responsive">
                        <table class="table order-items-table table-bordered" style="border-collapse: collapse;">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                    <tr class="hover-row">
                                        <td><?= $item['product_name']; ?></td>
                                        <td><?= number_format($item['price'], 2); ?></td>
                                        <td><?= $item['quantity']; ?></td>
                                        <td><?= number_format($item['total_price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-end">
                        <h5 class="grand-total" style="font-weight: bold; color: #ff5733;">
                            <strong>Grand Total:</strong> $<?= number_format($order['total_amount'], 2); ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add custom CSS -->
<style>
    .hover-row:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .grand-total {
        font-size: 1.2em;
        color: #ff5733;
    }

    .table-dark th {
        background-color: #343a40;
        color: white;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .modal-content {
        border-radius: 10px;
    }
</style>


<script>
    // Example: Add search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#ordersTableBody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Example: View order functionality
    function viewOrder(orderId) {
        alert(`Viewing order with ID: ${orderId}`);
        // Redirect to a detailed order page or open a modal
    }

    // Example: Delete order functionality
    function deleteOrder(orderId) {
        if (confirm(`Are you sure you want to delete order with ID: ${orderId}?`)) {
            alert(`Order with ID: ${orderId} deleted`);
            // Perform deletion logic here (e.g., remove the row from the table)
        }
    }
</script>
