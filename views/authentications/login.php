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

  <title>Make Oun Sing- sign in</title>

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
  <link rel="stylesheet" href="/views/assets/modules/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="/views/assets/modules/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/views/assets/modules/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/views/assets/modules/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="/views/assets/modules/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="/views/assets/modules/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="/views/assets/modules/vendor/js/helpers.js"></script>
  <script src="/views/assets/modules/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card ">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center flex-column">
              <a href="#" class="app-brand-link gap-2">
                <img src="/views/assets/modules/img/logo/logo.png" alt="" width="100px" height="100px">
              </a>
              <h3>Mak Oun Sing</h3>
            </div>
            <h4 class="mb-2">Welcome to Mak Oun Sing 👋</h4>
            <form id="formAuthentication" class="mb-3" action="/users/authentication" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email"
                  autofocus />
                <div class="text-danger" id="email-error"></div> <!-- Error message -->
              </div>

              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>

                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="********"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                <div class="text-danger" id="password-error"></div> <!-- Error message -->
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
              <a href="/forgotpassword">
                <small>Forgot Password?</small>
              </a>
            </form>
          </div>
        </div>

        <!-- /Register -->
      </div>
    </div>
  </div>
  <!-- / Content -->
  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="/views/assets/modules/vendor/libs/jquery/jquery.js"></script>
  <script src="/views/assets/modules/vendor/libs/popper/popper.js"></script>
  <script src="/views/assets/modules/vendor/js/bootstrap.js"></script>
  <script src="/views/assets/modules/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="/views/assets/modules/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="/views/assets/modules/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- error of message -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const form = document.getElementById("formAuthentication");
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      const emailError = document.getElementById("email-error");
      const passwordError = document.getElementById("password-error");
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
      loadingText.textContent = " Authenticating...";
      loadingText.style.display = "block";
      loadingText.style.marginTop = "5px";

      loadingContainer.appendChild(spinner);
      loadingContainer.appendChild(loadingText);
      submitButton.parentNode.appendChild(loadingContainer);

      form.addEventListener("submit", function(event) {
        let isValid = true;
        emailError.textContent = "";
        passwordError.textContent = "";

        const emailValue = emailInput.value.trim();
        const passwordValue = passwordInput.value.trim();

        // Email validation using regex
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(emailValue)) {
          emailError.textContent = "Please enter a valid email address.";
          emailInput.classList.add("is-invalid");
          isValid = false;
        } else {
          emailInput.classList.remove("is-invalid");
        }

        // Password validation (minimum 6 characters)
        if (passwordValue.length < 6) {
          passwordError.textContent = "Password must be at least 6 characters long.";
          passwordInput.classList.add("is-invalid");
          isValid = false;
        } else {
          passwordInput.classList.remove("is-invalid");
        }

        if (!isValid) {
          event.preventDefault();
          return;
        }

        // Show loading animation and disable button
        submitButton.disabled = true;
        submitButton.textContent = "Signing in...";
        loadingContainer.style.display = "block";

        // Simulate loading for 1 minute before redirecting to dashboard
        setTimeout(() => {
          window.location.href = "/dashboard"; // Redirect to dashboard
        }, 60000); // 1 minute = 60,000 milliseconds
      });
    });
  </script>

</body>

</html>