<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<!-- ModalView product -->
<div class="m-4">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">View Product: <?php echo htmlspecialchars($product['product_name'])?></h5>
                <a href="/food" class="btn-close"  aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <!-- Product Card -->
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <!-- Product Image -->
                        <div class="col-md-4">
                            <?php if (! empty($product['image'])): ?>
                                <img src="/views/products/<?php echo htmlspecialchars($product['image'])?>" class="img-fluid rounded-start" style="max-height: 300px; object-fit: cover;">
                            <?php else: ?>
                                <div class="d-flex justify-content-center align-items-center h-100 bg-light rounded-start">
                                    <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Product Details -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product_name'])?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($product['description'] ?? 'No description available')?></p>

                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Category:</strong></span>
                                        <span><?php echo htmlspecialchars($product['category_name'] ?? 'N/A')?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Barcode:</strong></span>
                                        <span><?php echo htmlspecialchars($product['barcode'])?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Quantity:</strong></span>
                                        <span><?php echo htmlspecialchars($product['quantity'])?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Base Price:</strong></span>
                                        <span>$<?php echo number_format($product['price'], 2)?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Total Price:</strong></span>
                                        <span>$<?= isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00' ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Discounted Price:</strong></span>
                                        <span><?php echo $product['discounted_price'] ? '$' . number_format($product['discounted_price'], 2) : '0'?></span>
                                    </li>


                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<Script>

document.querySelectorAll('[data-bs-target="#viewProductModal"]').forEach(item => {
    item.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        // Assume an AJAX call or PHP logic to fetch product data based on productId
        fetch(`view_product.php?id=${productId}`)
            .then(response => response.json())
            .then(product => {
                // Populate modal fields with product data
                document.querySelector('#viewProductModalLabel').textContent = `View Product: ${product.title}`;
                document.querySelector('.card-title').textContent = product.title;
                document.querySelector('.card-text').textContent = product.description || 'No description available';
                // Update other fields similarly...
            });
    });
});
</Script>
