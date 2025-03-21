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
        <div id="alert-box" class="alert alert-success d-none alert-dismissible fade show" role="alert">
            <span id="alert-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <div class="card shadow-sm p-4">
            <h2 class="text-center text-primary">Create Order</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Product</label>
                    <select id="product" class="form-select">
                        <option value="">-- Select Product --</option>
                        <option value="Mi Note 8 Pro" data-price="16000">Mi Note 8 Pro - $16000</option>
                        <option value="T-Shirt" data-price="399">T-Shirt - $399</option>
                        <option value="Laptop" data-price="55000">Laptop - $55000</option>
                        <option value="Headphones" data-price="2500">Headphones - $2500</option>
                        <option value="Smartwatch" data-price="12000">Smartwatch - $12000</option>
                        <option value="Backpack" data-price="1500">Backpack - $1500</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Quantity</label>
                    <input type="number" id="quantity" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="addItem()">Add Item</button>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm mt-4 p-4">
            <h3 class="text-center text-success">Products</h3>
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
            <h4 class="text-warning">Payment Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Select Payment Mode</label>
                    <select class="form-select">
                        <option>Cash Payment</option>
                        <option>Card Payment</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Customer Phone Number</label>
                    <input type="text" class="form-control" placeholder="Enter Customer Phone Number">
                </div>
            </div>
            <button class="btn btn-warning mt-3 w-100">Proceed to Place Order</button>
        </div>
    </div>

    <script>
        let idCounter = 1;

        function addItem() {
            const productSelect = document.getElementById('product');
            const quantity = document.getElementById('quantity').value;
            const productName = productSelect.options[productSelect.selectedIndex].value;
            const price = productSelect.options[productSelect.selectedIndex].getAttribute('data-price');
            const alertBox = document.getElementById('alert-box');
            const alertMessage = document.getElementById('alert-message');
            
            if (!productName || quantity < 1) {
                alert('Please select a valid product and quantity.');
                return;
            }
            
            alertMessage.innerText = `Item Added: ${productName}`;
            alertBox.classList.remove('d-none');
            
            const totalPrice = price * quantity;
            const productList = document.getElementById('product-list');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idCounter++}</td>
                <td>${productName}</td>
                <td>$${price}</td>
                <td><input type="number" value="${quantity}" min="1" class="form-control w-50 mx-auto" onchange="updateTotal(this)"></td>
                <td class="total-price">$${totalPrice}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            `;
            if (productList.children[0] && productList.children[0].textContent.includes("No Items added")) {
                productList.innerHTML = "";
            }
            productList.appendChild(row);
        }

        function updateTotal(input) {
            const row = input.parentElement.parentElement;
            const price = row.children[2].innerText.replace('$', '');
            const quantity = input.value;
            row.children[4].innerText = `$${price * quantity}`;
        }

        function removeItem(button) {
            button.parentElement.parentElement.remove();
        }
    </script>
</div>