<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<style>
    @media (max-width: 768px) {
        .create-order-btn {
            font-size: 12px;
            padding: 6px 10px;
        }

        .form-label {
            font-size: 10px;
        }

        .form-control, .form-select {
            font-size: 10px;
            padding: 5px;
        }

        table.table {
            width: 100%;
            table-layout: fixed; 
            font-size: 5px;
        }

        .table th, .table td {
            font-size: 7px;
            padding: 5px;
        }

        .table td img {
            width: 35px !important;
            height: 35px !important;
        }

        .btn {
            font-size: 10px;
            padding: 6px 8px;
        }

        .card h2, .card h3, .card h4 {
            font-size: 13px;
        }

        .w-50 {
            width: 90% !important;
        }

        .container-xxl {
            padding: 10px;
        }

        .row.mb-3 > div {
            margin-bottom: 10px;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            gap: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex gap-2">
        <a href="/orders/barcode" class="btn btn-outline-primary create-order-btn">
            <i class="bi bi-upc"></i> Barcode Order
        </a>
        <a href="/orders/create" class="btn btn-primary">
            <i class="bi bi-plus"></i> Create Order
        </a>
    </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php if (isset($_SESSION['error_orders'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error_orders']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_orders']); ?>
    <?php endif; ?>

    <div class="">
        <div class="card shadow-sm p-4">
            <h2>Create Order</h2>
            <div class="row mb-3">
                <div class="col-md-6 col-12">
                    <label class="form-label fw-bold">Product</label>
                    <select id="product" class="form-select">
                        <option value="">Select Product</option>
                        <?php foreach ($selectProduct as $product): ?>
                            <option value="<?= htmlspecialchars($product['product_name']) ?>"
                                data-price="<?= htmlspecialchars($product['price']) ?>"
                                data-id="<?= htmlspecialchars($product['product_id']) ?>"
                                data-image="<?= htmlspecialchars($product['image'] ? '/views/products/' . $product['image'] : '/views/products/default.jpg') ?>">
                                <?= htmlspecialchars($product['product_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Discount (%)</label>
                    <input type="number" id="discount" class="form-control" value="0" min="0" max="100">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Quantity</label>
                    <input type="number" id="quantity" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="addItem()">Add Item</button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4 p-4">
            <h3 class="text-gray">Products</h3>
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th style="color: white;">#</th>
                        <th style="color: white;">Image</th>
                        <th style="color: white;">Product Name</th>
                        <th style="color: white;">Price</th>
                        <th style="color: white;">Quantity</th>
                        <th style="color: white;">Total Price</th>
                        <th style="color: white;">Remove</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <tr>
                        <td colspan="7" class="text-muted">No Items added</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card shadow-sm mt-4 p-4">
            <h4>Payment Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Payment Mode</label>
                    <select class="form-select" id="payment-mode" name="paymentMode">
                        <option value="">Select Payment Mode</option>
                        <?php foreach ($data['paymentModes'] as $mode): ?>
                            <option value="<?= htmlspecialchars($mode) ?>">
                                <?= htmlspecialchars($mode) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <form id="orderForm" action="/orders/saveOrder" method="POST">
                <input type="hidden" name="orderItems" id="orderItems">
                <button type="submit" class="btn btn-warning mt-3" onclick="return placeOrder()">Place Order</button>
            </form>
        </div>
    </div>

    <script>
        let idCounter = 1;

        function addItem() {
            const productSelect = document.getElementById('product');
            const quantityInput = document.getElementById('quantity');
            const discountInput = document.getElementById('discount');
            const productName = productSelect.value;
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const productId = selectedOption.getAttribute('data-id');
            const imageSrc = selectedOption.getAttribute('data-image');
            const quantity = parseInt(quantityInput.value);
            const discount = parseFloat(discountInput.value) || 0;

            if (!productName || isNaN(price) || !productId) {
                alert('Please select a valid product');
                return;
            }
            if (isNaN(quantity) || quantity < 1) {
                alert('Quantity must be at least 1');
                quantityInput.value = 1;
                return;
            }
            if (discount < 0 || discount > 100) {
                alert('Discount must be between 0 and 100');
                discountInput.value = 0;
                return;
            }

            const discountMultiplier = 1 - (discount / 100);
            const discountedPrice = price * discountMultiplier;
            const totalPrice = discountedPrice * quantity;

            const productList = document.getElementById('product-list');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idCounter++}</td>
                <td><img src="${imageSrc}" class="card-img-top" style="width: 50px; height: 50px; object-fit: cover;" alt="${productName}" onerror="this.src='/views/products/default.jpg'"></td>
                <td>${productName}</td>
                <td>$${price.toFixed(2)} ${discount > 0 ? '(' + discount + '% off)' : ''}</td>
                <td><input type="number" value="${quantity}" min="1" class="form-control w-50 mx-auto" onchange="updateTotal(this)"></td>
                <td class="total-price">$${totalPrice.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            `;
            row.dataset.discount = discount;
            row.dataset.originalPrice = price;
            row.dataset.productId = productId; // Still stored in dataset for backend use, just not displayed

            if (productList.children[0].textContent.includes("No Items added")) {
                productList.innerHTML = "";
            }
            productList.appendChild(row);

            productSelect.value = "";
            discountInput.value = "0";
            quantityInput.value = "1";
        }

        function updateTotal(input) {
            const row = input.parentElement.parentElement;
            const originalPrice = parseFloat(row.dataset.originalPrice);
            const discount = parseFloat(row.dataset.discount);
            let quantity = parseInt(input.value);

            if (isNaN(quantity) || quantity < 1) {
                input.value = 1;
                quantity = 1;
            }

            const discountMultiplier = 1 - (discount / 100);
            const discountedPrice = originalPrice * discountMultiplier;
            const totalPrice = discountedPrice * quantity;
            row.querySelector('.total-price').textContent = `$${totalPrice.toFixed(2)}`;
        }

        function removeItem(button) {
            const row = button.parentElement.parentElement;
            row.remove();
            const productList = document.getElementById('product-list');
            if (productList.children.length === 0) {
                productList.innerHTML = '<tr><td colspan="7" class="text-muted">No Items added</td></tr>';
            }
        }

        function placeOrder() {
            const productList = document.getElementById('product-list');
            const paymentMode = document.getElementById('payment-mode').value;

            if (productList.children.length === 0 || productList.children[0].textContent.includes("No Items added")) {
                alert('Please add at least one item to the order');
                return false;
            }
            if (!paymentMode) {
                alert('Please select a payment mode');
                return false;
            }

            const orderDetails = {
                paymentMode: paymentMode,
                items: Array.from(productList.children).map(row => ({
                    productName: row.children[2].textContent, // Adjusted index due to Product ID removal
                    originalPrice: parseFloat(row.dataset.originalPrice),
                    discount: parseFloat(row.dataset.discount),
                    quantity: parseInt(row.children[4].children[0].value), // Adjusted index
                    totalPrice: parseFloat(row.children[5].textContent.replace('$', '')) // Adjusted index
                }))
            };

            document.getElementById('orderItems').value = JSON.stringify(orderDetails);
            return true;
        }
    </script>
</div>

