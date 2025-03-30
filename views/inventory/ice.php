<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
require_once "Models/iceModel.php";
// Ensure $products is defined
$products = $products ?? [];
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Popular Items Slideshow -->
    <h5 class="mb-3">The Popular Items:</h5>
    <div class="mb-4 position-relative">
        <div id="popularCarousel" class="carousel slide shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                $popular_products = array_filter($products, function ($product) {
                    return isset($product['price'], $product['quantity']) && ($product['price'] * $product['quantity']) >= 20;
                });
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
                <?php if (empty($popular_products)): ?>
                    <div class="carousel-item active">
                        <div class="d-flex align-items-center justify-content-center" style="height: 450px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                            <div class="text-center p-4">
                                <h3 class="text-muted">No popular items available yet</h3>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
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
                                                <span class="stock-badge position-absolute top-0 end-0 m-2 <?= ($product['quantity'] ?? 0) < 5 ? 'bg-danger' : 'bg-success' ?> text-white px-2 py-1 rounded">
                                                    <?= ($product['quantity'] ?? 0) < 5 ? 'Low' : 'In Stock' ?>
                                                </span>
                                            </div>
                                            <div class="card-body text-center">
                                                <h5 class="card-title mb-3"><?= htmlspecialchars($product['product_name'] ?? 'N/A') ?></h5>
                                                <p class="card-text mb-4">
                                                    <span class="price fw-bold">$<?= number_format($product['price'] ?? 0, 2) ?></span>
                                                    <span class="mx-2">•</span>
                                                    <span><?= $product['quantity'] ?? 0 ?> left</span>
                                                </p>
                                                <a href="/inventory/viewice/<?= $product['product_id'] ?? '' ?>"
                                                   class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($popular_products)): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#popularCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#popularCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="mb-4 position-relative" style="background: linear-gradient(135deg, #f0eded 0%, #f0f0f0 100%);">
        <h5 class="header-title fw-bold mb-4 text-center text-uppercase pt-4">
            <span class="text-primary">Quick</span>
            <span class="text-secondary">Stats</span>
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

    <!-- Transactions Section -->
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h5 class="mt-3 mb-0">Ice Transactions:</h5>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40px">#</th>
                            <th>PRODUCT</th>
                            <th>CATEGORY</th>
                            <th>STOCK</th>
                            <th>PRICE</th>
                            <th>QTY</th>
                            <th>AMOUNT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                            <tr>
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
                                    <span class="text-<?= ($product['quantity'] ?? 0) < 5 ? 'danger' : 'success' ?>">
                                        <?= ($product['quantity'] ?? 0) < 5 ? 'Low stock' : 'High stock' ?>
                                    </span>
                                </td>
                                <td>$<?= number_format($product['price'] ?? 0, 2) ?></td>
                                <td class="text-<?= ($product['quantity'] ?? 0) < 5 ? 'danger' : 'body' ?>">
                                    <?= $product['quantity'] ?? 'N/A' ?>
                                </td>
                                <td>$<?= number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 0), 2) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="/inventory/viewice/<?= $product['product_id'] ?? '' ?>">
                                                    <i class="bi bi-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $product['product_id'] ?? 0 ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                                <form id="delete-form-<?= $product['product_id'] ?? '' ?>" 
                                                      action="/ice/delete/<?= $product['product_id'] ?? '' ?>" 
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
                    <button type="button" class="btn-close btn-close-white ms-auto" onclick="this.parentElement.parentElement.parentElement.style.display='none';" aria-label="Close"></button>
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
                    <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="this.parentElement.parentElement.parentElement.style.display='none';">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function confirmDelete(productId) {
    if (productId && confirm('Are you sure you want to delete this product?')) {
        document.getElementById(`delete-form-${productId}`).submit();
    }
}
</script>









