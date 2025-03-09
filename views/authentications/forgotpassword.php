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

    <title>Mak Oun Sing - Forgot Password </title>

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
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Forgot Password -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center flex-column">
                        <a href="#" class="app-brand-link gap-2">
                            <img src="views/assets/modules/img/logo/logo.png" alt="" width="100px" height="100px">
                        </a>
                        <h3>Mak Oun Sing</h3>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1">Forgot Password? 🔒</h4>
                    <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>
                    <form id="formAuthentication" class="mb-6 fv-plugins-bootstrap5 fv-plugins-framework" action="/" method="GET" novalidate="novalidate">
                        <div class="mb-6 form-control-validation fv-plugins-icon-container">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus="">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                        <button class="btn btn-primary d-grid w-100 mt-4">Send Reset Link</button>
                        <input type="hidden">
                    </form>
                    <div class="text-center p-4">
                        <a href="/" class="d-flex justify-content-center">
                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl me-1"></i>
                            Back to login
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
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