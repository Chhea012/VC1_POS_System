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
    <!-- Top Products Slideshow - Now with 2 products per slide -->
    <?php if (!empty($topProducts)): ?>
        <div class="card mb-4 border-0 overflow-hidden">
            <div class="card-header bg-primary py-3">
                <h3 class="mb-0 text-center text-white">
                    <i class="bi bi-star-fill me-2 text-white"></i>Top Product Orders
                </h3>
            </div>
            <div class="card-body p-0">
                <div id="topProductsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                        // Split products into chunks of 2 for each slide
                        $productChunks = array_chunk($topProducts, 2);
                        foreach ($productChunks as $index => $chunk): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <div class="row g-4 p-4">
                                    <?php foreach ($chunk as $product): ?>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column flex-md-row align-items-center">
                                                <div class="position-relative me-md-4 mb-3 mb-md-0">
                                                    <div class="image-frame">
                                                        <img src="<?php echo htmlspecialchars($product['image'] ? '/views/products/' . $product['image'] : '/views/products/default.jpg'); ?>" 
                                                             class="d-block product-image" 
                                                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                                             onerror="this.src='/views/products/default.jpg'">
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                            #<?php echo $product['rank']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-center text-md-start">
                                                    <h4 class="fw-bold text-primary"><?php echo htmlspecialchars($product['product_name']); ?></h4>
                                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                                                        <span class="badge bg-success">$<?php echo number_format($product['price'], 2); ?></span>
                                                        <span class="badge bg-info">Qty: <?php echo $product['total_quantity']; ?></span>
                                                        <span class="badge bg-primary">Rank: #<?php echo $product['rank']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#topProductsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#topProductsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Rest of your code remains unchanged -->
    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="color: white;">S.No</th>
                            <th scope="col" style="color: white;">Order Date</th>
                            <th scope="col" style="color: white;">Order Time</th>
                            <th scope="col" style="color: white;">Order Price</th>
                            <th scope="col" style="color: white;">Payment Status</th>
                            <th scope="col" style="color: white;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <?php foreach ($orders as $index => $order): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                <td><?php echo date('H:i:s A', strtotime($order['order_date'])); ?></td>
                                <td class="fw-bold text-primary">$<?php echo htmlspecialchars($order['total_amount']); ?></td>
                                <td>
                                    <span class="badge <?php echo $order['payment_mode'] === 'paid' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo htmlspecialchars($order['payment_mode']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-dark" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <a class="dropdown-item" href="/orders/view/<?php echo $order['order_id'] ?>">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete(<?php echo $order['order_id']; ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete Order
                                                </a>
                                                <form id="delete-form-<?php echo $order['order_id'] ?>" action="/orders/delete/<?php echo $order['order_id'] ?>" method="POST" style="display:none;">
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

    <!-- Toast Notification and Modal sections remain unchanged -->
    <!-- ... -->
</div>

<style>
    /* Creative Image Border Styles */
    .image-frame {
    position: relative;
    width: 100%;
    max-width: 250px;
    aspect-ratio: 1 / 1;
    padding: 8px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin: 0 auto;
}

.image-frame::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 15px;
    padding: 2px;
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45aaf2, #a55eea);
    -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.image-frame:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.image-frame:hover .product-image {
    transform: scale(1.02);
}

.carousel-inner {
    padding: 0 15px;
}

.d-flex.flex-column.flex-md-row {
    flex-direction: row;
    align-items: flex-start;
    text-align: left;
}

.text-center.text-md-start {
    text-align: left;
}

@media (max-width: 768px) and (min-width: 577px) {
    .image-frame {
        max-width: 200px;
    }

    .row.g-4.p-4 {
        padding: 15px !important;
    }

    .product-image {
        height: auto;
    }

    .badge {
        font-size: 0.9rem;
    }

    .text-center.text-md-start h4 {
        font-size: 1.1rem;
    }

    .d-flex.flex-column.flex-md-row {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .text-center.text-md-start {
        text-align: center;
    }
}
 
    
</style>

<script>
    function confirmDelete(orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
            document.getElementById('delete-form-' + orderId).submit();
        }
    }
</script>