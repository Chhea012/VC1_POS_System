<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<!-- /Views/profile/profile.php -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Admin Account</h4>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
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
            </ul>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="<?= htmlspecialchars($user['profile_image'] ?? '/Views/assets/uploads/default-profile.png') ?>" 
                             class="rounded-circle" width="100" height="100" alt="Profile" id="currentImage">
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
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="/profile/update" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                        <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['profile_image']) ?>">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="userName" class="form-label">User Name</label>
                                <input class="form-control" type="text" id="userName" name="userName" 
                                       value="<?= htmlspecialchars($user['user_name']) ?>" 
                                       placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">KHR (+885)</span>
                                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" 
                                           value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" 
                                           placeholder="Enter your phone number">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>" 
                                       placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <input class="form-control" type="text" id="role" name="role" 
                                       value="<?= htmlspecialchars($user['role_name'] ?? 'Admin') ?>" 
                                       required>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('profileImage').addEventListener('change', function(e) {
        const preview = document.getElementById('currentImage');
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });

    document.querySelector('.account-image-reset').addEventListener('click', function() {
        const preview = document.getElementById('currentImage');
        preview.src = '<?= htmlspecialchars($user['profile_image'] ?? '/Views/assets/uploads/default-profile.png') ?>';
        document.getElementById('profileImage').value = '';
    });
</script>