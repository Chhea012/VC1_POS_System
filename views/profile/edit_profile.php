<?php
// Make sure $user is available from the controller
if (!isset($user)) {
    $user = [
        'user_name' => '',
        'phone_number' => '',
        'address' => '',
        'language' => '',
        'province' => ''
    ];
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/setting_security"><i class="icon-base bx bx-lock-alt icon-sm me-1_5"></i> Setting Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/billing_setting"><i class="icon-base bx bx-detail icon-sm me-1_5"></i> Billing Plans</a>
                    </li>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="views/assets/modules/img/profile/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="userName" class="form-label">User Name</label>
                                    <input class="form-control" type="text" id="userName" value="<?php echo htmlspecialchars($user['user_name']); ?>" name="userName" autofocus="" placeholder="Enter your username">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">KHR (+885)</span>
                                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($user['phone_number']); ?>" class="form-control" placeholder="Enter your phone number">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" placeholder="Address">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="language" class="form-label">Language</label>
                                    <select id="language" name="language" class="select2 form-select">
                                        <option value="">Select Language</option>
                                        <option value="en" <?php echo $user['language'] == 'en' ? 'selected' : ''; ?>>English</option>
                                        <option value="fr" <?php echo $user['language'] == 'fr' ? 'selected' : ''; ?>>Khmer</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="province">City/Province</label>
                                    <select id="province" name="province" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="Phnom Penh" <?php echo $user['province'] == 'Phnom Penh' ? 'selected' : ''; ?>>Phnom Penh</option>
                                        <option value="Battambang" <?php echo $user['province'] == 'Battambang' ? 'selected' : ''; ?>>Battambang</option>
                                        <option value="Prey Veng" <?php echo $user['province'] == 'Prey Veng' ? 'selected' : ''; ?>>Prey Veng</option>
                                        <option value="Kompot" <?php echo $user['province'] == 'Kompot' ? 'selected' : ''; ?>>Kompot</option>
                                        <option value="Siem Reap" <?php echo $user['province'] == 'Siem Reap' ? 'selected' : ''; ?>>Siem Reap</option>
                                        <option value="Kompong Thom" <?php echo $user['province'] == 'Kompong Thom' ? 'selected' : ''; ?>>Kompong Thom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" onsubmit="return false">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
                                <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>