<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to homepage if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Top Products Slideshow -->
    <?php if (!empty($topProducts)): ?>
        <div class="card mb-4 border-0 overflow-hidden">
            <div class="card-header bg-primary py-3">
                <h3 class="mb-0 text-center text-white">
                    <i class="bi bi-star-fill me-2 text-white"></i>Top Product Orders
                </h3>
            </div>
            <div class="card-body p-0">
                <div id="topProductsCarousel" class="carousel slide" data-bs-ride="carousel" aria-label="Top Products Carousel">
                    <div class="carousel-inner">
                        <?php
                        // Chunk products into groups of 2 for carousel slides
                        $productChunks = array_chunk($topProducts, 2);
                        if (empty($productChunks)) {
                            echo '<div class="carousel-item active"><div class="row g-4 p-4"><p class="text-center">No products available.</p></div></div>';
                        } else {
                            foreach ($productChunks as $index => $chunk): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="row g-4 p-4">
                                        <?php foreach ($chunk as $product):
                                            // Validate product data with fallbacks
                                            $productName = isset($product['product_name']) ? htmlspecialchars($product['product_name']) : 'Unknown Product';
                                            $productImage = isset($product['image']) && $product['image'] ? '/views/products/' . htmlspecialchars($product['image']) : '/views/products/default.jpg';
                                            $productPrice = isset($product['price']) ? number_format((float)$product['price'], 2) : '0.00';
                                            $productQuantity = isset($product['total_quantity']) ? (int)$product['total_quantity'] : 0;
                                            $productRank = isset($product['rank']) ? (int)$product['rank'] : 'N/A';
                                        ?>
                                            <div class="col-md-6 col-12">
                                                <div class="d-flex flex-column flex-md-row align-items-center product-card">
                                                    <div class="position-relative me-md-4 mb-3 mb-md-0">
                                                        <div class="image-frame">
                                                            <img src="<?php echo $productImage; ?>" 
                                                                 class="d-block product-image" 
                                                                 alt="<?php echo $productName; ?>"
                                                                 onerror="this.src='/views/products/default.jpg'">
                                                            <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger rank-badge">
                                                                #<?php echo $productRank; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="text-center text-md-start">
                                                        <h4 class="fw-bold text-primary"><?php echo $productName; ?></h4>
                                                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                                                            <span class="badge bg-success">$<?php echo $productPrice; ?></span>
                                                            <span class="badge bg-info">Qty: <?php echo $productQuantity; ?></span>
                                                            <span class="badge bg-primary">Rank: #<?php echo $productRank; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach;
                        } ?>
                    </div>
                    <?php if (count($productChunks) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#topProductsCarousel" data-bs-slide="prev" aria-label="Previous Slide">
                            <span class="carousel-control-prev-icon custom-control-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#topProductsCarousel" data-bs-slide="next" aria-label="Next Slide">
                            <span class="carousel-control-next-icon custom-control-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="carousel-indicators">
                            <?php foreach ($productChunks as $index => $chunk): ?>
                                <button type="button" 
                                        data-bs-target="#topProductsCarousel" 
                                        data-bs-slide-to="<?php echo $index; ?>" 
                                        class="<?php echo $index === 0 ? 'active' : ''; ?>" 
                                        aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                                        aria-label="Slide <?php echo $index + 1; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Orders Table with Filter -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Order List</h5>
                <div class="filter-container">
                    <label for="orderFilter" class="me-2 fw-bold">Show:</label>
                    <select id="orderFilter" class="form-select w-auto d-inline-block" aria-label="Filter Orders">
                        <option value="5">5 Orders</option>
                        <option value="10">10 Orders</option>
                        <option value="20">20 Orders</option>
                        <option value="all" selected>All Orders</option>
                    </select>
                </div>
            </div>
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
                            <tr data-order-id="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <th scope="row" data-label="S.No"><?php echo $index + 1; ?></th>
                                <td data-label="Order Date"><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                <td data-label="Order Time"><?php echo date('H:i:s A', strtotime($order['order_date'])); ?></td>
                                <td data-label="Order Price" class="fw-bold text-primary">$<?php echo htmlspecialchars($order['total_amount']); ?></td>
                                <td data-label="Payment Status">
                                    <span class="badge <?php echo $order['payment_mode'] === 'paid' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo htmlspecialchars($order['payment_mode']); ?>
                                    </span>
                                </td>
                                <td data-label="Action">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <a class="dropdown-item" href="/orders/view/<?php echo htmlspecialchars($order['order_id']); ?>">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger delete-order" 
                                                   href="javascript:void(0);" 
                                                   data-order-id="<?php echo htmlspecialchars($order['order_id']); ?>">
                                                    <i class="bi bi-trash me-2"></i>Delete Order
                                                </a>
                                                <form id="delete-form-<?php echo htmlspecialchars($order['order_id']); ?>" 
                                                      action="/orders/delete/<?php echo htmlspecialchars($order['order_id']); ?>" 
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
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Order deleted successfully!
            </div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Failed to delete order. Please try again.
            </div>
        </div>
    </div>
</div>

<style>
    /* Product image frame */
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
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
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

    /* Rank badge styling */
    .rank-badge {
        transform: translate(-10px, 10px);
        z-index: 10;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 5px 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    /* Creative hover effects */
    .product-card:hover .image-frame {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2), 0 0 10px rgba(69,170,242,0.3);
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Carousel styles */
    .carousel {
        position: relative;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        overflow: hidden;
    }

    .carousel-inner {
        padding: 0 15px;
    }

    .carousel-item {
        transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
        opacity: 0;
    }

    .carousel-item.active {
        opacity: 1;
        animation: slideIn 0.6s ease-in-out;
    }

    /* Slide animation */
    @keyframes slideIn {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Custom carousel controls */
    .carousel-control-prev,
    .carousel-control-next {
        width: 8%;
        background: linear-gradient(to right, rgba(0,0,0,0.5), transparent);
        opacity: 0.7;
        transition: opacity 0.3s ease, transform 0.3s ease;
        border-radius: 10px;
    }

    .carousel-control-next {
        background: linear-gradient(to left, rgba(0,0,0,0.5), transparent);
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    .custom-control-icon {
        width: 2rem;
        height: 2rem;
        background-size: 60%;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    /* Carousel indicators */
    .carousel-indicators {
        bottom: -40px;
        margin-bottom: 0;
    }

    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #6c757d;
        opacity: 0.5;
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .carousel-indicators .active {
        opacity: 1;
        background-color: #007bff;
        transform: scale(1.2);
    }

    /* Layout adjustments */
    .d-flex.flex-column.flex-md-row {
        flex-direction: row;
        align-items: flex-start;
        text-align: left;
    }

    .text-center.text-md-start {
        text-align: left;
    }

    .filter-container {
        display: flex;
        align-items: center;
    }

    .form-select {
        border-color: #6c757d;
        background-color: #fff;
        color: #343a40;
        font-weight: 500;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    }

    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    /* Tablet view */
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
        .filter-container {
            flex-direction: column;
            align-items: flex-end;
        }
        .form-select {
            width: 100%;
            max-width: 200px;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 10%;
        }
        .rank-badge {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    }

    /* Mobile view */
    @media (max-width: 576px) {
        table thead {
            display: none;
        }
        table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 1rem;
            border: none;
            border-bottom: 1px solid #eee;
        }
        table tbody td:last-child {
            border-bottom: none;
        }
        table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            margin-right: 10px;
        }
        .dropdown {
            text-align: center;
        }
        .carousel-item .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .d-flex.flex-column.flex-md-row {
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
        }
        .text-center.text-md-start {
            text-align: center !important;
        }
        .image-frame {
            max-width: 200px;
            margin-bottom: 15px;
        }
        .badge {
            font-size: 0.85rem;
        }
        .row.g-4.p-4 {
            padding: 1rem !important;
        }
        .filter-container {
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .form-select {
            width: 100%;
            max-width: 100%;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 12%;
        }
        .carousel-indicators {
            bottom: -30px;
        }
        .rank-badge {
            font-size: 0.75rem;
            padding: 3px 6px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DOM elements
        const deleteButtons = document.querySelectorAll('.delete-order');
        const orderFilter = document.getElementById('orderFilter');
        const ordersTableBody = document.getElementById('ordersTableBody');
        const rows = ordersTableBody?.querySelectorAll('tr') || [];
        const carouselElement = document.getElementById('topProductsCarousel');

        // Valid filter options
        const validFilters = ['5', '10', '20', 'all'];

        /**
         * Initialize Bootstrap Carousel
         */
        function initializeCarousel() {
            if (!carouselElement) {
                // console.warn('Carousel element not found');
                return;
            }
            try {
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 5000,
                    ride: 'carousel',
                    pause: 'hover',
                    wrap: true
                });
                // Reset animations on slide change
                carouselElement.addEventListener('slide.bs.carousel', () => {
                    const activeItem = carouselElement.querySelector('.carousel-item.active');
                    if (activeItem) {
                        activeItem.querySelectorAll('.product-card').forEach(card => {
                            card.style.animation = 'none';
                            card.offsetHeight; // Trigger reflow
                            card.style.animation = null;
                        });
                    }
                });
                // Verify badge visibility
                // console.log('Rank badges:', carouselElement.querySelectorAll('.rank-badge').length);
            } catch (error) {
                console.error('Carousel initialization failed:', error);
            }
        }

        /**
         * Filter orders and update S.No
         * @param {string} limit - Number of orders to show or 'all'
         */
        function filterOrders(limit) {
            try {
                const displayLimit = limit === 'all' ? rows.length : parseInt(limit);
                rows.forEach((row, index) => {
                    row.style.display = index < displayLimit ? '' : 'none';
                });
                // Update S.No for visible rows
                const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
                visibleRows.forEach((row, index) => {
                    row.querySelector('th').textContent = index + 1;
                });
            } catch (error) {
                console.error('Filter orders failed:', error);
            }
        }

        /**
         * Load saved filter from localStorage
         */
        function loadSavedFilter() {
            try {
                const savedFilter = localStorage.getItem('orderFilter');
                if (savedFilter && validFilters.includes(savedFilter)) {
                    orderFilter.value = savedFilter;
                    filterOrders(savedFilter);
                } else {
                    orderFilter.value = 'all';
                    localStorage.setItem('orderFilter', 'all');
                    filterOrders('all');
                }
            } catch (error) {
                console.error('Load saved filter failed:', error);
                orderFilter.value = 'all';
                filterOrders('all');
            }
        }

        /**
         * Save filter to localStorage and apply it
         * @param {string} limit - Filter value
         */
        function saveAndApplyFilter(limit) {
            try {
                if (validFilters.includes(limit)) {
                    localStorage.setItem('orderFilter', limit);
                    filterOrders(limit);
                } else {
                    localStorage.setItem('orderFilter', 'all');
                    orderFilter.value = 'all';
                    filterOrders('all');
                }
            } catch (error) {
                console.error('Save filter failed:', error);
            }
        }

        /**
         * Handle order deletion
         * @param {HTMLElement} button - Delete button element
         */
        function handleDeleteOrder(button) {
            const orderId = button.getAttribute('data-order-id');
            const form = document.getElementById(`delete-form-${orderId}`);
            const row = button.closest('tr');

            if (!form || !row) {
                console.error('Delete form or row not found for order:', orderId);
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
                .then(response => {
                    if (response.ok) {
                        const successToast = new bootstrap.Toast(document.getElementById('successToast'), { delay: 3000 });
                        successToast.show();
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            // Reindex visible rows
                            const visibleRows = Array.from(rows).filter(r => r.style.display !== 'none');
                            visibleRows.forEach((r, index) => {
                                r.querySelector('th').textContent = index + 1;
                            });
                        }, 300);
                    } else {
                        throw new Error('Delete request failed');
                    }
                })
                .catch(error => {
                    const errorToast = new bootstrap.Toast(document.getElementById('errorToast'), { delay: 3000 });
                    errorToast.show();
                    console.error('Delete order failed:', error);
                });
        }

        // Initialize
        initializeCarousel();
        loadSavedFilter();

        // Event listeners
        if (orderFilter) {
            orderFilter.addEventListener('change', () => saveAndApplyFilter(orderFilter.value));
        }

        deleteButtons.forEach(button => {
            button.addEventListener('click', e => {
                e.preventDefault();
                handleDeleteOrder(button);
            });
        });
    });
</script>