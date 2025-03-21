<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="/views/assets/modules/img/logo/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/views/assets/modules/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/views/assets/modules/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/views/assets/modules/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/views/assets/modules/css/demo.css" />
    <link rel="stylesheet" href="/views/assets/modules/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/views/assets/modules/vendor/css/pages/page-auth.css" />
    <script src="/views/assets/modules/vendor/js/helpers.js"></script>
    <script src="/views/assets/modules/js/config.js"></script>
</head>

<body style="background-color: #f8f9fa; overflow-x: hidden;">
    <div class="row justify-content-center mt-3">
        <div class="col-lg-4">
            <div class="p-4 rounded-3 shadow-sm" style="background-color: #fff;">
                <div class="text-center p-3">
                    <img src="/views/assets/modules/img/logo/logo.png" alt="Mak Oun Sing Logo" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;" />
                    <h1 class="mt-1 mb-1 fw-bold" style="font-size: 1.4rem;">Mak Oun Sing</h1>
                    <p class="text-muted" style="font-size: 0.9rem;">Please sign up for your account</p>
                    <?php if (isset($error)): ?>
                        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                </div>
                <div class="p-3">
                    <form id="formAuthentication" class="mb-3" action="/register/store" method="POST" enctype="multipart/form-data">
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
                                    <option value="<?= htmlspecialchars($role['role_id']) ?>"><?= htmlspecialchars($role['role_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                            <div class="mt-2">
                                <img id="image_preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/views/assets/modules/vendor/libs/jquery/jquery.js"></script>
    <script src="/views/assets/modules/vendor/libs/popper/popper.js"></script>
    <script src="/views/assets/modules/vendor/js/bootstrap.js"></script>
    <script src="/views/assets/modules/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/views/assets/modules/vendor/js/menu.js"></script>
    <script src="/views/assets/modules/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("formAuthentication");
            const userNameInput = document.getElementById("user_name");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const roleInput = document.getElementById("role_id");
            const submitButton = form.querySelector("button[type='submit']");

            // Create a loading spinner element
            const loadingContainer = document.createElement("div");
            loadingContainer.style.display = "none";
            loadingContainer.style.textAlign = "center";
            loadingContainer.style.marginTop = "10px";

            const spinner = document.createElement("div");
            spinner.classList.add("spinner-border", "text-primary");
            spinner.setAttribute("role", "status");

            const loadingText = document.createElement("span");
            loadingText.textContent = " Registering...";
            loadingText.style.display = "block";
            loadingText.style.marginTop = "5px";

            loadingContainer.appendChild(spinner);
            loadingContainer.appendChild(loadingText);
            submitButton.parentNode.appendChild(loadingContainer);

            form.addEventListener("submit", function(event) {
                let isValid = true;

                const emailValue = emailInput.value.trim();
                const passwordValue = passwordInput.value.trim();
                const userNameValue = userNameInput.value.trim();
                const roleValue = roleInput.value.trim();

                // Email validation using regex
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!userNameValue) {
                    isValid = false;
                }
                if (!emailPattern.test(emailValue)) {
                    isValid = false;
                }
                if (passwordValue.length < 8) {
                    isValid = false;
                }
                if (!roleValue) {
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                    return;
                }

                // Show loading animation and disable button
                submitButton.disabled = true;
                submitButton.textContent = "Signing up...";
                loadingContainer.style.display = "block";

                // Simulate loading for 5 seconds before redirecting to dashboard
                setTimeout(() => {
                    window.location.href = "/dashboard"; // Redirect to dashboard
                }, 200);
            });
        });
    </script>
</body>

</html>