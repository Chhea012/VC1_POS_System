<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span>Billing and Plans</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6">
                    <li class="nav-item">
                        <a class="nav-link" href="/edit_profile"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/setting_security"><i class="icon-base bx bx-lock-alt icon-sm me-1_5"></i> Setting Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-detail icon-sm me-1_5"></i> Billing &amp; Plans</a>
                    </li>
                </ul>
            </div>
            <div class="card mb-6 mt-4">
                <h5 class="card-header">Payment Methods</h5>
                <div class="card-body">
                    <div class="row gx-6">
                        <div class="col-md-6">
                            <form id="creditCardForm" class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework fv-plugins-icon-container" onsubmit="return false" novalidate="novalidate">
                                <div class="col-12">
                                    <div class="form-check form-check-inline my-2 ms-2 me-6">
                                        <input name="collapsible-payment" class="form-check-input" type="radio" value="" id="collapsible-payment-cc" checked="">
                                        <label class="form-check-label" for="collapsible-payment-cc">Credit/Debit/ATM Card</label>
                                    </div>
                                    <div class="form-check form-check-inline ms-2 my-2">
                                        <input name="collapsible-payment" class="form-check-input" type="radio" value="" id="collapsible-payment-cash">
                                        <label class="form-check-label" for="collapsible-payment-cash">Paypal account</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label w-100" for="paymentCard">Card Number</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input id="paymentCard" name="paymentCard" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" aria-describedby="paymentCard2">
                                        <span class="input-group-text cursor-pointer" id="paymentCard2"><span class="card-type"></span></span>
                                    </div>
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="paymentName">Name</label>
                                    <input type="text" id="paymentName" class="form-control" placeholder="John Doe">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label" for="paymentExpiryDate">Exp. Date</label>
                                    <input type="text" id="paymentExpiryDate" class="form-control expiry-date-mask" placeholder="MM/YY">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label" for="paymentCvv">CVV Code</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="paymentCvv" class="form-control cvv-code-mask" maxlength="3" placeholder="654">
                                        <span class="input-group-text cursor-pointer" id="paymentCvv2"><i class="icon-base bx bx-help-circle text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Card Verification Value" data-bs-original-title="Card Verification Value"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch ms-2 my-2">
                                        <input type="checkbox" class="form-check-input" id="future-billing">
                                        <label for="future-billing" class="switch-label">Save card for future billing?</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-6">
                                    <button type="submit" class="btn btn-primary me-3">Save Changes</button>
                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                </div>
                                <input type="hidden">
                            </form>
                        </div>
                        <div class="col-md-6 mt-12 mt-md-0">
                            <h6 class="mb-6">My Cards</h6>
                            <div class="added-cards">
                                <div class="cardMaster p-6 bg-lighter rounded mb-6">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                                        <div class="card-information me-2">
                                            <img class="mb-2" src="views/assets/modules/img/icons/payments/mastercard.png" alt="Master Card" height="25">
                                            <div class="d-flex align-items-center mb-2 flex-wrap gap-2">
                                                <h6 class="mb-0 me-2">Tom McBride</h6>
                                                <span class="badge bg-label-primary">Primary</span>
                                            </div>
                                            <span class="card-number">∗∗∗∗ ∗∗∗∗ 9856</span>
                                        </div>
                                        <div class="d-flex flex-column text-start text-lg-end">
                                            <div class="d-flex order-sm-0 order-1 mt-sm-0 mt-4">
                                                <button class="btn btn-sm btn-label-primary me-4" data-bs-toggle="modal" data-bs-target="#editCCModal">Edit</button>
                                                <button class="btn btn-sm btn-label-danger">Delete</button>
                                            </div>
                                            <small class="mt-sm-4 mt-2 order-sm-1 order-0">Card expires at 12/26</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="cardMaster p-6 bg-lighter rounded">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                                        <div class="card-information me-2">
                                            <img class="mb-2" src="views/assets/modules/img/icons/payments/visa.png" alt="Visa Card" height="25">
                                            <h6 class="mb-2">Mildred Wagner</h6>
                                            <span class="card-number">∗∗∗∗ ∗∗∗∗ 5896</span>
                                        </div>
                                        <div class="d-flex flex-column text-start text-lg-end">
                                            <div class="d-flex order-sm-0 order-1 mt-sm-0 mt-4">
                                                <button class="btn btn-sm btn-label-primary me-4" data-bs-toggle="modal" data-bs-target="#editCCModal">Edit</button>
                                                <button class="btn btn-sm btn-label-danger">Delete</button>
                                            </div>
                                            <small class="mt-sm-4 mt-2 order-sm-1 order-0">Card expires at 10/27</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <!-- Add New Credit Card Modal -->
                            <div class="modal fade" id="editCCModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-simple modal-add-new-cc">
                                    <div class="modal-content p-4 p-md-12">
                                        <div class="modal-body">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="text-center mb-6">
                                                <h2>Edit Card</h2>
                                                <p class="text-body-secondary">Edit your saved card details</p>
                                            </div>
                                            <form id="editCCForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" novalidate="novalidate">
                                                <div class="col-12 form-control-validation fv-plugins-icon-container">
                                                    <label class="form-label w-100" for="modalEditCard">Card Number</label>
                                                    <div class="input-group input-group-merge has-validation">
                                                        <input id="modalEditCard" name="modalEditCard" class="form-control credit-card-mask-edit" type="text" placeholder="4356 3215 6548 7898" value="4356 3215 6548 7898" aria-describedby="modalEditCard2">
                                                        <span class="input-group-text cursor-pointer" id="modalEditCard2">
                                                            <span class="card-type-edit"><img src="views/assets/modules/img/icons/payments/visa-cc.png" height="20" alt="credit-card img"></span>
                                                        </span>
                                                    </div>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="modalEditName">Name</label>
                                                    <input type="text" id="modalEditName" class="form-control" placeholder="John Doe" value="John Doe">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="form-label" for="modalEditExpiryDate">Exp. Date</label>
                                                    <input type="text" id="modalEditExpiryDate" class="form-control expiry-date-mask-edit" placeholder="MM/YY" value="08/28">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="form-label" for="modalEditCvv">CVV Code</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="modalEditCvv" class="form-control cvv-code-mask-edit" maxlength="3" placeholder="654" value="XXX">
                                                        <span class="input-group-text cursor-pointer" id="modalEditCvv2"><i class="icon-base bx bx-help-circle text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Card Verification Value" data-bs-original-title="Card Verification Value"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input" id="editPrimaryCard">
                                                        <label for="editPrimaryCard">Set as primary card</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-primary me-sm-4 me-1">Submit</button>
                                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                                <input type="hidden">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Add New Credit Card Modal -->

                            <!--/ Modal -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  mt-4">
                <!-- Billing History -->
                <h5 class="card-header text-md-start text-center">Billing History</h5>
                <div class="card-datatable table-responsive border-top">
                    <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                        <div class="row mx-3 justify-content-between">
                            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto px-3 pe-md-0 mt-2">
                                <div class="dt-length me-2 mb-4"><label for="dt-length-0">Show</label><select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select" id="dt-length-0">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="dt-buttons btn-group flex-wrap mb-0"><button class="btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="icon-base icon-16px bx bx-plus me-md-2"></i><span class="d-md-inline-block d-none">Create Invoice</span></span></button> </div>
                            </div>
                            <div class="d-md-flex align-items-center dt-layout-end col-md-auto ms-auto justify-content-md-between justify-content-center d-flex flex-wrap gap-sm-4 mb-sm-0 mb-6 mt-0 pe-md-3 ps-0">
                                <div class="dt-search me-sm-0 me-4 mt-4"><input type="search" class="form-control" id="dt-search-0" placeholder="Search Invoice" aria-controls="DataTables_Table_0"><label for="dt-search-0"></i></label></div>
                                <div class="invoice_status"><select id="UserRole" class="form-select">
                                        <option value=""> Invoice Status </option>
                                        <option value="Downloaded" class="text-capitalize">Downloaded</option>
                                        <option value="Draft" class="text-capitalize">Draft</option>
                                        <option value="Paid" class="text-capitalize">Paid</option>
                                        <option value="Sent" class="text-capitalize">Sent</option>
                                    </select></div>
                            </div>
                        </div>
                        <div class="justify-content-between dt-layout-table">
                            <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                                <table class="invoice-list-table table border-top dataTable dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                                    <colgroup>
                                        <col data-dt-column="1" style="width: 73.6625px;">
                                        <col data-dt-column="2" style="width: 110.15px;">
                                        <col data-dt-column="3" style="width: 127.525px;">
                                        <col data-dt-column="4" style="width: 320.925px;">
                                        <col data-dt-column="5" style="width: 116.738px;">
                                        <col data-dt-column="6" style="width: 172.762px;">
                                        <col data-dt-column="7" style="width: 131.438px;">
                                        <col data-dt-column="9" style="width: 154px;">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th data-dt-column="0" class="control dt-orderable-asc dt-orderable-desc dtr-hidden" rowspan="1" colspan="1" aria-label=": Activate to sort" tabindex="0" style="display: none;"><span class="dt-column-title" role="button"></span><span class="dt-column-order"></span></th>
                                            <th data-dt-column="1" rowspan="1" colspan="1" class="dt-select dt-orderable-none" aria-label=""><span class="dt-column-title"></span><span class="dt-column-order"></span><input class="form-check-input" type="checkbox" aria-label="Select all rows"></th>
                                            <th data-dt-column="2" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-ordering-desc" aria-sort="descending" aria-label="#: Activate to remove sorting" tabindex="0"><span class="dt-column-title" role="button">#</span><span class="dt-column-order"></span></th>
                                            <th data-dt-column="3" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="status: Activate to sort" tabindex="0"><span class="dt-column-title" role="button">status</span><span class="dt-column-order"></span></th>
                                            <th data-dt-column="4" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="Client: Activate to sort" tabindex="0"><span class="dt-column-title" role="button">Client</span><span class="dt-column-order"></span></th>
                                            <th data-dt-column="5" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-type-numeric" aria-label="Total: Activate to sort" tabindex="0"><span class="dt-column-title" role="button">Total</span><span class="dt-column-order"></span></th>
                                            <th class="text-truncate dt-orderable-asc dt-orderable-desc" data-dt-column="6" rowspan="1" colspan="1" aria-label="Issued Date: Activate to sort" tabindex="0"><span class="dt-column-title" role="button">Issued Date</span><span class="dt-column-order"></span></th>
                                            <th data-dt-column="7" rowspan="1" colspan="1" class="dt-orderable-none" aria-label="Balance"><span class="dt-column-title">Balance</span><span class="dt-column-order"></span></th>
                                            <th class="cell-fit dt-orderable-none" data-dt-column="9" rowspan="1" colspan="1" aria-label="Actions"><span class="dt-column-title">Actions</span><span class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#5089</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Sent<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 05/09/2020
            " data-bs-original-title="<span>
              Sent<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 05/09/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-secondary"><i class="icon-base icon-16px bx bx-envelope"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <!-- <span class="avatar-initial rounded-circle bg-label-success">JK</span> -->
                                                            <img src="views/assets/modules/img/profile/1.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Jamal Kerrod</span></a>
                                                        <small class="text-truncate">Software Development</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">3077</span>$3077</td>
                                            <td>
                                                <span class="d-none">20200508</span>
                                                09 May 2020
                                            </td>
                                            <td><span class="badge bg-label-success text-capitalized"> Paid </span></td>
                                            <td>
                                                <div class="d-flex align-items-center"><a href="javascript:;" data-bs-toggle="tooltip" class="btn btn-icon delete-record" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete"><i class="icon-base bx bx-trash icon-md"></i></a><a href="app-invoice-preview.html" data-bs-toggle="tooltip" class="btn btn-icon" data-bs-placement="top" aria-label="Preview Invoice" data-bs-original-title="Preview Invoice"><i class="icon-base bx bx-show icon-md"></i></a>
                                                    <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow btn-icon p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end"><a href="javascript:;" class="dropdown-item">Download</a><a href="app-invoice-edit.html" class="dropdown-item">Edit</a><a href="javascript:;" class="dropdown-item">Duplicate</a></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Billing History -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Pricing Modal -->
    <div class="modal fade" id="pricingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-pricing">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <!-- Pricing Plans -->
                    <div class="rounded-top">
                        <h4 class="text-center mb-2">Pricing Plans</h4>
                        <p class="text-center mb-0">All plans include 40+ advanced tools and features to boost your product. Choose the best plan to fit your needs.</p>
                        <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 pt-12 pb-4">
                            <label class="switch switch-sm ms-sm-12 ps-sm-12 me-0">
                                <span class="switch-label fs-6 text-body">Monthly</span>
                                <input type="checkbox" class="switch-input price-duration-toggler" checked="">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label fs-6 text-body">Annually</span>
                            </label>
                            <div class="mt-n5 ms-n10 ml-2 mb-10 d-none d-sm-flex align-items-center gap-1">
                                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/pages/pricing-arrow-light.png" alt="arrow img" class="scaleX-n1-rtl pt-1" data-app-dark-img="pages/pricing-arrow-dark.png" data-app-light-img="pages/pricing-arrow-light.png" style="visibility: visible;">
                                <span class="badge badge-sm bg-label-primary rounded-1 mb-2 ">Save up to 10%</span>
                            </div>
                        </div>

                        <div class="row gy-6">
                            <!-- Basic -->
                            <div class="col-xl mb-md-0 px-3">
                                <div class="card border rounded shadow-none">
                                    <div class="card-body pt-12">
                                        <div class="mt-3 mb-5 text-center">
                                            <img src="views/assets/modules/img/icons/unicons/bookmark.png" alt="Basic Image" width="120">
                                        </div>
                                        <h4 class="card-title text-center text-capitalize mb-1">Basic</h4>
                                        <p class="text-center mb-5">A simple start for everyone</p>
                                        <div class="text-center h-px-50">
                                            <div class="d-flex justify-content-center">
                                                <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                                                <h1 class="mb-0 text-primary">0</h1>
                                                <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                                            </div>
                                        </div>

                                        <ul class="list-group my-5 pt-9">
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>100 responses a month</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Unlimited forms and surveys</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Unlimited fields</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Basic form creation tools</span>
                                            </li>
                                            <li class="mb-0 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Up to 2 subdomains</span>
                                            </li>
                                        </ul>

                                        <button type="button" class="btn btn-label-success d-grid w-100" data-bs-dismiss="modal">Your Current Plan</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Pro -->
                            <div class="col-xl mb-md-0 px-3">
                                <div class="card border-primary border shadow-none">
                                    <div class="card-body position-relative pt-4">
                                        <div class="position-absolute end-0 me-5 top-0 mt-4">
                                            <span class="badge bg-label-primary rounded-1">Popular</span>
                                        </div>
                                        <div class="my-5 pt-6 text-center">
                                            <img src="views/assets/modules/img/icons/unicons/wallet-round.png" alt="Pro Image" width="120">
                                        </div>
                                        <h4 class="card-title text-center text-capitalize mb-1">Standard</h4>
                                        <p class="text-center mb-5">For small to medium businesses</p>
                                        <div class="text-center h-px-50">
                                            <div class="d-flex justify-content-center">
                                                <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                                                <h1 class="price-toggle price-yearly text-primary mb-0">7</h1>
                                                <h1 class="price-toggle price-monthly text-primary mb-0 d-none">9</h1>
                                                <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                                            </div>
                                            <small class="price-yearly price-yearly-toggle text-body-secondary">USD 480 / year</small>
                                        </div>

                                        <ul class="list-group my-5 pt-9">
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Unlimited responses</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Unlimited forms and surveys</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Instagram profile page</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Google Docs integration</span>
                                            </li>
                                            <li class="mb-0 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Custom “Thank you” page</span>
                                            </li>
                                        </ul>

                                        <button type="button" class="btn btn-primary d-grid w-100" data-bs-dismiss="modal">Upgrade</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Enterprise -->
                            <div class="col-xl px-3">
                                <div class="card border rounded shadow-none">
                                    <div class="card-body pt-12">
                                        <div class="mt-3 mb-5 text-center">
                                            <img src="views/assets/modules/img/icons/unicons/briefcase-round.png" alt="Pro Image" width="120">
                                        </div>
                                        <h4 class="card-title text-center text-capitalize mb-1">Enterprise</h4>
                                        <p class="text-center mb-5">Solution for big organizations</p>

                                        <div class="text-center h-px-50">
                                            <div class="d-flex justify-content-center">
                                                <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                                                <h1 class="price-toggle price-yearly text-primary mb-0">16</h1>
                                                <h1 class="price-toggle price-monthly text-primary mb-0 d-none">19</h1>
                                                <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                                            </div>
                                            <small class="price-yearly price-yearly-toggle text-body-secondary">USD 960 / year</small>
                                        </div>

                                        <ul class="list-group my-5 pt-9">
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>PayPal payments</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Logic Jumps</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>File upload with 5GB storage</span>
                                            </li>
                                            <li class="mb-4 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Custom domain support</span>
                                            </li>
                                            <li class="mb-0 d-flex align-items-center">
                                                <span class="badge p-50 w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="icon-base bx bx-check icon-xs"></i></span><span>Stripe integration</span>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Pricing Plans -->
            </div>
        </div>
    </div>
    <!--/ Pricing Modal -->
    <script src="views/assets/modules//js/pages-pricing.js"></script>
    <!--/ Modal -->

</div>