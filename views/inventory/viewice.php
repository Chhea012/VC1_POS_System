
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>

<div class="m-4 ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">View Product</h5>
                <a href="/ice" class="btn-close" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="product-card">
                    <!-- Product Image -->
                    <div class="product-image">
                       <img src="/views/products/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid" alt="Product Image">
                        <!-- Placeholder for no image: <div class="no-image"><i class="bi bi-image"></i></div> -->
                    </div>
                    <!-- Product Details -->
                    <div class="product-details">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($product['description'] ?? 'No description available'); ?></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span><strong>Category:</strong></span>
                                <span><?php echo isset($product['category']) ? htmlspecialchars($product['category']) : 'No Category'; ?></span>

                            </li>
                            <li class="list-group-item">
                                <span><strong>Barcode:</strong></span>
                                <span><?php echo htmlspecialchars($product['barcode']); ?></span>
                            </li>
                            <li class="list-group-item">
                                <span><strong>Quantity:</strong></span>
                                <span><?php echo htmlspecialchars($product['quantity']); ?></span>

                            </li>
                            <li class="list-group-item">
                                <span><strong>Base Price:</strong></span>
                                <span>$<?php echo number_format($product['price'], 2); ?></span>
                            </li>
                            <li class="list-group-item">
                                <span><strong>Cost Price:</strong></span>
                                <span>$<?php echo number_format($product['cost_product'], 2); ?></span>
                            </li>
                            <li class="list-group-item">
                                <span><strong>Profit Price:</strong></span>
                                <span>$<?= isset($product['price'], $product['quantity'], $product['cost_product']) ? number_format(($product['price'] * $product['quantity']) - ($product['cost_product'] * $product['quantity']), 2) : '0.00' ?></span>

                            </li>
                            <li class="list-group-item">
                                <span><strong>Discounted Price:</strong></span>
                                <span><?php echo $product['discounted_price'] ? '$' . number_format($product['discounted_price'], 2) : '0'; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .modal-content {
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
            background-color: #f8f9fa;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #343a40;
        }

        .btn-close {
            font-size: 1.2rem;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
        }

        .product-card {
            display: flex;
            gap: 2rem;
            align-items: stretch;
        }

        .product-image {
            flex: 0 0 26%;
            max-height: 450px;
            overflow: hidden;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1.5px dashed #9AA6B2;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image .no-image {
            font-size: 3rem;
            color: #adb5bd;
        }

        .product-details {
            flex: 1;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.75rem;
        }

        .card-text {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border: none;
            background-color: transparent;
            font-size: 1rem;
            color: #495057;
            border-bottom: 1px dashed #9AA6B2;
        }

        .list-group-item strong {
            color: #343a40;
        }

        .list-group-item span:last-child {
            font-weight: 500;
        }
        

        @media (max-width: 768px) {
            .product-card {
                flex-direction: column;
                gap: 1.5rem;
            }

            .product-image {
                max-height: 200px;
            }
        }
    </style>

<style>
    .modal-content {
        border-radius: 15px;
        background-color: #ffff;
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-body {
        padding: 1.5rem;
    }

    .list-group-item {
        font-size: 1rem;
        background-color: #fff;
    }

    .list-group-item span {
        color: #495057;
    }

    .btn-close {
        font-size: 1.2rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .card-text {
        color: #6c757d;
    }
</style>

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