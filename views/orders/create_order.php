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
    <div class="mt-2">
        <div class="card shadow-sm p-4">
            <h2 class="">Create Order</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Product</label>
                    <select id="product" class="form-select">
                <option value="">-- Select Product --</option>
                <?php foreach ($selectProduct as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['product_name']); ?>" 
                            data-price="<?php echo htmlspecialchars($product['price']); ?>">
                        <?php echo htmlspecialchars($product['product_name']); ?>
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
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <tr><td colspan="6" class="text-muted">No Items added</td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="card shadow-sm mt-4 p-4">
            <h4 class="">Payment Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Select Payment Mode</label>
                    <select class="form-select" id="payment-mode" name="paymentMode">
                        <option value="Cash Payment">Cash Payment</option>
                        <option value="Card Payment">Card Payment</option>
                    </select>
                </div>
            </div>
                <form id="orderForm" action="/orders/saveOrder" method="POST">
                <input type="hidden" name="orderItems" id="orderItems">
                <button type="submit" class="btn btn-warning mt-3" onclick="return placeOrder()">Proceed to Place Order</button>
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
            const price = parseFloat(productSelect.options[productSelect.selectedIndex].getAttribute('data-price'));
            const quantity = parseInt(quantityInput.value);
            const discount = parseFloat(discountInput.value);

            // Validation
            if (!productName || isNaN(price)) return;
            if (isNaN(quantity) || quantity < 1) {
                quantityInput.value = 1;
                return;
            }
            if (isNaN(discount) || discount < 0 || discount > 100) {
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
                <td>${productName}</td>
                <td>$${price.toFixed(2)} ${discount > 0 ? '(' + discount + '% off)' : ''}</td>
                <td><input type="number" value="${quantity}" min="1" class="form-control w-50 mx-auto" onchange="updateTotal(this)"></td>
                <td class="total-price">$${totalPrice.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            `;
            row.dataset.discount = discount;
            row.dataset.originalPrice = price;

            if (productList.children[0].textContent.includes("No Items added")) {
                productList.innerHTML = "";
            }
            productList.appendChild(row);

            // Reset form
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
                productList.innerHTML = '<tr><td colspan="6" class="text-muted">No Items added</td></tr>';
            }
        }

        function placeOrder() {
            const productList = document.getElementById('product-list');

            if (productList.children.length === 0 || productList.children[0].textContent.includes("No Items added")) {
                return false; // Prevent submission if no items
            }

            const paymentMode = document.getElementById('payment-mode').value;
            const orderDetails = {
                paymentMode: paymentMode,
                items: Array.from(productList.children).map(row => ({
                    productName: row.children[1].textContent,
                    originalPrice: parseFloat(row.dataset.originalPrice),
                    discount: parseFloat(row.dataset.discount),
                    quantity: parseInt(row.children[3].children[0].value),
                    totalPrice: parseFloat(row.children[4].textContent.replace('$', ''))
                }))
            };

            document.getElementById('orderItems').value = JSON.stringify(orderDetails);
            return true; // Allow form submission
        }
    </script>
</div>