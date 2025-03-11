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
            <div class="card mb-6 mt-2">
                <!-- Current Plan -->
                <h5 class="card-header">Current Plan</h5>
                <div class="card-body">
                    <div class="row row-gap-6">
                        <div class="col-md-6 mb-1">
                            <div class="mb-6">
                                <h6 class="mb-1">Your Current Plan is Basic</h6>
                                <p>A simple start for everyone</p>
                            </div>
                            <div class="mb-6">
                                <h6 class="mb-1">Active until Dec 09, 2021</h6>
                                <p>We will send you a notification upon Subscription expiration</p>
                            </div>
                            <div>
                                <h6 class="mb-1"><span class="me-1">$199 Per Month</span> <span class="badge bg-label-primary">Popular</span></h6>
                                <p class="mb-1">Standard plan for small to medium businesses</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning mb-6" role="alert">
                                <h5 class="alert-heading mb-1 d-flex align-items-center gap-2">
                                    <span class="alert-icon rounded-circle"><i class="icon-base bx bx-error icon-md"></i></span>
                                    <span>We need your attention!</span>
                                </h5>
                                <span class="ms-11 ps-1">Your plan requires update</span>
                            </div>
                            <div class="plan-statistics">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Days</h6>
                                    <h6 class="mb-1">12 of 30 Days</h6>
                                </div>
                                <div class="progress rounded mb-1">
                                    <div class="progress-bar w-25 rounded" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>18 days remaining until your plan requires update</small>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#pricingModal">Upgrade Plan</button>
                            <button class="btn btn-label-danger cancel-subscription">Cancel Subscription</button>
                        </div>
                    </div>
                </div>
                <!-- /Current Plan -->
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
            <div class="card mb-6  mt-4">
                <!-- Billing Address -->
                <h5 class="card-header">Billing Address</h5>
                <div class="card-body">
                    <form id="formAccountSettings" onsubmit="return false" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                        <div class="row g-6">
                            <div class="col-sm-6 form-control-validation fv-plugins-icon-container">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" id="companyName" name="companyName" class="form-control" placeholder="ThemeSelection">
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                            <div class="col-sm-6 form-control-validation fv-plugins-icon-container">
                                <label for="billingEmail" class="form-label">Billing Email</label>
                                <input class="form-control" type="text" id="billingEmail" name="billingEmail" placeholder="john.doe@example.com">
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                            <div class="col-sm-6">
                                <label for="taxId" class="form-label">Tax ID</label>
                                <input type="text" id="taxId" name="taxId" class="form-control" placeholder="Enter Tax ID">
                            </div>
                            <div class="col-sm-6">
                                <label for="vatNumber" class="form-label">VAT Number</label>
                                <input class="form-control" type="text" id="vatNumber" name="vatNumber" placeholder="Enter VAT Number">
                            </div>
                            <div class="col-sm-6">
                                <label for="mobileNumber" class="form-label">Mobile</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">US (+1)</span>
                                    <input class="form-control mobile-number" type="text" id="mobileNumber" name="mobileNumber" placeholder="202 555 0111">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="country" class="form-label">Country</label>
                                <div class="position-relative"><select id="country" class="form-select select2 select2-hidden-accessible" name="country" data-select2-id="country" tabindex="-1" aria-hidden="true">
                                        <option selected="" data-select2-id="2">USA</option>
                                        <option>Canada</option>
                                        <option>UK</option>
                                        <option>Germany</option>
                                        <option>France</option>
                                    </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 567.6px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-country-container"><span class="select2-selection__rendered" id="select2-country-container" role="textbox" aria-readonly="true" title="USA">USA</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                            </div>
                            <div class="col-12">
                                <label for="billingAddress" class="form-label">Billing Address</label>
                                <input type="text" class="form-control" id="billingAddress" name="billingAddress" placeholder="Billing Address">
                            </div>
                            <div class="col-sm-6">
                                <label for="state" class="form-label">State</label>
                                <input class="form-control" type="text" id="state" name="state" placeholder="California">
                            </div>
                            <div class="col-sm-6">
                                <label for="zipCode" class="form-label">Zip Code</label>
                                <input type="text" class="form-control zip-code" id="zipCode" name="zipCode" placeholder="231465" maxlength="6">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-4 mt-4">Save changes</button>
                            <button type="reset" class="btn btn-secondary me-4 mt-4">Discard</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
                <!-- /Billing Address -->
            </div>
            <div class="card  mt-4">
                <!-- Billing History -->
                <h5 class="card-header text-md-start text-center">Billing History</h5>
                <div class="card-datatable table-responsive border-top">
                    <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                        <div class="row mx-3 justify-content-between">
                            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto px-3 pe-md-0 mb-4">
                                <div class="dt-length me-2 mb-6"><label for="dt-length-0">Show</label><select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select" id="dt-length-0">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select></div>
                                <div class="dt-buttons btn-group flex-wrap mb-0"><button class="btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="icon-base icon-16px bx bx-plus me-md-2"></i><span class="d-md-inline-block d-none">Create Invoice</span></span></button> </div>
                            </div>
                            <div class="d-md-flex align-items-center dt-layout-end col-md-auto ms-auto justify-content-md-between justify-content-center d-flex flex-wrap gap-sm-4 mb-sm-0 mb-6 mt-0 pe-md-3 ps-0">
                                <div class="dt-search me-sm-0 me-4"><input type="search" class="form-control" id="dt-search-0" placeholder="Search Invoice" aria-controls="DataTables_Table_0"><label for="dt-search-0"></label></div>
                                <div class="invoice_status"><select id="UserRole" class="form-select">
                                        <option value=""> Invoice Status </option>
                                        <option value="Downloaded" class="text-capitalize">Downloaded</option>
                                        <option value="Draft" class="text-capitalize">Draft</option>
                                        <option value="Paid" class="text-capitalize">Paid</option>
                                        <option value="Partial Payment" class="text-capitalize">Partial Payment</option>
                                        <option value="Past Due" class="text-capitalize">Past Due</option>
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
                                                            <span class="avatar-initial rounded-circle bg-label-success">JK</span>
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#5041</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Sent<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 11/19/2020
            " data-bs-original-title="<span>
              Sent<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 11/19/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-secondary"><i class="icon-base icon-16px bx bx-envelope"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <img src="views/assets/modules/img/avatars/3.png" alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Shamus Tuttle</span></a>
                                                        <small class="text-truncate">Software Development</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">2230</span>$2230</td>
                                            <td>
                                                <span class="d-none">20201118</span>
                                                19 Nov 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#5027</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 09/25/2020
            " data-bs-original-title="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 09/25/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-success"><i class="icon-base icon-16px bx bx-check"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <img src="views/assets/modules/img/avatars/4.png" alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Devonne Wallbridge</span></a>
                                                        <small class="text-truncate">Software Development</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">2787</span>$2787</td>
                                            <td>
                                                <span class="d-none">20200924</span>
                                                25 Sept 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#5024</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> -$202<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 08/02/2020
            " data-bs-original-title="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> -$202<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 08/02/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-success"><i class="icon-base icon-16px bx bx-check"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <img src="views/assets/modules/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Ariella Filippyev</span></a>
                                                        <small class="text-truncate">Unlimited Extended License</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">5285</span>$5285</td>
                                            <td>
                                                <span class="d-none">20200801</span>
                                                02 Aug 2020
                                            </td>
                                            <td><span class="d-none">-$202</span><span class="text-heading">-$202</span></td>
                                            <td>
                                                <div class="d-flex align-items-center"><a href="javascript:;" data-bs-toggle="tooltip" class="btn btn-icon delete-record" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete"><i class="icon-base bx bx-trash icon-md"></i></a><a href="app-invoice-preview.html" data-bs-toggle="tooltip" class="btn btn-icon" data-bs-placement="top" aria-label="Preview Invoice" data-bs-original-title="Preview Invoice"><i class="icon-base bx bx-show icon-md"></i></a>
                                                    <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow btn-icon p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end"><a href="javascript:;" class="dropdown-item">Download</a><a href="app-invoice-edit.html" class="dropdown-item">Edit</a><a href="javascript:;" class="dropdown-item">Duplicate</a></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#5020</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Downloaded<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 12/15/2020
            " data-bs-original-title="<span>
              Downloaded<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 12/15/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-info"><i class="icon-base icon-16px bx bx-down-arrow-alt"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <img src="views/assets/modules/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Roy Southerell</span></a>
                                                        <small class="text-truncate">UI/UX Design &amp; Development</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">5219</span>$5219</td>
                                            <td>
                                                <span class="d-none">20201214</span>
                                                15 Dec 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#4995</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 06/09/2020
            " data-bs-original-title="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 06/09/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-success"><i class="icon-base icon-16px bx bx-check"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <img src="views/assets/modules/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Raynell Clendennen</span></a>
                                                        <small class="text-truncate">Template Customization</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">3313</span>$3313</td>
                                            <td>
                                                <span class="d-none">20200608</span>
                                                09 Jun 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#4993</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 10/22/2020
            " data-bs-original-title="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 10/22/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-success"><i class="icon-base icon-16px bx bx-check"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <span class="avatar-initial rounded-circle bg-label-info">LA</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Lutero Aloshechkin</span></a>
                                                        <small class="text-truncate">Unlimited Extended License</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">4836</span>$4836</td>
                                            <td>
                                                <span class="d-none">20201021</span>
                                                22 Oct 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#4989</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Downloaded<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 09/23/2020
            " data-bs-original-title="<span>
              Downloaded<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 09/23/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-info"><i class="icon-base icon-16px bx bx-down-arrow-alt"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <span class="avatar-initial rounded-circle bg-label-danger">LH</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Lorine Hischke</span></a>
                                                        <small class="text-truncate">Unlimited Extended License</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">3623</span>$3623</td>
                                            <td>
                                                <span class="d-none">20200922</span>
                                                23 Sept 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#4989</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Past Due<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 08/01/2020
            " data-bs-original-title="<span>
              Past Due<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> 0<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 08/01/2020
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-danger"><i class="icon-base icon-16px bx bx-error"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <span class="avatar-initial rounded-circle bg-label-success">OG</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Orson Grafton</span></a>
                                                        <small class="text-truncate">Unlimited Extended License</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">5293</span>$5293</td>
                                            <td>
                                                <span class="d-none">20200731</span>
                                                01 Aug 2020
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
                                        <tr>
                                            <td class="control dtr-hidden" tabindex="0" style="display: none;"></td>
                                            <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                            <td class="sorting_1"><a href="app-invoice-preview.html">#4965</a></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-html="true" aria-label="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> $666<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 03/18/2021
            " data-bs-original-title="<span>
              Partial Payment<br>
              <span class=&quot;fw-medium&quot;>Balance:</span> $666<br>
              <span class=&quot;fw-medium&quot;>Due Date:</span> 03/18/2021
            ">
                                                    <span class="badge p-1_5 rounded-pill bg-label-success"><i class="icon-base icon-16px bx bx-check"></i></span>
                                                </span>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3">
                                                            <img src="views/assets/modules/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="pages-profile-user.html" class="text-heading text-truncate"><span class="fw-medium">Yelena O'Hear</span></a>
                                                        <small class="text-truncate">Unlimited Extended License</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dt-type-numeric"><span class="d-none">3789</span>$3789</td>
                                            <td>
                                                <span class="d-none">20210317</span>
                                                18 Mar 2021
                                            </td>
                                            <td><span class="d-none">$666</span><span class="text-heading">$666</span></td>
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
                        <div class="row mx-3 justify-content-between">
                            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto px-3 pe-md-0 mt-0">
                                <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status">Showing 1 to 10 of 50 entries</div>
                            </div>
                            <div class="d-md-flex align-items-center dt-layout-end col-md-auto ms-auto justify-content-md-between justify-content-center d-flex flex-wrap gap-sm-4 mb-sm-0 mb-6 mt-0 pe-md-3 ps-0">
                                <div class="dt-paging">
                                    <nav aria-label="pagination">
                                        <ul class="pagination">
                                            <li class="dt-paging-button page-item disabled"><button class="page-link previous" role="link" type="button" aria-controls="DataTables_Table_0" aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1"><i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i></button></li>
                                            <li class="dt-paging-button page-item active"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" aria-current="page" data-dt-idx="0">1</button></li>
                                            <li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="1">2</button></li>
                                            <li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="2">3</button></li>
                                            <li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="3">4</button></li>
                                            <li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="4">5</button></li>
                                            <li class="dt-paging-button page-item"><button class="page-link next" role="link" type="button" aria-controls="DataTables_Table_0" aria-label="Next" data-dt-idx="next"><i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i></button></li>
                                        </ul>
                                    </nav>
                                </div>
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

                                        <button type="button" class="btn btn-label-primary d-grid w-100" data-bs-dismiss="modal">Upgrade</button>
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