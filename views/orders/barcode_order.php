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
        font-size: 11px;
        padding: 5px 8px;
        width: 100%;
    }

    .form-label {
        font-size: 12px;
    }

    .form-control, .form-select {
        font-size: 10px;
        padding: 2px 6px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table.table {
        width: 100%;
        table-layout: fixed;
        font-size: 6px;
    }

    .table th, .table td {
        font-size: 6.5px;
        padding: 4px;
        word-wrap: break-word;
    }

    .table td img {
        width: 30px !important;
        height: 30px !important;
        object-fit: cover;
    }

    .btn {
        font-size: 10px;
        padding: 5px 8px;
        width: 100%;
    }

    .btn-sm {
        font-size: 9px;
        padding: 4px 6px;
    }

    .card h2, .card h3, .card h4 {
        font-size: 13px;
    }

    .container-xxl {
        padding: 10px;
    }

    .row.mb-3 > div,
    .row.mt-3 > div {
        margin-bottom: 10px;
        width: 100%;
    }

    .col-md-2, .col-md-3, .col-md-6 {
        width: 100% !important;
    }

    .d-flex.gap-2 {
        flex-direction: column;
        gap: 10px;
    }

    .w-50 {
        width: 90% !important;
    }

    input[type="number"].form-control {
        width: 100%;
    }
}


</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex gap-2">
        <a href="/orders/barcode" class="btn btn-primary">
            <i class="bi bi-upc"></i> Barcode Order
        </a>
        <a href="/orders/create" class="btn btn-outline-primary create-order-btn">
            <i class="bi bi-plus"></i> Create Order
        </a>
    </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
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
    let currentProduct = null;

    // When a barcode is scanned, fetch the product details.
    document.getElementById('barcodeInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            fetchProductByBarcode(this.value);
            this.value = '';
        }
    });

    function fetchProductByBarcode(barcode) {
        console.log("Scanning barcode:", barcode);
        fetch(`/orders/getProductByBarcode?barcode=${barcode}`)
            .then(response => response.json())
            .then(product => {
                console.log("Fetched product:", product);

                if (!product || product.error) {
                    alert(product?.error || "Product not found");
                    document.getElementById('productNameInput').value = '';
                    currentProduct = null;
                } else {
                    currentProduct = {
                        name: product.name,
                        price: parseFloat(product.price),
                        image: product.image ? `/views/products/${product.image}` : '/views/products/default.jpg',
                        productId: product.product_id // Keep for backend use
                    };
                    document.getElementById('productNameInput').value = product.name;
                    // Automatically add the item once product details are available
                    addItem();
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Error fetching product: ' + error.message);
                document.getElementById('productNameInput').value = '';
                currentProduct = null;
            });
    }

    function addItem() {
        console.log("Trying to add item, current product:", currentProduct);

        if (!currentProduct || !currentProduct.name || isNaN(currentProduct.price)) {
            alert('No valid product selected. Please scan a barcode.');
            return;
        }

        const quantity = parseInt(document.getElementById('quantity').value);
        const discount = parseFloat(document.getElementById('discount').value) || 0;

        if (isNaN(quantity) || quantity < 1) {
            alert('Quantity must be at least 1');
            document.getElementById('quantity').value = 1;
            return;
        }
        if (isNaN(discount) || discount < 0 || discount > 100) {
            alert('Discount must be between 0 and 100');
            document.getElementById('discount').value = 0;
            return;
        }

        const discountMultiplier = 1 - (discount / 100);
        const discountedPrice = currentProduct.price * discountMultiplier;
        const totalPrice = discountedPrice * quantity;

        const productList = document.getElementById('product-list');

        if (productList.children.length === 1 && productList.children[0].textContent.includes("No Items added")) {
            productList.innerHTML = '';
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${idCounter++}</td>
            <td><img src="${currentProduct.image}" class="card-img-top" style="width: 50px; height: 50px; object-fit: cover;" alt="${currentProduct.name}" onerror="this.src='/views/products/default.jpg'"></td>
            <td>${currentProduct.name}</td>
            <td>$${currentProduct.price.toFixed(2)} ${discount > 0 ? '(' + discount + '% off)' : ''}</td>
            <td><input type="number" value="${quantity}" min="1" class="form-control w-50 mx-auto" onchange="updateTotal(this)"></td>
            <td class="total-price">$${totalPrice.toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
        `;
        row.dataset.discount = discount;
        row.dataset.originalPrice = currentProduct.price;
        row.dataset.productId = currentProduct.productId; // Store productId for backend use

        productList.appendChild(row);

        console.log("Product added:", currentProduct.name);

        // Clear the product display and reset quantity/discount for next entry
        document.getElementById('productNameInput').value = '';
        document.getElementById('quantity').value = 1;
        document.getElementById('discount').value = 0;
        currentProduct = null;
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
        const totalPrice = originalPrice * discountMultiplier * quantity;
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
        const items = [];

        if (productList.children.length === 0 || productList.children[0].textContent.includes("No Items added")) {
            alert('No items in the order');
            return false;
        }

        if (!paymentMode) {
            alert('Please select a payment mode');
            return false;
        }

        // Collect order items from the table
        Array.from(productList.children).forEach(row => {
            const productName = row.children[2].textContent; // Adjusted for image column
            const originalPrice = parseFloat(row.dataset.originalPrice);
            const discount = parseFloat(row.dataset.discount);
            const quantity = parseInt(row.querySelector('input').value);
            const totalPrice = parseFloat(row.querySelector('.total-price').textContent.replace('$', ''));
            const productId = row.dataset.productId; // Include productId for backend

            items.push({
                productName,
                productId, // Added for backend processing
                quantity,
                originalPrice,
                discount,
                totalPrice
            });
        });

        // Pass a structured object with 'items' and 'paymentMode'
        const orderData = {
            items: items,
            paymentMode: paymentMode
        };

        document.getElementById('orderItems').value = JSON.stringify(orderData);
        return true; // Allow form submission
    }
</script>