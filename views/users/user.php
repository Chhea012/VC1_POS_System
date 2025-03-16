<div class="container-xxl flex-grow-1 container-p-y">
    <a href="/users/create" class="btn btn-primary">+ Add New User</a>
        <div class="d-flex justify-content-between align-items-center mb-3">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>User Name</th>
                        <th>Profile Image</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City/Province</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['user_name']) ?></td>
                                <td>
                                    <!-- <?php if (!empty($user['profile_image'])): ?>
                                        <img src="/images/<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile Image" style="max-width: 100px; height: auto;" onerror="this.src='/images/default.jpg';">
                                    <?php else: ?>
                                        <img src="/images/default.jpg" alt="No Image" style="max-width: 100px; height: auto;">
                                    <?php endif; ?> -->
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role_name']) ?></td>
                                <td><?= htmlspecialchars($user['phone_number']) ?></td>
                                <td><?= htmlspecialchars($user['address']) ?></td>
                                <td><?= htmlspecialchars($user['city_province']) ?></td>
                                <td>
                                    <a href="/users/edit/<?= $user['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-id="<?= $user['user_id'] ?>" data-user-name="<?= htmlspecialchars($user['user_name']) ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3">Are you sure you want to delete <strong id="deleteUserName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons (optional for the warning icon) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<script>
    // JavaScript to dynamically set the user name and delete URL in the modal
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            
            const userNameElement = deleteModal.querySelector('#deleteUserName');
            const confirmDeleteBtn = deleteModal.querySelector('#confirmDeleteBtn');
            
            userNameElement.textContent = userName;
            confirmDeleteBtn.href = `/users/delete/${userId}`;
        });
    });
</script>