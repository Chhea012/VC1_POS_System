<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="container text-center d-flex justify-content-center align-items-center">
        <img src="/views/assets/modules/img/logo/logo.png" alt="Logo" class="img-fluid mb-3" style="max-width: 120px;">
        <h3 class="text-dark fw-bold mb-0">SCAN THE QR CODE</h3>
        <div class="bg-light">
            <img src="/views/assets/modules/img/qr/QRcode.png" alt="QR Code" class="img-fluid " style="max-width: 300px;">
        </div>
        <div class="d-flex justify-content-center gap-2">
            <a href="javascript:history.back()" class="btn btn-outline-secondary">CANCEL</a>
            <a href="javascript:history.back()" class="btn btn-warning">ACCEPTED</a>
        </div>
    </div>
</div>
