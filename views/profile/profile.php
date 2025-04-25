<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit();
}
?>
<!-- /Views/profile/profile.php -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> My Account</h4>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="/profile"><i class="bx bx-user me-1"></i> Account</a>
                </li>
            </ul>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="<?= htmlspecialchars($user['profile_image'] ?? '/assets/uploads/default-profile.png') ?>" 
                             alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="/profile/update" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                        <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['profile_image'] ?? '') ?>">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
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
                                    <span class="input-group-text">KHR (+855)</span>
                                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" 
                                           value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" 
                                           placeholder="0123456789">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>" 
                                       placeholder="john.doe@example.com" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <input class="form-control" type="text" id="role" name="role" 
                                       value="<?= htmlspecialchars($user['role_name'] ?? 'User') ?>" readonly>
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
function displayImage(input) {
    const preview = document.getElementById('uploadedAvatar');
    const file = input.files[0];
    if (file) {
        // Basic client-side validation
        const allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (!allowedTypes.includes(file.type)) {
            alert('Please upload a PNG, JPG, or GIF image.');
            input.value = '';
            return;
        }
        if (file.size > maxSize) {
            alert('Image size must be less than 2MB.');
            input.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function resetImage() {
    const input = document.getElementById('upload');
    const preview = document.getElementById('uploadedAvatar');
    input.value = '';
    preview.src = '/assets/uploads/default-profile.png';
}
</script>