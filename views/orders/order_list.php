
<<<<<<< HEAD

<<div class="container-xxl flex-grow-1 container-p-y">
    <div class="orders-card px-0">
        <!-- Search Bar and Create Order Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
    <input type="text" class="form-control w-50" id="searchInput" placeholder="Search orders...">
    <div class="d-flex gap-2">
        <a href="/orders/create" class="btn btn-primary">
            <i class="bi bi-plus"></i> Create Order
        </a>
        <a href="/orders/barcode" class="btn btn-secondary">
            <i class="bi bi-upc"></i> Barcode Order
        </a>
    </div>
</div>
=======
<div class="container-xxl flex-grow-1 container-p-y">
>>>>>>> 5bfeceb066ebc66e30f10384a27add074bd809cd
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
                                                <a class="dropdown-item text-primary view-order" 
                                                    href="javascript:void(0);" 
                                                    data-order-id="<?php echo $order['order_id']; ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewOrderModal">
                                                    <i class="bi bi-eye"></i> View Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete(<?php echo $order['order_id']; ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete Order
                                                </a>
                                                <form id="delete-form-<?php echo $order['order_id'] ?>" action="/orders/delete/<?php echo $order['order_id'] ?>" method="POST" style="display:none;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                </form>
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
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastText">
                Success message here
            </div>

            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
  <!-- message alert edit and delete -->
  <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var toastElement = document.getElementById("toastMessage");
                var toastText = document.getElementById("toastText");

                <?php if (isset($_SESSION['success_message'])): ?>
                    toastText.innerHTML = "<?php echo $_SESSION['success_message']; ?>";
                    toastElement.classList.add("bg-success");
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    toastText.innerHTML = "<?php echo $_SESSION['error_message']; ?>";
                    toastElement.classList.add("bg-danger");
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                var toast = new bootstrap.Toast(toastElement, {
                    delay: 1000 // Set delay to 1000ms (1 second)
                });
                toast.show();
            });
        </script>
    <?php endif; ?>
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
                                <?php if (!empty($orderItems) && is_array($orderItems)): ?>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr class="hover-row">
                                            <td><?= htmlspecialchars($item['product_name'] ?? 'N/A'); ?></td>
                                            <td><?= number_format($item['price'] ?? 0, 2); ?></td>
                                            <td><?= $item['quantity'] ?? 0; ?></td>
                                            <td><?= number_format(($item['total_price'] ?? ($item['price'] * $item['quantity'] ?? 0)), 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No items found for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-end">
                        <h5 class="grand-total" style="font-weight: bold; color: #ff5733;">
                            <strong>Grand Total:</strong> $
                            <?= number_format($order['total_amount'] ?? 0, 2); ?>
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
    function confirmDelete(orderId) {
        document.getElementById('delete-form-' + orderId).submit();
    }
</script>


