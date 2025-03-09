<?php
// require 'Database/Database.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//     $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
//     if ($stmt->execute([$name, $email, $password])) {
//         echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
//     } else {
//         echo "<script>alert('Registration failed!');</script>";
//     }
// }
?>


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

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register Card -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center flex-column">
              <a href="#" class="app-brand-link gap-2">
                <img src="views/assets/modules/img/logo/logo.png" alt="" width="100px" height="100px">
              </a>
              <h3>Mak Oun Sing</h3>
              <p>Please sign-up your account before sign-in</p>
            </div>
            <!-- /Logo -->
             
            <form id="formAuthentication" class="mb-3" action="/dashboard" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="username"
                  placeholder="Enter your username"
                  autofocus />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                  <label class="form-check-label" for="terms-conditions">
                    I agree to
                    <a href="javascript:void(0);">privacy policy & terms</a>
                  </label>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">Sign up</button>
          </div>
          </form>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
  </div>

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
</body>

</html>