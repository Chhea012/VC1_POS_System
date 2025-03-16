

<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="views/assets/modules/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Mak Oun Sing - register</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="views/assets/modules/img/logo/logo.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="views/assets/modules/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="views/assets/modules/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="views/assets/modules/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="views/assets/modules/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="views/assets/modules/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="views/assets/modules/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="views/assets/modules/vendor/js/helpers.js"></script>
  <script src="views/assets/modules/js/config.js"></script>
</head>

<body>
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="container mt-4 mb-4">
        <h2>Register</h2>
        <form action="/users/store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="user_name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Select a role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['role_id'] ?>"><?= htmlspecialchars($role['role_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                <div class="mt-2">
                    <img id="image_preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
                </div>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="city_province" class="form-label">City/Province</label>
                <textarea class="form-control" id="city_province" name="city_province" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="/" class="btn btn-secondary">Cancel</a>
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

  <!-- / Content -->
  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="views/assets/modules/vendor/libs/jquery/jquery.js"></script>
  <script src="views/assets/modules/vendor/libs/popper/popper.js"></script>
  <script src="views/assets/modules/vendor/js/bootstrap.js"></script>
  <script src="views/assets/modules/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="views/assets/modules/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="views/assets/modules/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Error message validation -->
  <script>
  document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("formAuthentication");
      const usernameInput = document.getElementById("username");
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      const usernameError = document.getElementById("username-error");
      const emailError = document.getElementById("email-error");
      const passwordError = document.getElementById("password-error");

      form.addEventListener("submit", function (event) {
          let isValid = true;
          
          // Clear previous error messages
          emailError.textContent = "";
          passwordError.textContent = "";
          usernameError.textContent = "";

          // Validate Username
          if (usernameInput.value.length < 6) {
              usernameError.textContent = "Username must be more than 6 characters";
              usernameInput.classList.add("is-invalid");
              isValid = false;
          } else {
              usernameInput.classList.remove("is-invalid");
          }

          // Validate Email
          if (!emailInput.value.includes("@") || emailInput.value.length < 6) {
              emailError.textContent = "Please enter a valid email address";
              emailInput.classList.add("is-invalid");
              isValid = false;
          } else {
              emailInput.classList.remove("is-invalid");
          }

          // Validate Password
          if (passwordInput.value.length < 6) {
              passwordError.textContent = "Password must be more than 6 characters";
              passwordInput.classList.add("is-invalid");
              isValid = false;
          } else {
              passwordInput.classList.remove("is-invalid");
          }

          // Prevent form submission if validation fails
          if (!isValid) {
              event.preventDefault();
          }
      });
  });
  </script>

</body>

</html>