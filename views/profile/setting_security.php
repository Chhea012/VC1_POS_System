<div class="container-xxl flex-grow-1 container-p-y">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-account.html"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-lock-alt icon-sm me-1_5"></i> Setting Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-billing.html"><i class="icon-base bx bx-detail icon-sm me-1_5"></i> Billing &amp; Plans</a>
                        </li>
                    </ul>
                </div>
                <!-- Change Password -->
                <div class="card mb-6 mt-2">
                    <h5 class="card-header ">Change Password</h5>
                    <div class="card-body pt-1">
                        <form id="formAccountSettings" method="GET" onsubmit="return false" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                            <div class="row">
                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation fv-plugins-icon-container">
                                    <label class="form-label" for="currentPassword">Current Password</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control" type="password" name="currentPassword" id="currentPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                    </div>
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation fv-plugins-icon-container">
                                    <label class="form-label" for="newPassword">New Password</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                    </div>
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>

                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation fv-plugins-icon-container">
                                    <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                    </div>
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <h6 class="text-body">Password Requirements:</h6>
                            <ul class="ps-4 mb-0">
                                <li class="mb-4">Minimum 8 characters long - the more, the better</li>
                                <li class="mb-4">At least one lowercase character</li>
                                <li>At least one number, symbol, or whitespace character</li>
                            </ul>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            <input type="hidden">
                        </form>
                    </div>
                </div>
                <!--/ Change Password -->

                <!-- Two-steps verification -->
                <div class="card mb-6 mt-4">
                    <div class="card-body">
                        <h5 class="mb-6">Two-steps verification</h5>
                        <h5 class="mb-4 text-body">Two factor authentication is not enabled yet.</h5>
                        <p class="w-75">
                            Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.
                            <a href="javascript:void(0);" class="text-nowrap">Learn more.</a>
                        </p>
                        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#enableOTP">Enable Two-Factor Authentication</button>
                    </div>
                </div>

                Modal
                <!-- Enable OTP Modal -->
                <div class="modal fade" id="enableOTP" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <div class="text-center mb-6">
                                    <h4 class="mb-2">Enable One Time Password</h4>
                                    <p>Verify Your Mobile Number for SMS</p>
                                </div>
                                <p>Enter your mobile phone number with country code and we will send you a verification code.</p>
                                <form id="enableOTPForm" class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" novalidate="novalidate">
                                    <div class="col-12 form-control-validation fv-plugins-icon-container">
                                        <label class="form-label" for="modalEnableOTPPhone">Phone Number</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text">US (+1)</span>
                                            <input type="text" id="modalEnableOTPPhone" name="modalEnableOTPPhone" class="form-control phone-number-otp-mask" placeholder="202 555 0111">
                                        </div>
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-3">Send OTP</button>
                                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    </div>
                                    <input type="hidden">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Enable OTP Modal -->

                <!-- /Modal -->

                <!--/ Two-steps verification -->

                <!-- Create an API key -->
                <div class="card mb-6 mt-4">
                    <h5 class="card-header">Create an API key</h5>
                    <div class="row">
                        <div class="col-md-5 order-md-0 order-1">
                            <div class="card-body pt-md-0">
                                <form id="formAccountSettingsApiKey" method="GET" onsubmit="return false" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                    <div class="row fv-plugins-icon-container">
                                        <div class="mb-5 col-12">
                                            <label for="apiAccess" class="form-label">Choose the Api key type you want to create</label>
                                            <div class="position-relative"><select id="apiAccess" class="select2 form-select select2-hidden-accessible" data-select2-id="apiAccess" tabindex="-1" aria-hidden="true">
                                                    <option value="" data-select2-id="2">Choose Key Type</option>
                                                    <option value="full">Full Control</option>
                                                    <option value="modify">Modify</option>
                                                    <option value="read-execute">Read &amp; Execute</option>
                                                    <option value="folders">List Folder Contents</option>
                                                    <option value="read">Read Only</option>
                                                    <option value="read-write">Read &amp; Write</option>
                                                </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 439.825px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-apiAccess-container"><span class="select2-selection__rendered" id="select2-apiAccess-container" role="textbox" aria-readonly="true" title="Choose Key Type">Choose Key Type</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                                        </div>
                                        <div class="mb-5 col-12">
                                            <label for="apiKey" class="form-label">Name the API key</label>
                                            <input type="text" class="form-control" id="apiKey" name="apiKey" placeholder="Server Key 1">
                                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-2 d-grid w-100">Create Key</button>
                                        </div>
                                    </div>
                                    <input type="hidden">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7 order-md-1 order-0">
                            <div class="text-center mt-5 mx-3 mx-md-0">
                                <img src="../../assets/img/illustrations/sitting-girl-with-laptop.png" class="img-fluid" alt="Api Key Image" width="300">
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Create an API key -->

                <!-- API Key List & Access -->
                <div class="card mb-6 mt-4">
                    <div class="card-body">
                        <h5>API Key List &amp; Access</h5>
                        <p class="mb-6">An API key is a simple encrypted string that identifies an application without any principal. They are useful for accessing public data anonymously, and are used to associate API requests with your project for quota and billing.</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bg-lighter rounded p-4 mb-6 position-relative">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="mb-0 me-3">Server Key 1</h5>
                                        <span class="badge bg-label-primary">Full Access</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <p class="me-3 mb-0 fw-medium">23eaf7f0-f4f7-495e-8b86-fad3261282ac</p>
                                        <span class="cursor-pointer"><i class="icon-base bx bx-copy"></i></span>
                                    </div>
                                    <span class="text-body-secondary">Created on 28 Apr 2021, 18:20 GTM+4:10</span>
                                </div>
                                <div class="bg-lighter rounded p-4 position-relative mb-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="mb-0 me-3">Server Key 2</h5>
                                        <span class="badge bg-label-primary">Read Only</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <p class="me-3 mb-0 fw-medium">bb98e571-a2e2-4de8-90a9-2e231b5e99</p>
                                        <span class="cursor-pointer"><i class="icon-base bx bx-copy"></i></span>
                                    </div>
                                    <span class="text-body-secondary">Created on 12 Feb 2021, 10:30 GTM+2:30</span>
                                </div>
                                <div class="bg-lighter rounded p-4 position-relative">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="mb-0 me-3">Server Key 3</h5>
                                        <span class="badge bg-label-primary">Full Access</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <p class="me-3 mb-0 fw-medium">2e915e59-3105-47f2-8838-6e46bf83b711</p>
                                        <span class="cursor-pointer"><i class="icon-base bx bx-copy"></i></span>
                                    </div>
                                    <span class="text-body-secondary">Created on 28 Dec 2020, 12:21 GTM+4:10</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ API Key List & Access -->

                <!-- Recent Devices -->
                <div class="card mb-6 mt-4">
                    <h5 class="card-header">Recent Devices</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-truncate">Browser</th>
                                    <th class="text-truncate">Device</th>
                                    <th class="text-truncate">Location</th>
                                    <th class="text-truncate">Recent Activitiy</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium"><i class="icon-base bx bxl-windows icon-md align-top text-info me-4"></i>Chrome on Windows</td>
                                    <td class="text-truncate">HP Spectre 360</td>
                                    <td class="text-truncate">Switzerland</td>
                                    <td class="text-truncate">10, July 2021 20:07</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium"><i class="icon-base bx bxl-android  icon-md align-top text-success me-4"></i>Chrome on iPhone</td>
                                    <td class="text-truncate">iPhone 12x</td>
                                    <td class="text-truncate">Australia</td>
                                    <td class="text-truncate">13, July 2021 10:10</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium"><i class="icon-base bx bxl-apple icon-md align-top text-secondary me-4"></i>Chrome on Android</td>
                                    <td class="text-truncate">Oneplus 9 Pro</td>
                                    <td class="text-truncate">Dubai</td>
                                    <td class="text-truncate">14, July 2021 15:15</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium"><i class="icon-base bx bx-mobile-alt icon-md align-top text-danger me-4"></i>Chrome on MacOS</td>
                                    <td class="text-truncate">Apple iMac</td>
                                    <td class="text-truncate">India</td>
                                    <td class="text-truncate">16, July 2021 16:17</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium"><i class="icon-base bx bxl-apple icon-md align-top text-warning me-4"></i>Chrome on Windows</td>
                                    <td class="text-truncate">HP Spectre 360</td>
                                    <td class="text-truncate">Switzerland</td>
                                    <td class="text-truncate">20, July 2021 21:01</td>
                                </tr>
                                <tr class="border-transparent">
                                    <td class="text-truncate text-heading fw-medium"><i class="icon-base bx bxl-android icon-md align-top text-success me-4"></i>Chrome on Android</td>
                                    <td class="text-truncate">Oneplus 9 Pro</td>
                                    <td class="text-truncate">Dubai</td>
                                    <td class="text-truncate">21, July 2021 12:22</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Recent Devices -->
            </div>
        </div>

    </div>
</div>




















