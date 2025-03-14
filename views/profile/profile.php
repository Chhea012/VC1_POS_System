<?php
$user = $data['user'] ?? null;
$error = $data['error'] ?? null;
$success = $_GET['success'] ?? null;

if (!$user) {
    echo "No user data available.";
    return;
}
?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Admin Account</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/setting_security"><i class="bx bx-lock-alt me-1"></i> Setting Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/billing_setting"><i class="bx bx-detail me-1"></i> Billing Plans</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">Admin Profile Details</h5>
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'views/assets/modules/img/1.jpg'; ?>" 
                                     alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                                <div class="button-wrapper">
                                    <label for="profileImage" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="profileImage" name="profileImage" class="account-file-input" hidden accept="image/png, image/jpeg, image/gif">
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <p class="text-muted mb-0">Allowed JPG, JPEG, PNG, GIF. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" action="/profile/update" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="userName" class="form-label">User Name</label>
                                        <input class="form-control" type="text" id="userName" name="userName" 
                                               value="<?php echo htmlspecialchars($user['user_name']); ?>" 
                                               placeholder="Enter your username" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="phoneNumber" class="form-label">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">KHR (+885)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" 
                                                   value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>" 
                                                   placeholder="Enter your phone number">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" 
                                               value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" 
                                               placeholder="Address">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="province" class="form-label">City/Province</label>
                                        <input type="text" class="form-control" id="province" name="province" 
                                               value="<?php echo htmlspecialchars($user['city_province'] ?? ''); ?>" 
                                               placeholder="Province">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control" type="email" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($user['email']); ?>" 
                                               placeholder="Enter your email" required>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
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
                            <form id="formAccountDeactivation" method="POST" action="/profile/deletex">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" required>
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
 