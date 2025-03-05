<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Product List Widget -->
    <div class="card mb-0">
        <div class="card-widget-separator-wrapper">
            <div class="card-body">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-3 col-lg-4">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                            <div>
                                <p class="mb-1">In-store Sales</p>
                                <h4 class="mb-1">$1</h4>
                                <p class="mb-0"><span class="me-">5k orders</span><span class="badge bg-label-success">+5.7%</span></p>
                            </div>
                            <span class="avatar me-sm-5">
                                <span class="avatar-initial rounded w-px-44 h-px-44">
                                    <i class="icon-base bx bx-store-alt icon-lg text-heading"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6">
                    </div>
                    <div class="col-sm-5 col-lg-4">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <p class="mb-1">Website Sales</p>
                                <h4 class="mb-1">$1</h4>
                                <p class="mb-0"><span class="me-5">21k orders</span><span class="badge bg-label-success">+12.4%</span></p>
                            </div>
                            <span class="avatar p-3 me-lg-5">
                                <span class="avatar-initial rounded w-px-44 h-px-44">
                                    <i class="icon-base bx bx-laptop icon-lg text-heading"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>

                    <div class="col-sm-5 col-lg-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">Affiliate</p>
                                <h4 class="mb-1">$8,34</h4>
                                <p class="mb-0"><span class="me-2">150 orders</span><span class="badge bg-label-danger">-3.5%</span></p>
                            </div>
                            <span class="avatar ">
                                <span class="avatar-initial rounded w-px-44 h-px-44">
                                    <i class="icon-base bx bx-wallet icon-lg text-heading"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product List Table -->
    <div class="card mt-3">
        <div class="card-header border-bottom">
            <h5 class="card-title">Filter</h5>
            <div class="d-flex justify-content-between align-items-center row pt-2 gap-6 gap-md-0 g-md-5">
                <div class="col-md-4 product_status"><select id="ProductStatus" class="form-select text-capitalize">
                        <option value="">Status</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Publish">Publish</option>
                        <option value="Inactive">Inactive</option>
                    </select></div>
                <div class="col-md-4 product_category"><select id="ProductCategory" class="form-select text-capitalize">
                        <option value="">Category</option>
                        <option value="Drink">Drink</option>
                        <option value="Food">Food</option>
                        <option value="Noodle">Noodle</option>

                    </select></div>
                <div class="col-md-4 product_stock"><select id="ProductStock" class="form-select text-capitalize">
                        <option value="">Stock</option>
                        <option value="Out">Out of Stock</option>
                        <option value="In">In Stock</option>
                    </select></div>
            </div>
        </div>
        <div class="card-datatable">
            <div id="DataTables_Table_0_wrapper" class="dt-container">
                <div class="row m-4 justify-content-between">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                        <!-- Search Box -->
                        <div class="dt-search">
                            <input type="search" class="form-control" id="dt-search-0" placeholder="Search Product" aria-controls="DataTables_Table_0">
                        </div>

                        <div class="d-flex align-items-center gap-3">

                            <!-- Items Per Page Dropdown -->
                            <div class="dt-length">
                                <select name="DataTables_Table_0_length" id="dt-length-0" class="form-select" aria-controls="DataTables_Table_0">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <!-- Export Button Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                                    <i class="bx bx-export"></i>
                                    <span class="d-none d-sm-inline-block">Export</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bxs-file-pdf text-danger me-2"></i> Export as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bxs-file-excel text-success me-2"></i> Export as Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bxs-file text-primary me-2"></i> Export as CSV
                                        </a>
                                    </li>
                                </ul>

                            </div>

                            <!-- Add Product Button -->
                            <button class="btn btn-primary">
                                <i class="bx bx-plus"></i>
                                <span class="d-none d-sm-inline-block">Add Product</span>
                            </button>

                        </div>
                    </div>

                </div>
            </div>
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-products table dataTable dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                        <colgroup>
                            <col data-dt-column="0" style="width: 53.25px;">
                            <col data-dt-column="1" style="width: 64.3438px;">
                            <col data-dt-column="2" style="width: 475.531px;">
                            <col data-dt-column="3" style="width: 178.49px;">
                            <col data-dt-column="4" style="width: 94.2708px;">
                            <col data-dt-column="7" style="width: 85.4479px;">
                        </colgroup>
                        <thead class="border-top">
                            <tr>
                                <th data-dt-column="0" class="control dt-orderable-none" rowspan="1" colspan="1" aria-label=""><span class="dt-column-title"></span><span class="dt-column-order"></span></th>
                                <th data-dt-column="1" rowspan="1" colspan="1" class="dt-select dt-orderable-none" aria-label=""><span class="dt-column-title"></span><span class="dt-column-order"></span><input class="form-check-input" type="checkbox" aria-label="Select all rows"></th>
                                <th data-dt-column="2" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-ordering-asc" aria-sort="ascending" aria-label="product: Activate to invert sorting" tabindex="0"><span class="dt-column-title" role="button">product</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="3" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="category: Activate to sort" tabindex="0"><span class="dt-column-title" role="button">category</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="4" rowspan="1" colspan="1" class="dt-orderable-none" aria-label="stock"><span class="dt-column-title">stock</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="5" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-type-numeric dtr-hidden" aria-label="sku: Activate to sort" tabindex="0" style="display: none;"><span class="dt-column-title" role="button">sku</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="6" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-type-numeric dtr-hidden" aria-label="price: Activate to sort" tabindex="0" style="display: none;"><span class="dt-column-title" role="button">price</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="7" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-type-numeric" aria-label="qty: Activate to sort" tabindex="0"><span class="dt-column-title" role="button">qty</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="8" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dtr-hidden" aria-label="status: Activate to sort" tabindex="0" style="display: none;"><span class="dt-column-title" role="button">status</span><span class="dt-column-order"></span></th>
                                <th data-dt-column="9" rowspan="1" colspan="1" class="dt-orderable-none dtr-hidden" aria-label="Actions" style="display: none;"><span class="dt-column-title">Actions</span><span class="dt-column-order"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/milktea.png" alt="Product-9" class="rounded" data-bs-toggle="modal" data-bs-target="#productModal"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Milk Tea</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out of stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>31063</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$125</span></td>
                                <td class="dt-type-numeric"><span>942</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-danger" text-capitalized="">Inactive</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/caffe.png" alt="Product-13" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Caffe</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out of stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>5829</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$263.49</span></td>
                                <td class="dt-type-numeric"><span>587</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-warning" text-capitalized="">Scheduled</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/lemontea.png" alt="Product-15" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Lemone Tea</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">In_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>35946</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$248.39</span></td>
                                <td class="dt-type-numeric"><span>468</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-success" text-capitalized="">Publish</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/lemone-b.png" alt="Product-5" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Lemone Tea green</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out_of_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>46658</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$799</span></td>
                                <td class="dt-type-numeric"><span>851</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-warning" text-capitalized="">Scheduled</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/caffe-back.png" alt="Product-16" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Caffe Black</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">In_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>41867</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$79.99</span></td>
                                <td class="dt-type-numeric"><span>519</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-danger" text-capitalized="">Inactive</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/pizza-m.png" alt="Product-18" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Pizza size M</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-danger me-4">
                                            <i class="icon-base bx bx-pizza icon-18px"></i>
                                        </span>pizza
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">In_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>63474</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$399</span></td>
                                <td class="dt-type-numeric"><span>810</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-warning" text-capitalized="">Scheduled</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/noodle.png" alt="Product-3" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Noodle MaMa</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-warning me-4">
                                            <i class="icon-base bx bx-noodle icon-18px"></i>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out_of_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>29540</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$16.34</span></td>
                                <td class="dt-type-numeric"><span>804</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-success" text-capitalized="">Publish</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/pizza-L.png" alt="Product-2" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Pizza size L</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-danger me-4">
                                            <i class="icon-base bx bx-pizza icon-18px"></i>
                                        </span>Electronics
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out_of_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>72836</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$25.50</span></td>
                                <td class="dt-type-numeric"><span>827</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-success" text-capitalized="">Publish</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/milktea.png" alt="Product-19" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Milk Tea</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out_of_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>15859</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$23.99</span></td>
                                <td class="dt-type-numeric"><span>735</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-danger" text-capitalized="">Inactive</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="control" tabindex="0"></td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="/views/products/images-product/milktea.png" alt="Product-4" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">Milk Tea</h6>
                                            <small class="text-truncate d-none d-sm-block">Lorem ipsum dolor sit amet consectetur.</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span>Drink
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out_of_Stock</span>
                                    </span>
                                </td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>49402</span></td>
                                <td class="dt-type-numeric dtr-hidden" style="display: none;"><span>$36.98</span></td>
                                <td class="dt-type-numeric"><span>528</span></td>
                                <td class="dtr-hidden" style="display: none;"><span class="badge bg-label-warning" text-capitalized="">Scheduled</span></td>
                                <td class="dtr-hidden" style="display: none;">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></button>
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
            <div class="row mx-3 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status">Showing 1 to 10 of 100 entries</div>
                </div>
                <div class="d-md-flex align-items-center dt-layout-end col-md-auto ms-auto justify-content-md-between justify-content-center d-flex flex-wrap gap-2 mb-md-0 mb-4 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                <li class="dt-paging-button page-item disabled"><button class="page-link previous" role="link" type="button" aria-controls="DataTables_Table_0" aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1"><i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i></button></li>
                                <li class="dt-paging-button page-item active"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" aria-current="page" data-dt-idx="0">1</button></li>
                                <li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="1">2</button></li>
                                <li class="dt-paging-button page-item disabled"><button class="page-link ellipsis" role="link" type="button" aria-controls="DataTables_Table_0" aria-disabled="true" data-dt-idx="ellipsis" tabindex="-1">…</button></li>
                                <li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="9">6</button></li>
                                <li class="dt-paging-button page-item"><button class="page-link next" role="link" type="button" aria-controls="DataTables_Table_0" aria-label="Next" data-dt-idx="next"><i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i></button></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Details of Air Jordan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <!-- Product Row -->
                            <tr>
                                <td><strong>Product:</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-wrapper me-3">
                                            <div class="avatar avatar-xl ">
                                                <img src="/views/products/images-product/milktea.png" alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0">Milk Tea</h6>
                                            <small class="text-muted">Air Jordan is a line of basketball </small>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Category Row -->
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>
                                    <span class="d-flex align-items-center">
                                        <span class="w-px-30 h-px-30 rounded-circle bg-label-success me-2 d-flex justify-content-center align-items-center">
                                            <i class="icon-base bx bx-drink icon-18px"></i>
                                        </span> Drink
                                    </span>
                                </td>
                            </tr>

                            <!-- Stock Row -->
                            <tr>
                                <td><strong>Stock:</strong></td>
                                <td>
                                    <label class="switch switch-primary switch-sm">
                                        <input type="checkbox" class="switch-input" id="switch">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                    <span class="d-none">Out_of_Stock</span>
                                </td>
                            </tr>
                            <!-- Price Row -->
                            <tr>
                                <td><strong>Price:</strong></td>
                                <td><span>$125</span></td>
                            </tr>

                            <!-- Quantity Row -->
                            <tr>
                                <td><strong>Quantity:</strong></td>
                                <td><span>942</span></td>
                            </tr>

                            <!-- Status Row -->
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><span class="badge bg-label-danger">Inactive</span></td>
                            </tr>

                            <!-- Actions Row -->
                            <tr>
                                <td><strong>Actions:</strong></td>
                                <td>
                                    <div class="d-inline-block">
                                        <button class="btn btn-icon">
                                            <i class="icon-base bx bx-edit icon-md"></i>
                                        </button>
                                        <!-- Dropdown Button -->
                                        <button class="btn btn-icon" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="javascript:void(0);" class="dropdown-item">View</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Suspend</a>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        border-radius: 20px;
        transition: 0.4s;
    }

    .switch input:checked+.switch-toggle-slider {
        background-color: #0d6efd;
    }

    .switch-toggle-slider::before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    .switch input:checked+.switch-toggle-slider::before {
        transform: translateX(20px);
    }
</style>