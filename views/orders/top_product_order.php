<style>
    /* Creative styling for the carousel */
    .carousel-inner {
        border-radius: 15px;
    }

    .carousel-item {
        transition: transform 0.5s ease, opacity 0.5s ease;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .drink-img-wrapper img {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Product name styling - bold and easy to see */
    .card-title {
        font-size: 1.25rem !important;
        min-height: 40px;
        font-weight: 700; /* Bold text */
        color: #1a3c6d !important; /* Dark blue for high contrast */
        text-align: center;
        letter-spacing: 0.5px; /* Slight spacing for readability */
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .card:hover .card-title {
        color: #007bff !important; /* Bright blue on hover */
        transform: scale(1.05); /* Slight zoom effect */
    }

    .card-body {
        padding: 15px !important;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .stock-badge {
        font-size: 0.9rem;
        background: linear-gradient(90deg, #007bff, #0056b3);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .stock-badge:hover {
        transform: scale(1.1);
    }

    .btn-outline-primary {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        padding: 20px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">Top Products Ordered:</h5>
    <div class="mb-4 position-relative">
        <div id="popularCarousel" class="carousel slide shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#popularCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#popularCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>

            <!-- Carousel Inner -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-4 justify-content-center align-items-center m-0 p-4" style="min-height: 450px; background: linear-gradient(135deg, #f0eded 0%, #f0f0f0 100%);">
                        <!-- Product 1 -->
                        <div class="col-md-3">
                            <div class="card drink-card h-100 shadow-sm border-0">
                                <div class="drink-img-wrapper text-center position-relative">
                                    <img src="views/products/uploads/2.jpg" class="drink-img img-fluid" style="max-height: 200px; object-fit: cover;" alt="Energy Drink">
                                    <span class="stock-badge position-absolute top-0 end-0 m-2 bg-primary text-white px-2 py-1 rounded">1,245 orders</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">Pizza Potato</h5>
                                    <p class="card-text mb-4">
                                        <span class="price fw-bold">$19.99</span>
                                        <span class="mx-2">•</span>
                                        <span>Rank #1</span>
                                    </p>
                                    <a href="/inventory/viewfood/1" class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                        <!-- Product 2 -->
                        <div class="col-md-3">
                            <div class="card drink-card h-100 shadow-sm border-0">
                                <div class="drink-img-wrapper text-center position-relative">
                                    <img src="views/products/uploads/sting2.jpg" class="drink-img img-fluid" style="max-height: 200px; object-fit: cover;" alt="Sting Energy">
                                    <span class="stock-badge position-absolute top-0 end-0 m-2 bg-primary text-white px-2 py-1 rounded">987 orders</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">Sting Energy</h5>
                                    <p class="card-text mb-4">
                                        <span class="price fw-bold">$24.50</span>
                                        <span class="mx-2">•</span>
                                        <span>Rank #2</span>
                                    </p>
                                    <a href="/inventory/viewfood/2" class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                        <!-- Product 3 -->
                        <div class="col-md-3">
                            <div class="card drink-card h-100 shadow-sm border-0">
                                <div class="drink-img-wrapper text-center position-relative">
                                    <img src="views/products/uploads/mama.jpg" class="drink-img img-fluid" style="max-height: 200px; object-fit: cover;" alt="Mama Noodles">
                                    <span class="stock-badge position-absolute top-0 end-0 m-2 bg-primary text-white px-2 py-1 rounded">654 orders</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">Mama Noodles</h5>
                                    <p class="card-text mb-4">
                                        <span class="price fw-bold">$15.75</span>
                                        <span class="mx-2">•</span>
                                        <span>Rank #3</span>
                                    </p>
                                    <a href="/inventory/viewfood/3" class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                        <!-- Product 4 -->
                        <div class="col-md-3">
                            <div class="card drink-card h-100 shadow-sm border-0">
                                <div class="drink-img-wrapper text-center position-relative">
                                    <img src="views/products/uploads/Champion-Ice-New.png" class="drink-img img-fluid" style="max-height: 200px; object-fit: cover;" alt="Champion Ice">
                                    <span class="stock-badge position-absolute top-0 end-0 m-2 bg-primary text-white px-2 py-1 rounded">543 orders</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">Champion Ice</h5>
                                    <p class="card-text mb-4">
                                        <span class="price fw-bold">$29.99</span>
                                        <span class="mx-2">•</span>
                                        <span>Rank #4</span>
                                    </p>
                                    <a href="/inventory/viewfood/4" class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="row g-4 justify-content-center align-items-center m-0 p-4" style="min-height: 450px; background: linear-gradient(135deg, #f0eded 0%, #f0f0f0 100%);">
                        <!-- Product 5 -->
                        <div class="col-md-3">
                            <div class="card drink-card h-100 shadow-sm border-0">
                                <div class="drink-img-wrapper text-center position-relative">
                                    <img src="views/products/uploads/lactasoy1.jpg" class="drink-img img-fluid" style="max-height: 200px; object-fit: cover;" alt="Lactasoy Milk">
                                    <span class="stock-badge position-absolute top-0 end-0 m-2 bg-primary text-white px-2 py-1 rounded">432 orders</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">Lactasoy Milk</h5>
                                    <p class="card-text mb-4">
                                        <span class="price fw-bold">$12.99</span>
                                        <span class="mx-2">•</span>
                                        <span>Rank #5</span>
                                    </p>
                                    <a href="/inventory/viewfood/5" class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                        <!-- Product 6 -->
                        <div class="col-md-3">
                            <div class="card drink-card h-100 shadow-sm border-0">
                                <div class="drink-img-wrapper text-center position-relative">
                                    <img src="views/products/uploads/ice4.jpg" class="drink-img img-fluid" style="max-height: 200px; object-fit: cover;" alt="Frosty Ice">
                                    <span class="stock-badge position-absolute top-0 end-0 m-2 bg-primary text-white px-2 py-1 rounded">321 orders</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">Frosty Ice</h5>
                                    <p class="card-text mb-4">
                                        <span class="price fw-bold">$22.00</span>
                                        <span class="mx-2">•</span>
                                        <span>Rank #6</span>
                                    </p>
                                    <a href="/inventory/viewfood/6" class="btn btn-outline-primary btn-sm rounded-pill drink-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
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
</div>