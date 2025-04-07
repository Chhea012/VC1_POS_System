<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
require_once "Models/foodModel.php";
// Ensure $products is defined
$products = $products ?? [];

// Sort products by quantity in descending order
usort($products, function($a, $b) {
    return ($b['quantity'] ?? 0) <=> ($a['quantity'] ?? 0);
});
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Popular Items Slideshow -->
    <?php 
    $popular_products = array_filter($products, function ($product) {
        return ($product['quantity'] ?? 0) >= 15;
    });
    
    if (!empty($popular_products)): ?>
    <h5 class="mb-3">Top Products In Stock:</h5>
    <div class="mb-4 position-relative">
        <div id="popularCarousel" class="carousel slide shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                $totalSlides = ceil(count($popular_products) / 4);
                for ($i = 0; $i < $totalSlides; $i++): ?>
                    <button type="button"
                            data-bs-target="#popularCarousel"
                            data-bs-slide-to="<?= $i ?>"
                            class="<?= $i === 0 ? 'active' : '' ?>"
                            aria-label="Slide <?= $i + 1 ?>"></button>
                <?php endfor; ?>
            </div>
            <div class="carousel-inner">
                <?php
                $chunkedProducts = array_chunk($popular_products, 4);
                foreach ($chunkedProducts as $slideIndex => $slideProducts): ?>
                    <div class="carousel-item <?= $slideIndex === 0 ? 'active' : '' ?>">
                        <div class="row g-4 justify-content-center align-items-center m-0 p-4" style="min-height: 450px; background: linear-gradient(135deg, #f0eded 0%, #f0f0f0 100%);">
                            <?php foreach ($slideProducts as $product): ?>
                                <div class="col-md-3">
                                    <div class="card drink-card h-100 shadow-sm border-0">
                                        <div class="drink-img-wrapper text-center position-relative">
                                            <img src="<?= htmlspecialchars('views/products/' . ($product['image'] ?? 'default.jpg')) ?>"
                                                 class="drink-img img-fluid"
                                                 style="max-height: 200px; object-fit: cover;"
                                                 alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>">
                                            <span class="stock-badge position-absolute top-0 end-0 m-2 bg-success text-white px-2 py-1 rounded">
                                                <?= $product['quantity'] ?? 0 ?> in stock
                                            </span>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title mb-3"><?= htmlspecialchars($product['product_name'] ?? 'N/A') ?></h5>
                                            <p class="card-text mb-4">
                                                <span class="price fw-bold">$<?= number_format($product['price'] ?? 0, 2) ?></span>
                                                <span class="mx-2">•</span>
                                                <span>Rank #<?= $slideIndex * 4 + array_search($product, $slideProducts) + 1 ?></span>
                                            </p>
                                            <a href="/inventory/viewfood/<?= htmlspecialchars($product['product_id'] ?? '') ?>"
                                               class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#popularCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#popularCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Stats Section -->
    <div class="mb-4 position-relative" style="background: linear-gradient(135deg, #f0eded 0%, #f0f0f0 100%);">
        <h5 class="header-title fw-bold mb-4 text-center text-uppercase pt-4">
            <span class="text-primary">Quick</span>
            <span class="text-secondary">Status</span>
        </h5>
        <div class="row g-4 justify-content-center align-items-center px-4 pb-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative rounded-3">
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="bi bi-boxes" style="font-size: 4rem;"></i>
                        </div>
                        <i class="bi bi-boxes fs-2 position-relative z-1"></i>
                        <h6 class="mt-3 mb-1 fw-bold text-uppercase">Total Products</h6>
                        <p class="fw-bold fs-3 mb-0 position-relative z-1"><?= count($products) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative rounded-3">
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #28a745, #1d7a35);">
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="bi bi-currency-dollar" style="font-size: 4rem;"></i>
                        </div>
                        <i class="bi bi-currency-dollar fs-2 position-relative z-1"></i>
                        <h6 class="mt-3 mb-1 fw-bold text-uppercase">Total Value</h6>
                        <p class="fw-bold fs-3 mb-0 position-relative z-1">
                            $<?= number_format(array_sum(array_map(fn($p) => ($p['price'] ?? 0) * ($p['quantity'] ?? 0), $products)), 2) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative rounded-3">
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #ffc107, #d39e00);">
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="bi bi-exclamation-triangle" style="font-size: 4rem;"></i>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-2 position-relative z-1"></i>
                        <h6 class="mt-3 mb-1 fw-bold text-uppercase">Low Stock Items</h6>
                        <p class="fw-bold fs-3 mb-0 position-relative z-1"><?= count(array_filter($products, fn($p) => ($p['quantity'] ?? 0) < 5)) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Food Transactions Section -->
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h5 class="mt-3 mb-0">Food Inventory:</h5>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40px" style="color: #000000;">#</th>
                            <th style="color: #000000;">PRODUCT</th>
                            <th style="color: #000000;">CATEGORY</th>
                            <th style="color: #000000;">STOCK</th>
                            <th style="color: #000000;">PRICE</th>
                            <th style="color: #000000;">QTY</th>
                            <th style="color: #000000;">AMOUNT</th>
                            <th style="color: #000000;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                            <tr data-product-id="<?= htmlspecialchars($product['product_id'] ?? '') ?>">
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars('views/products/' . ($product['image'] ?? 'default.jpg')) ?>"
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;"
                                             alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>">
                                        <span class="ms-3"><?= htmlspecialchars($product['product_name'] ?? 'N/A') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">
                                        <i class="bi bi-cup-hot me-1"></i>
                                        <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-<?= ($product['quantity'] ?? 0) < 5 ? 'danger' : (($product['quantity'] ?? 0) < 15 ? 'warning' : 'success') ?>">
                                        <?= ($product['quantity'] ?? 0) < 5 ? 'Low stock' : (($product['quantity'] ?? 0) < 15 ? 'Medium stock' : 'High stock') ?>
                                    </span>
                                </td>
                                <td>$<?= number_format($product['price'] ?? 0, 2) ?></td>
                                <td class="text-<?= ($product['quantity'] ?? 0) < 5 ? 'danger' : (($product['quantity'] ?? 0) < 15 ? 'warning' : 'body') ?>">
                                    <?= $product['quantity'] ?? 'N/A' ?>
                                </td>
                                <td>$<?= number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 0), 2) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="/inventory/viewfood/<?= htmlspecialchars($product['product_id'] ?? '') ?>">
                                                    <i class="bi bi-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger delete-product" 
                                                   href="javascript:void(0)" 
                                                   data-product-id="<?= htmlspecialchars($product['product_id'] ?? '') ?>">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                                <form id="delete-form-<?= htmlspecialchars($product['product_id'] ?? '') ?>" 
                                                      action="/food/delete/<?= htmlspecialchars($product['product_id'] ?? '') ?>" 
                                                      method="POST" 
                                                      style="display:none;">
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

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Product deleted successfully!
            </div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Failed to delete product. Please try again.
            </div>
        </div>
    </div>

    <!-- Creative Low Stock Alert -->
    <?php
    $low_stock_items = array_filter($products, fn($p) => ($p['quantity'] ?? 0) < 5);
    if (!empty($low_stock_items)): ?>
        <div class="low-stock-alert position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden animate__animated animate__bounceInRight" 
                 style="max-width: 350px; background: linear-gradient(135deg, #fff3e0, #ffebee);">
                <div class="card-header bg-danger d-flex align-items-center p-3">
                    <i class="bi bi-exclamation-octagon fs-3 me-2 text-white animate__animated animate__pulse animate__infinite"></i>
                    <h5 class="mb-0 fw-bold text-white">Low Stock Warning!</h5>
                    <button type="button" class="btn-close btn-close-white ms-auto" onclick="this.closest('.low-stock-alert').style.display='none';" aria-label="Close"></button>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted mb-3">The following items need attention:</p>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($low_stock_items as $item): ?>
                            <li class="list-group-item d-flex align-items-center p-2 animate__animated animate__fadeInUp" style="animation-delay: <?= (array_search($item, $low_stock_items) * 0.1) ?>s;">
                                <i class="bi bi-box-seam text-warning me-2"></i>
                                <span class="flex-grow-1"><?= htmlspecialchars($item['product_name'] ?? 'Unknown') ?></span>
                                <span class="badge bg-danger rounded-pill"><?= $item['quantity'] ?? 0 ?> left</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer bg-light text-center p-2">
                    <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="this.closest('.low-stock-alert').style.display='none';">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Delete functionality
    const deleteButtons = document.querySelectorAll('.delete-product');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const form = document.getElementById(`delete-form-${productId}`);
            const row = this.closest('tr');
            
            if (!form || !productId) {
                console.error('Form or product ID not found');
                return;
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form)
                });
                
                if (response.ok) {
                    const successToast = new bootstrap.Toast(document.getElementById('successToast'), {
                        delay: 3000
                    });
                    successToast.show();
                    
                    row.style.transition = 'opacity 0.3s ease-out';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                } else {
                    throw new Error('Delete request failed');
                }
            } catch (error) {
                console.error('Delete error:', error);
                const errorToast = new bootstrap.Toast(document.getElementById('errorToast'), {
                    delay: 3000
                });
                errorToast.show();
            }
        });
    });

    // Low stock notifications
    const lowStockItems = <?php echo json_encode($low_stock_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    
    if (lowStockItems && Object.keys(lowStockItems).length > 0) {
        const notifications = Object.values(lowStockItems).map(item => ({
            title: `Low Stock Alert: ${item.product_name || 'Unknown'}`,
            start: new Date().toISOString().split('T')[0],
            isRead: false,
            timestamp: new Date().toISOString(),
            quantity: item.quantity ?? 0,
            product_id: item.product_id || ''
        }));

        let existingEvents = JSON.parse(localStorage.getItem("events") || '[]');
        
        notifications.forEach(newEvent => {
            if (!existingEvents.some(event => event.title === newEvent.title)) {
                existingEvents.push(newEvent);
            }
        });

        localStorage.setItem("events", JSON.stringify(existingEvents));
    }
});
</script>
<style>
    /* For tablet devices (max-width: 768px) */
    @media (max-width: 768px) {
        .row > div {
            width: 100% !important;
            margin-bottom: 10px;
        }
        .table-responsive {
            overflow-x: auto;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
        }

  
        .table tbody tr td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }

        
        .table tbody tr td:last-child {
            border-bottom: none;
        }

       
        .table tbody tr td::before {
            content: attr(data-label);
            font-weight: bold;
            display: inline-block;
            width: 40%;
            margin-right: 10px;
        }

      
        .table tbody tr td button {
            width: auto;
            padding: 5px 10px;
            font-size: 14px;
        }

        .table-responsive {
            padding: 10px;
        }

     
        .form-label, .btn {
            width: 100%;
            font-size: 1rem;
        }


        .form-control, .form-select {
            padding: 0.8rem;
        }
    }

    /* For mobile view only (max-width: 576px) */
    @media (max-width: 576px) {
        .form-label {
            font-size: 0.9rem; /* Smaller label font size for mobile */
        }

        /* Adjust table cell font size for better readability on mobile */
        .table tbody tr td {
            font-size: 14px; /* Smaller font size on mobile */
        }

        /* Increase button size and make them easier to tap */
        .table tbody tr td button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        /* Adjust the padding and margins for better mobile layout */
        .table tbody tr {
            padding: 8px;
        }

        /* Add some margin to separate table rows on mobile */
        .table tbody tr {
            margin-bottom: 8px;
        }
        /* Only show first product in each slide */
    .carousel-item .col-md-3:nth-child(n+2) {
        display: none;
    }

    /* Make the single product full-width */
    .carousel-item .col-md-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .drink-card {
        height: auto !important;
        padding-bottom: 1rem;
    }

    .drink-img-wrapper {
        margin-bottom: 1rem;
    }

    .carousel-inner > .carousel-item {
        padding: 1rem !important;
    }

    .card-body {
        text-align: center !important;
    }

    .drink-btn {
        width: 100%;
    }

    .carousel-indicators {
        bottom: -25px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        top: auto;
        bottom: -40px;
    }

    /* Optional: smaller image height */
    .drink-img {
        max-height: 150px;
    }
    }

</style>


