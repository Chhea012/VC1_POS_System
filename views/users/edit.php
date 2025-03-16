<div class="container-xxl flex-grow-1 container-p-y">
    <div class="container mt-4 mb-4">
        <h2>Edit User</h2>
        <form action="/users/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['profile_image']) ?>">
            <div class="mb-3">
                <label for="user_name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?= htmlspecialchars($user['user_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (leave blank to keep current)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Select a role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['role_id'] ?>" <?= $role['role_id'] == $user['role_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($role['role_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                <?php if (!empty($user['profile_image'])): ?>
                    <div class="mt-2">
                        <img src="/images/<?= htmlspecialchars($user['profile_image']) ?>" alt="Current Image" style="max-width: 200px; height: auto;" onerror="this.src='/images/default.jpg';">
                    </div>
                <?php endif; ?>
                <div class="mt-2">
                    <img id="image_preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
                </div>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?= htmlspecialchars($user['address']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="city_province" class="form-label">City/Province</label>
                <textarea class="form-control" id="city_province" name="city_province" rows="3"><?= htmlspecialchars($user['city_province']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="/users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const preview = document.getElementById('image_preview');
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>