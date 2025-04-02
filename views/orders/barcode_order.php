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
        <!-- Barcode Input Section -->
        <div class="mt-2">
            <div class="card shadow-sm p-5">
                <h2>Order Product using Barcode</h2>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Scan Barcode</label>
                        <input type="text" id="barcodeInput" class="form-control" placeholder="Scan barcode..." autofocus>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Product</label>
                        <input type="text" id="productNameInput" class="form-control" placeholder="Product name..." disabled>
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

            <!-- Product List Table -->
            <div class="card shadow-sm mt-4 p-4">
                <h3 class="text-gray">Products</h3>
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
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
            <!-- Payment Details -->
            <div class="card shadow-sm mt-4 p-4">
                <h4>Payment Details</h4>
                <div class="row">
                    <div class="col-md-6">
                    <select class="form-select" id="payment-mode" name="paymentMode">
                        <option value="">Select Payment Mode</option>
                        <?php foreach ($data['paymentModes'] as $mode): ?>
                            <option value="<?php echo htmlspecialchars($mode); ?>">
                                <?php echo htmlspecialchars($mode); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>
                <form id="orderForm" action="/orders/saveOrder" method="POST">
                    <input type="hidden" name="orderItems" id="orderItems">
                    <button type="submit" class="btn btn-warning mt-3" onclick="return placeOrder()">Proceed to Place Order</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let idCounter = 1;
        let currentProduct = null; // Store fetched product temporarily

        // Barcode input listener
        document.getElementById('barcodeInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                fetchProductByBarcode(this.value);
                this.value = ''; // Clear input after scanning
            }
        });

        // Fetch product by barcode from server
        function fetchProductByBarcode(barcode) {
            fetch(`/orders/getProductByBarcode?barcode=${barcode}`)
                .then(response => response.json())
                .then(product => {
                    if (product && product.name && product.price) {
                        currentProduct = product;
                        document.getElementById('productNameInput').value = product.name; // Display product name
                    } else {
                        alert('Product not found');
                        document.getElementById('productNameInput').value = '';
                        currentProduct = null;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error fetching product');
                });
        }

        // Add item to the product list
        function addItem() {
            // if (!currentProduct) {
            //     alert('Please scan a valid barcode first');
            //     return;
            // }

            const quantityInput = document.getElementById('quantity');
            const discountInput = document.getElementById('discount');
            const quantity = parseInt(quantityInput.value);
            const discount = parseFloat(discountInput.value);

            if (isNaN(quantity) || quantity < 1 || isNaN(discount) || discount < 0 || discount > 100) {
                alert('Invalid quantity or discount');
                return;
            }

            const discountMultiplier = 1 - (discount / 100);
            const discountedPrice = currentProduct.price * discountMultiplier;
            const totalPrice = discountedPrice * quantity;

            const productList = document.getElementById('product-list');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idCounter++}</td>
                <td>${currentProduct.name}</td>
                <td>$${currentProduct.price.toFixed(2)} ${discount > 0 ? '(' + discount + '% off)' : ''}</td>
                <td><input type="number" value="${quantity}" min="1" class="form-control w-50 mx-auto" onchange="updateTotal(this)"></td>
                <td class="total-price">$${totalPrice.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            `;
            row.dataset.discount = discount;
            row.dataset.originalPrice = currentProduct.price;

            if (productList.children[0].textContent.includes("No Items added")) {
                productList.innerHTML = '';
            }
            productList.appendChild(row);

            // Reset inputs after adding
            document.getElementById('productNameInput').value = '';
            quantityInput.value = 1;
            discountInput.value = 0;
            currentProduct = null;
        }

        // Update total price when quantity changes
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
            const totalPrice = originalPrice * discountMultiplier * quantity;
            row.querySelector('.total-price').textContent = `$${totalPrice.toFixed(2)}`;
        }

        // Remove item from the list
        function removeItem(button) {
            const row = button.parentElement.parentElement;
            row.remove();
            const productList = document.getElementById('product-list');
            if (productList.children.length === 0) {
                productList.innerHTML = '<tr><td colspan="6" class="text-muted">No Items added</td></tr>';
            }
        }

        // Handle form submission
        function placeOrder() {
            const productList = document.getElementById('product-list');
            const paymentMode = document.getElementById('payment-mode').value;
            const items = [];

            if (productList.children.length === 0 || productList.children[0].textContent.includes("No Items added")) {
                alert('No items in the order');
                return false;
            }

            if (!paymentMode) {
                alert('Please select a payment mode');
                return false;
            }

            // Collect order items
            Array.from(productList.children).forEach(row => {
                const name = row.children[1].textContent;
                const price = parseFloat(row.dataset.originalPrice);
                const discount = parseFloat(row.dataset.discount);
                const quantity = parseInt(row.querySelector('input').value);
                const totalPrice = parseFloat(row.querySelector('.total-price').textContent.replace('$', ''));
                items.push({ name, price, discount, quantity, totalPrice });
            });

            // Set hidden input value for form submission
            document.getElementById('orderItems').value = JSON.stringify(items);
            return true; // Allow form submission
        }
    </script>
