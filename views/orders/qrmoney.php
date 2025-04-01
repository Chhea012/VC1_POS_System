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
    <div class="container text-center d-flex flex-column justify-content-center align-items-center">
        <img src="/views/assets/modules/img/logo/logo.png" alt="Logo" class="img-fluid mb-3" style="max-width: 120px;">
        <h3 class="text-dark fw-bold mb-3">SELECT PAYMENT METHOD</h3>
        
        <!-- Payment Method Selection -->
        <select class="form-select mb-3" id="paymentMethod" style="max-width: 300px;">
            <option value="qr" selected>QR $</option>
            <option value="realkhmer">QR ៛</option>
        </select>

        <!-- QR Code Container (shown by default) -->
        <div id="qrContainer" class="bg-light">
            <img src="/views/assets/modules/img/qr/dollar.png" alt="QR Code" class="img-fluid" style="max-width: 300px;">
        </div>

        <!-- Money Realkhmer Container (hidden by default) -->
        <div id="realkhmerContainer" class="bg-light d-none">
        <img src="/views/assets/modules/img/qr/khmer.png" alt="QR Code" class="img-fluid" style="max-width: 300px;">
        </div>

        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="javascript:history.back()" class="btn btn-outline-secondary">CANCEL</a>
            <a href="/orders" class="btn btn-warning">ACCEPTED</a>
        </div>
    </div>
</div>

<!-- Simple JavaScript to toggle between payment methods -->
<script>
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const qrContainer = document.getElementById('qrContainer');
        const realkhmerContainer = document.getElementById('realkhmerContainer');
        
        if (this.value === 'qr') {
            qrContainer.classList.remove('d-none');
            realkhmerContainer.classList.add('d-none');
        } else {
            qrContainer.classList.add('d-none');
            realkhmerContainer.classList.remove('d-none');
        }
    });
</script>