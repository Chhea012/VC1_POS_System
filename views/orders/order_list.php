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
    <div class="orders-card">
        <!-- Search Bar and Create Order Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <input type="text" class="form-control w-75" id="searchInput" placeholder="Search orders...">
            <a href="/orders/create" class="btn btn-primary">
                <i class="bi bi-plus"></i> Create Order
            </a>
        </div>
        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table table-custom table-bordered">
                <thead>
                    <tr>
                        <th>S1 No.</th>
                        <th>Tracking No.</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <tr>
                        <td>1</td>
                        <td>654801845</td>
                        <td>14 Aug. 2023</td>
                        <td>booked</td>
                        <td>Cash Payment</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="/orders/view" onclick="viewOrder(1)">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="deleteOrder(1)">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>115196927</td>
                        <td>10 Aug. 2023</td>
                        <td>booked</td>
                        <td>Online Payment</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item" href="/orders/view" onclick="viewOrder(2)">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="deleteOrder(2)">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
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