<div class="container-xxl flex-grow-1 container-p-y">
    <a href="/users/create" class="btn btn-primary mb-3">+ Add New User</a>
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
                                <img src="<?= $user['profile_image'] ?? '/default-profile.png' ?>" class="rounded-circle" width="40" height="40" alt="Profile">
                            </td>
                            <td><?= htmlspecialchars($user['user_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><span class="badge bg-info text-dark"> <?= htmlspecialchars($user['role_name']) ?></span></td>
                            <td><?= htmlspecialchars($user['phone_number']) ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li><a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                        <li>
                                            <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-id="<?= $user['user_id'] ?>" data-user-name="<?= htmlspecialchars($user['user_name']) ?>">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Delete Confirmation Modal -->
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
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('confirmDeleteBtn').href = `/users/delete/${userId}`;
        });
    });
</script>
