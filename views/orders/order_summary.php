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
    <div class="summary-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="header-title">Order Summary</h2>
        </div>
        <div class="container py-5 ">
            <!-- Company Info -->
            <div class="company-info">
                <img src="/views/assets/modules/img/logo/logo.png" alt="Company Logo" width="100px">
                <h4 class="mb-1">Mak Oun Sing</h4>
                <p class="mb-0 text-muted">BP 511, Phum Tropeang Chhuk (Borey Sorla) Sangtak, Street 371, Phnom Penh</p>
            </div>

            <!-- Customer and Invoice Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="text-primary mb-3"><i class="bi bi-receipt me-2"></i>Invoice Details</h5>
                        <p class="mb-1"><strong>Invoice No:</strong> INV-4407051</p>
                        <p class="mb-1"><strong>Invoice Date:</strong> <?php echo date('d M Y', strtotime($order_date)); ?></p>
                    </div>
                </div>
            </div>

            <!-- Order Table -->
            <div class="table-responsive">
                <table class="table table-custom table-bordered">
                    <thead>
                        <tr>
                            <th style="color: white;">ID</th>
                            <th style="color: white;">Product Name</th>
                            <th style="color: white;">Price</th>
                            <th style="color: white;">Quantity</th>
                            <th style="color: white;">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grandTotal = 0;
                        foreach ($orderItems as $index => $item) {
                            $totalPrice = $item['price'] * $item['quantity'];
                            $grandTotal += $totalPrice;
                            echo "<tr>
                                <td>" . ($index + 1) . "</td>
                                <td>" . htmlspecialchars($item['product_name']) . "</td>
                                <td>" . number_format($item['price'], 2) . "</td>
                                <td>" . $item['quantity'] . "</td>
                                <td>" . number_format($totalPrice, 2) . "</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Grand Total and Payment Mode -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5 id="grand-total"><strong>Grand Total:</strong> <?php echo number_format($grandTotal, 2); ?></h5>
                <p class="mb-0"><strong>Payment Mode:</strong> <?php echo htmlspecialchars($payment_mode); ?></p>
            </div>
        </div>
    </div>
    <!-- Action Buttons -->
    <div class="d-flex justify-content-end gap-3 mt-4">
        <a href="javascript:history.back()" class="btn btn btn-outline-secondary">CANCEL</a>
        <button type="button" id="print-btn" class="btn btn-primary">
            <i class="bi bi-printer-fill me-2"></i> Print Receipt
        </button>
        <a href="/orders/create/QR" class="btn btn-primary" onclick="return placeOrder()">Pay Money</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    generateReceipt();
});
function generateReceipt(){
    document.getElementById('print-btn').addEventListener('click', function () {
    // Extract shop logo
    const logoSrc = document.querySelector('.company-info img').src;

    // Extract shop name & address
    const shopName = document.querySelector('.company-info h4').innerText;
    const shopAddress = document.querySelector('.company-info p').innerText;

    const now = new Date();
    const formattedDate = now.toLocaleDateString();
    const formattedTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

    // Extract order details
    const orderRows = document.querySelectorAll('.table tbody tr');
    let receiptItems = '';
    let grandTotal = 0;

    orderRows.forEach(row => {
        const columns = row.querySelectorAll('td');
        const productName = columns[1].innerText;  // Extract Product Name
        const quantity = columns[3].innerText;  // Extract Quantity
        const price = parseFloat(columns[2].innerText.replace(',', ''));  // Extract Price
        const totalPrice = parseFloat(columns[4].innerText.replace(',', ''));  // Extract Total Price

        grandTotal += totalPrice;

        receiptItems += `
            <div class="receipt-item">
                <div>${quantity}x ${productName}</div>
                <div>$ ${totalPrice.toFixed(2)}</div>
            </div>
        `;
    });

    const paymentMode = document.querySelector('.d-flex.justify-content-between p strong').nextSibling.nodeValue.trim();

    // Open a new window for printing
    const printWindow = window.open('width=800,height=600');
    
    printWindow.document.open();
    printWindow.document.write(`
        <html>
        <head>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                .receipt {
                    font-family: monospace;
                    width: 100%;
                    background-color: white;
                }
                .receipt-header {
                    text-align: center;
                    font-size: 20px;
                    font-weight: bold;
                    margin: 10px 0;
                }
                .receipt-divider {
                    border-top: 1px dashed #000;
                    margin: 10px 0;
                }
                .receipt-item {
                    display: flex;
                    justify-content: space-between;
                    margin: 5px 0;
                }
                .receipt-total {
                    font-weight: bold;
                    margin: 10px 0;
                    display: flex;
                    justify-content: space-between;
                }
                .receipt-payment {
                    display: flex;
                    justify-content: space-between;
                    margin: 5px 0;
                }
                .receipt-thank-you {
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                    margin: 20px 0;
                }
                .receipt-logo {
                    text-align: center;
                    margin-bottom: 10px;
                }
                .receipt-logo img {
                    width: 80px;
                }
                .receipt-date {
                    text-align: center;
                    font-size: 14px;
                    margin-bottom: 10px;
                }
                .receipt-barcode {
                margin: 20px 0;
                text-align: center;
                }
            </style>
        </head>
        <body>
            <div id="receipt" class="receipt">
                <div class="receipt-logo">
                    <img src="${logoSrc}" alt="Shop Logo">
                </div>
                <div class="receipt-header">${shopName}</div>
                <div class="receipt-date">${shopAddress}</div>
                <div class="receipt-date">Date: ${formattedDate} | Time: ${formattedTime}</div>
                <div class="receipt-divider"></div>

                <!-- Receipt Items -->
                <div id="receipt-items">
                    ${receiptItems}
                </div>

                <div class="receipt-divider"></div>

                <!-- Total Amount -->
                <div class="receipt-total">
                    <div>TOTAL AMOUNT</div>
                    <div>$ ${grandTotal.toFixed(2)}</div>
                </div>

                <div class="receipt-divider"></div>

                <!-- Payment Information -->
                <div class="receipt-payment">
                    <div>PAYMENT MODE</div>
                    <div>${paymentMode}</div>
                </div>

                <div class="receipt-divider"></div>

                <!-- Thank You Note -->
                <div class="receipt-thank-you">THANK YOU</div>
                <div class="receipt-divider"></div>
                <div class="receipt-barcode">
                    <svg id="barcode" width="200" height="80" viewBox="0 0 200 80"><rect x="0" y="0" width="3" height="80" fill="black"></rect><rect x="5" y="0" width="2" height="80" fill="black"></rect><rect x="10" y="0" width="2" height="80" fill="black"></rect><rect x="15" y="0" width="2" height="80" fill="black"></rect><rect x="20" y="0" width="3" height="80" fill="black"></rect><rect x="25" y="0" width="2" height="80" fill="black"></rect><rect x="30" y="0" width="3" height="80" fill="black"></rect><rect x="35" y="0" width="3" height="80" fill="black"></rect><rect x="40" y="0" width="2" height="80" fill="black"></rect><rect x="45" y="0" width="2" height="80" fill="black"></rect><rect x="50" y="0" width="2" height="80" fill="black"></rect><rect x="55" y="0" width="3" height="80" fill="black"></rect><rect x="60" y="0" width="2" height="80" fill="black"></rect><rect x="65" y="0" width="2" height="80" fill="black"></rect><rect x="70" y="0" width="3" height="80" fill="black"></rect><rect x="75" y="0" width="2" height="80" fill="black"></rect><rect x="80" y="0" width="2" height="80" fill="black"></rect><rect x="85" y="0" width="3" height="80" fill="black"></rect><rect x="90" y="0" width="3" height="80" fill="black"></rect><rect x="95" y="0" width="3" height="80" fill="black"></rect><rect x="100" y="0" width="2" height="80" fill="black"></rect><rect x="105" y="0" width="2" height="80" fill="black"></rect><rect x="110" y="0" width="3" height="80" fill="black"></rect><rect x="115" y="0" width="3" height="80" fill="black"></rect><rect x="120" y="0" width="2" height="80" fill="black"></rect><rect x="125" y="0" width="2" height="80" fill="black"></rect><rect x="130" y="0" width="3" height="80" fill="black"></rect><rect x="135" y="0" width="2" height="80" fill="black"></rect><rect x="140" y="0" width="2" height="80" fill="black"></rect><rect x="145" y="0" width="3" height="80" fill="black"></rect><rect x="150" y="0" width="2" height="80" fill="black"></rect><rect x="155" y="0" width="3" height="80" fill="black"></rect><rect x="160" y="0" width="2" height="80" fill="black"></rect><rect x="165" y="0" width="3" height="80" fill="black"></rect><rect x="170" y="0" width="2" height="80" fill="black"></rect><rect x="175" y="0" width="2" height="80" fill="black"></rect><rect x="180" y="0" width="2" height="80" fill="black"></rect><rect x="185" y="0" width="3" height="80" fill="black"></rect><rect x="190" y="0" width="2" height="80" fill="black"></rect><rect x="195" y="0" width="2" height="80" fill="black"></rect></svg>
                </div>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();

    // Trigger the print function in the new window
    printWindow.onload = function() {
    printWindow.print();
    printWindow.onafterprint = function() {
        window.location.href = "/orders"; // Redirect to the orders page after printing
    };
};

});

}
</script>
