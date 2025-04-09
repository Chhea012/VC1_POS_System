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
                    <th style="color: white;">Profile</th>
                    <th style="color: white;">User Name</th>
                    <th style="color: white;">Email</th>
                    <th style="color: white;">Role</th>
                    <th style="color: white;">Phone</th>
                    <th style="color: white;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="bg-light">
                            <td class="text-center" data-label="Profile">
                                <img src="<?= htmlspecialchars($user['profile_image'] ?? '/Views/assets/uploads/default-profile.png') ?>" class="rounded-circle" width="40" height="40" alt="Profile">
                            </td>
                            <td data-label="User Name"><?= htmlspecialchars($user['user_name']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
                            <td data-label="Role"><span class="badge bg-info text-dark"><?= htmlspecialchars($user['role_name']) ?></span></td>
                            <td data-label="Phone"><?= htmlspecialchars($user['phone_number'] ?? 'N/A') ?></td>
                            <td data-label="Actions">
                                <div class="dropdown text-end">
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
                            <label for="create_profile_image" class="form-label">Profile Image</label>
                            <!-- Edit Modal Image Upload Box (similar structure to create) -->
                            <div class="border rounded-2xl p-4 d-flex align-items-center justify-content-center" style="cursor: pointer; border: 2px dashed #6c757d; text-align: center;">
                                <input type="file" id="edit_profile_image" name="profile_image" accept="image/*" class="d-none">
                                <div id="edit-upload-placeholder" class="text-muted">
                                    <i class="bx bx-upload" style="font-size: 3rem;"></i>
                                    <p>Click or drag an image to upload</p>
                                </div>
                                <img id="edit_image_preview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;" class="rounded">
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

imageUploadBox.addEventListener('click', () => imageInput.click());
imageUploadBox.addEventListener('dragover', (e) => {
    e.preventDefault();
    imageUploadBox.style.borderColor = '#0d6efd';
});
imageUploadBox.addEventListener('dragleave', () => {
    imageUploadBox.style.borderColor = '#6c757d';
});
imageUploadBox.addEventListener('drop', (e) => {
    e.preventDefault();
    imageUploadBox.style.borderColor = '#6c757d';
    if (e.dataTransfer.files.length) {
        imageInput.files = e.dataTransfer.files;
        previewImage({ target: imageInput });
    }
});
// Preview image function
function previewImage(event) {
    const file = event.target.files[0];
    if (file && file.type.match('image.*')) {
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
if (editModal) {
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        const email = button.getAttribute('data-email');
        const roleId = button.getAttribute('data-role-id');
        const phoneNumber = button.getAttribute('data-phone-number');
        const profileImage = button.getAttribute('data-profile-image');

        // Set form values
        document.getElementById('edit_user_id').value = userId;
        document.getElementById('edit_user_name').value = userName;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role_id').value = roleId;
        document.getElementById('edit_phone_number').value = phoneNumber || '';

        // Handle image preview
        const editPreview = document.getElementById('edit_image_preview');
        const editPlaceholder = document.getElementById('edit-upload-placeholder');
        const editUploadBox = editPreview.closest('.border'); // Get the parent upload box

        // Reset file input
        document.getElementById('edit_profile_image').value = '';
        
        if (profileImage && profileImage !== 'null') {
            editPreview.src = profileImage;
            editPreview.style.display = 'block';
            if (editPlaceholder) editPlaceholder.style.display = 'none';
        } else {
            editPreview.style.display = 'none';
            if (editPlaceholder) editPlaceholder.style.display = 'block';
        }

        // Add click handler for edit modal's upload box
        if (editUploadBox) {
            editUploadBox.addEventListener('click', () => {
                document.getElementById('edit_profile_image').click();
            });
        }
    });

    // Edit Image Preview Handler
    document.getElementById('edit_profile_image').addEventListener('change', function(e) {
        const preview = document.getElementById('edit_image_preview');
        const placeholder = document.getElementById('edit-upload-placeholder');
        const file = e.target.files[0];
        
        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            // If no file selected or invalid file type, check if there's an existing image
            const button = document.querySelector('[data-bs-toggle="modal"][data-user-id="' + document.getElementById('edit_user_id').value + '"]');
            const existingImage = button ? button.getAttribute('data-profile-image') : null;
            
            if (existingImage && existingImage !== 'null') {
                preview.src = existingImage;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            } else {
                preview.style.display = 'none';
                if (placeholder) placeholder.style.display = 'block';
            }
        }
    });
}
    });
