<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<?php require_once "Models/iceModel.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The popular items:</h5>
    <div class="row text-center">
        <?php
        $popular_items = [];
        foreach ($products as $product) {
            $amount = isset($product['price'], $product['quantity']) ? ($product['price'] * $product['quantity']) : 0;
            if ($amount > 20) {
                $popular_items[] = $product;
            }
        }

        if (!empty($popular_items)) {
            foreach ($popular_items as $product): ?>
                <div class="col-md-3">
                    <div class="card p-4 shadow-sm">
                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="w-100" alt="Popular IceDessert">
                        <div class="mt-2">⭐⭐⭐⭐⭐</div>
                    </div>
                </div>
            <?php endforeach;
        } else {
            echo "<p class='text-center text-muted'>No popular items yet.</p>";
        }
        ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
    <h5>Drinks Transactions:</h5>
    <div>
        <button class="btn btn-primary mb-4" onclick="exportToPDF()">Export PDF</button>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40px"><input class="form-check-input" type="checkbox" id="selectAll"></th>
                        <th>PRODUCT</th>
                        <th>CATEGORY</th>
                        <th>STOCK</th>
                        <th>PRICE</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="card-img-top w-px-50" alt="Product Image">
                                        <span class="ms-3"><?= htmlspecialchars($product['product_name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">
                                        <i class="bi bi-cup-hot me-1"></i>
                                        <?= htmlspecialchars($product['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="color: <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'red' : 'green' ?>;">
                                        <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'Low stock' : 'High stock' ?>
                                    </span>
                                </td>
                                <td>$<?= isset($product['price']) ? number_format($product['price'], 2) : '0.00' ?></td>
                                <td <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'style="color: red;"' : '' ?>>
                                    <?= isset($product['quantity']) ? $product['quantity'] : 'N/A' ?>
                                </td>
                                <td>$<?= isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00' ?></td>
                                <td>
                                    <div class="dropdown">
                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="view_product.php?id=<?= $product['product_id'] ?>"><i class="bi bi-eye me-2"></i>View</a></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $product['product_id'] ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
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

<!-- JavaScript for search, edit, and PDF export -->
<script>
// Select all checkbox functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('#productTable .form-check-input');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Search functionality: Filter rows based on input in search box
document.getElementById('searchBox').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#productTable tr');

    rows.forEach(row => {
        const productNameElement = row.querySelector('.product-name');
        if (!productNameElement) return; // Prevent error if element is missing

        const productName = productNameElement.value.toLowerCase();
        if (productName.includes(searchTerm) || searchTerm === '') {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Make fields editable and update amount dynamically
document.querySelectorAll('#productTable tr').forEach(row => {
    const priceInput = row.querySelector('.price');
    const qtyInput = row.querySelector('.qty');
    const stockSpan = row.querySelector('.stock');

    // Prevent errors if elements are missing
    if (!priceInput || !qtyInput || !stockSpan) return;

    // Update amount and stock status when price or quantity changes
    [priceInput, qtyInput].forEach(input => {
        input.addEventListener('input', function() {
            let price = parseFloat(priceInput.value.replace('$', '')) || 0;
            let qty = parseInt(qtyInput.value) || 0;

            // Update amount
            const amount = price * qty;
            row.querySelector('.amount').textContent = `$${amount.toFixed(2)}`;

            // Update stock status
            if (qty < 5) {
                stockSpan.textContent = 'Low stock';
                stockSpan.style.color = 'red';
                qtyInput.style.color = 'red';
            } else {
                stockSpan.textContent = 'High stock';
                stockSpan.style.color = 'green';
                qtyInput.style.color = '';
            }
        });
    });
});


// Export to PDF: Collect table data and send to backend
function exportToPDF() {
    const products = [];
    document.querySelectorAll('#productTable tr').forEach(row => {
        products.push({
            product: row.querySelector('.product-name').value,
            price: row.querySelector('.price').value,
            qty: row.querySelector('.qty').value,
            amount: row.querySelector('.amount').textContent
        });
    });

    fetch('/controller/export', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ products })
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'drinks_transactions.pdf';
        a.click();
    })
    .catch(error => {
        console.error('Error exporting PDF:', error);
    });
}
</script>

<!-- Delete Product Function -->
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = 'delete_product.php?id=' + id;
        }
    }
</script>

<!-- Delete Product Function -->
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = 'delete_product.php?id=' + id;
        }
    }
</script>


<!-- Low Stock Alert -->
<?php
$low_stock_items = [];
foreach ($products as $product) {
    if (isset($product['quantity']) && $product['quantity'] < 5) {
        $low_stock_items[] = htmlspecialchars($product['product_name']) . " (" . $product['quantity'] . " units)";
    }
}
?>

<?php if (!empty($low_stock_items)): ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="lowStockToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
            <strong class="me-auto">Low Stock Alert</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <ul class="list-unstyled mb-0">
                <?php foreach ($low_stock_items as $item): ?>
                    <li><?php echo $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lowStockToast = new bootstrap.Toast(document.getElementById('lowStockToast'), {
            delay: 5000 
        });
        lowStockToast.show();
    });
</script>
<?php endif; ?>