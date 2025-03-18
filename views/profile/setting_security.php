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
    <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Security</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="/edit_profile"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-lock-alt icon-sm me-1_5"></i> Setting Security</a>
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
                <!--/ Recent Devices -->
            </div>
        </div>

    </div>
</div>




















