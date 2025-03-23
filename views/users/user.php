<?php
// /Views/users/user.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

// Fallback for $roles and $users if not set
$users = $users ?? [];
$roles = $roles ?? [];
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Create User Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">+ Add User</button>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-striped border rounded shadow-sm">
            <thead class="table-dark text-light">
                <tr>
                    <th>Profile</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="bg-light">
                            <td class="text-center">
                                <img src="<?= htmlspecialchars($user['profile_image'] ?? '/Views/assets/uploads/default-profile.png') ?>" class="rounded-circle" width="40" height="40" alt="Profile">
                            </td>
                            <td><?= htmlspecialchars($user['user_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($user['role_name']) ?></span></td>
                            <td><?= htmlspecialchars($user['phone_number'] ?? 'N/A') ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                data-user-id="<?= $user['user_id'] ?>"
                                                data-user-name="<?= htmlspecialchars($user['user_name']) ?>"
                                                data-email="<?= htmlspecialchars($user['email']) ?>"
                                                data-role-id="<?= $user['role_id'] ?>"
                                                data-phone-number="<?= htmlspecialchars($user['phone_number'] ?? '') ?>"
                                                data-profile-image="<?= htmlspecialchars($user['profile_image'] ?? '') ?>">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </button>
                                        </li>
                                        <?php if (strtolower($user['role_name']) !== 'admin'): ?>
                                            <li>
                                                <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                    data-user-id="<?= $user['user_id'] ?>" 
                                                    data-user-name="<?= htmlspecialchars($user['user_name']) ?>">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3">Are you sure you want to delete <strong id="deleteUserName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Sidebar Modal -->
    <div class="modal modal-right fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (empty($roles)): ?>
                        <div class="alert alert-warning">No roles available. Please add roles first.</div>
                    <?php endif; ?>
                    <form action="/users/store" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="create_user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="create_user_name" name="user_name" value="<?= htmlspecialchars($_POST['user_name'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="create_email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="create_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_role_id" class="form-label">Role</label>
                            <select class="form-select" id="create_role_id" name="role_id" required>
                                <option value="">Select a role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= htmlspecialchars($role['role_id']) ?>" <?= (isset($_POST['role_id']) && $_POST['role_id'] == $role['role_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role['role_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="create_phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="create_phone_number" name="phone_number" value="<?= htmlspecialchars($_POST['phone_number'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="create_profile_image" class="form-label">Profile Image</label>
                            <div id="image-upload-box" class="border rounded-2xl p-4 d-flex align-items-center justify-content-center" style="cursor: pointer; border: 2px dashed #6c757d; text-align: center;">
                                <input type="file" id="create_profile_image" name="profile_image" accept="image/*" class="d-none" onchange="previewImage(event)">
                                <div id="upload-placeholder" class="text-muted">
                                    <i class="bx bx-upload" style="font-size: 3rem;"></i>
                                    <p>Click or drag an image to upload</p>
                                </div>
                                <img id="create_image_preview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;" class="rounded">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create User</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Sidebar Modal -->
    <div class="modal modal-right fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/users/update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div class="mb-3">
                            <label for="edit_user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="edit_user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_role_id" class="form-label">Role</label>
                            <select class="form-select" id="edit_role_id" name="role_id" required>
                                <option value="">Select a role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= htmlspecialchars($role['role_id']) ?>">
                                        <?= htmlspecialchars($role['role_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="edit_phone_number" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="edit_profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="edit_profile_image" name="profile_image" accept="image/*">
                            <div class="mt-2">
                                <img id="edit_image_preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;" class="rounded">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .modal-right .modal-dialog {
        position: fixed;
        right: 0;
        top: 0;
        height: 100%;
        margin: 0;
        max-width: 400px;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }

    .modal-right.show .modal-dialog {
        transform: translateX(0);
    }

    .modal-content {
        height: 100%;
        border-radius: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Modal Handler
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('confirmDeleteBtn').href = `/users/delete/${userId}`;
        });

        // Create Image Preview Handler
        const imageUploadBox = document.getElementById('image-upload-box');
        const imageInput = document.getElementById('create_profile_image');
        const imagePreview = document.getElementById('create_image_preview');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        imageUploadBox.addEventListener('click', () => imageInput.click());

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }

        imageInput.addEventListener('change', previewImage);

        // Edit Modal Handler
        const editModal = document.getElementById('editUserModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const email = button.getAttribute('data-email');
            const roleId = button.getAttribute('data-role-id');
            const phoneNumber = button.getAttribute('data-phone-number');
            const profileImage = button.getAttribute('data-profile-image');

            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_user_name').value = userName;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role_id').value = roleId;
            document.getElementById('edit_phone_number').value = phoneNumber || '';

            const editPreview = document.getElementById('edit_image_preview');
            if (profileImage) {
                editPreview.src = profileImage;
                editPreview.style.display = 'block';
            } else {
                editPreview.style.display = 'none';
            }
        });

        // Edit Image Preview Handler
        document.getElementById('edit_profile_image').addEventListener('change', function(e) {
            const preview = document.getElementById('edit_image_preview');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    });
</script>