<?php
// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Authentication check
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
require_once "Models/drinkModel.php";
// Ensure $products is defined
$products = $products ?? [];

// Sort products by quantity in descending order to show top in-stock items first
usort($products, function($a, $b) {
    return ($b['quantity'] ?? 0) <=> ($a['quantity'] ?? 0);
});
?>
<div class="container-xxl flex-grow-1 py-4">
    <!-- Top In-Stock Products Slideshow Section -->
    <?php 
    // Filter out low stock items for slideshow - now only showing items with 15+ quantity
    $carouselProducts = array_filter($products, fn($p) => ($p['quantity'] ?? 0) >= 15);
    if (!empty($carouselProducts)): ?>
    <h5 class="mb-3">Top Products In Stock:</h5>
    <div class="mb-4 position-relative">
        <div id="drinkCarousel" class="carousel slide shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php 
                $totalSlides = ceil(count($carouselProducts) / 4);
                for ($i = 0; $i < $totalSlides; $i++): ?>
                    <button type="button" 
                            data-bs-target="#drinkCarousel" 
                            data-bs-slide-to="<?= $i ?>" 
                            class="<?= $i === 0 ? 'active' : '' ?>" 
                            aria-label="Slide <?= $i + 1 ?>"></button>
                <?php endfor; ?>
            </div>
            <div class="carousel-inner">
                <?php 
                $chunkedProducts = array_chunk($carouselProducts, 4);
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
                                            <a href="/inventory/viewdrink/<?= $product['product_id'] ?? '' ?>" 
                                               class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#drinkCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#drinkCarousel" data-bs-slide="next">
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

    <!-- Transactions Section -->
    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <h5 class="mb-0">Drinks Inventory:</h5>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 40px;" style="color: #000000;">#</th>
                            <th scope="col" style="color: #000000;">PRODUCT</th>
                            <th scope="col" style="color: #000000;">CATEGORY</th>
                            <th scope="col" style="color: #000000;">STOCK</th>
                            <th scope="col" style="color: #000000;">PRICE</th>
                            <th scope="col" style="color: #000000;">QTY</th>
                            <th scope="col" style="color: #000000;">AMOUNT</th>
                            <th scope="col" style="color: #000000;">ACTION</th>
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
                                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="/inventory/viewdrink/<?= $product['product_id'] ?? '' ?>">
                                                    <i class="bi bi-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $product['product_id'] ?? 0 ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                                <form id="delete-form-<?= $product['product_id'] ?? '' ?>" 
                                                      action="/drink/delete/<?= $product['product_id'] ?? '' ?>" 
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
    // Check if a specific product is requested via query parameter
    $requested_product = isset($_GET['product']) ? urldecode($_GET['product']) : null;
    if ($requested_product) {
        $low_stock_items = array_filter($low_stock_items, fn($p) => $p['product_name'] === $requested_product);
    }
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

// Send low stock items to localStorage for notifications
document.addEventListener("DOMContentLoaded", function () {
    const lowStockItems = <?php echo json_encode($low_stock_items); ?>;
    
    if (Object.keys(lowStockItems).length > 0) {
        // Prepare notifications for low stock
        const notifications = Object.values(lowStockItems).map(item => ({
            title: `Low Stock Alert: ${item.product_name}`,
            start: new Date().toISOString().split('T')[0], // Today's date
            isRead: false,
            timestamp: new Date().toISOString(),
            quantity: item.quantity
        }));

        // Get existing events from localStorage
        let existingEvents = JSON.parse(localStorage.getItem("events")) || [];
        
        // Add new low stock notifications if they don't already exist
        notifications.forEach(newEvent => {
            if (!existingEvents.some(event => event.title === newEvent.title)) {
                existingEvents.push(newEvent);
            }
        });

        // Save updated events to localStorage
        localStorage.setItem("events", JSON.stringify(existingEvents));
    }
});
</script>