</script>
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
        border-color: #343a40;
    }

    .table tbody tr {
        background-color: #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: #e9ecef;
    }

    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .dropdown-toggle {
        padding: 0.5rem;
    }

    .dropdown-menu {
        min-width: 120px;
        font-size: 0.875rem;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
    }

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
        padding: 1rem;
    }

    #image-upload-box, .border.rounded-2xl {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px dashed #6c757d;
        cursor: pointer;
        text-align: center;
        background: #f8f9fa;
    }

    #image-upload-box img, #edit_image_preview, #create_image_preview {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        display: none;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .table-responsive {
            overflow-x: auto;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-toggle {
            padding: 0.6rem;
        }

        #image-upload-box, .border.rounded-2xl {
            padding: 0.8rem;
            gap: 0.8rem;
        }

        #image-upload-box img, #edit_image_preview, #create_image_preview {
            max-height: 120px;
        }

        .modal-right .modal-dialog {
            max-width: 350px;
        }
    }

    @media (max-width: 768px) {
        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-top: 1px solid #dee2e6;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #495057;
            margin-right: 0.5rem;
            min-width: 100px;
            flex-shrink: 0;
        }

        .btn, .dropdown-toggle, .dropdown-item {
            min-width: 80px;
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
        }

        .modal-right .modal-dialog {
            max-width: 100%;
            width: 100%;
        }

        .modal-content {
            height: auto;
            border-radius: 0.5rem;
            padding: 0.8rem;
        }

        #image-upload-box, .border.rounded-2xl {
            padding: 1rem;
            min-height: 150px;
        }

        #image-upload-box i, #edit-upload-placeholder i {
            font-size: 2rem;
        }

        #image-upload-box p, #edit-upload-placeholder p {
            font-size: 0.8rem;
        }

        .form-label, .form-control, .form-select {
            font-size: 1rem;
        }

        .alert {
            padding: 0.6rem;
            font-size: 0.875rem;
        }
        .table td{
        font-size: 0.8rem;
    }
}
@media (max-width: 480px) {
    .table tbody tr {
        margin-bottom: 0.8rem;
        border-radius: 0.4rem;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        padding: 0.5rem; 
    }

    .table tbody td {
        padding: 0.7rem;
        flex-direction: column;
        align-items: flex-start; 
    }

    .table td::before {
        min-width: 80px;
        font-size: 0.8rem;
        margin-bottom: 0.2rem; 
        display: block; 
    }

    .table td img {
        max-width: 50px;
        max-height: 50px;
        margin-bottom: 0.5rem; 
    }

    .badge {
        display: block; 
        margin-top: 0.2rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem; 
    }

    .btn, .dropdown-toggle, .dropdown-item {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
        min-width: 60px;
    }

    .dropdown-menu {
        min-width: 100px;
        font-size: 0.75rem;
    }

    #image-upload-box, .border.rounded-2xl {
        padding: 0.6rem;
        min-height: 120px;
        gap: 0.6rem;
    }

    #image-upload-box i, #edit-upload-placeholder i {
        font-size: 1.5rem;
    }

    #image-upload-box p, #edit-upload-placeholder p {
        font-size: 0.7rem;
    }

    .form-label {
        font-size: 0.8rem;
    }

    .form-control, .form-select {
        font-size: 0.8rem;
        padding: 0.4rem;
    }

    .alert {
        padding: 0.5rem;
        font-size: 0.75rem;
    }
    .table td[data-label="Email"] {
            font-size: 0.80rem; 
    }
    .table td{
        font-size: 0.8rem;
    }
}
</style>