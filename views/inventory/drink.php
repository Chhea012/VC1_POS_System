<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
require_once "Models/drinkModel.php";
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="mb-3">The Popular Items:</h5>
    <div class="row text-center">
        <?php foreach ($products as $product): ?>
            <?php if (isset($product['price'], $product['quantity']) && ($product['price'] * $product['quantity'] >= 20)): ?>
                <div class="col-md-3">
                    <div class="card p-4 shadow-sm">
                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="w-100" alt="Popular Drink">
                        <div class="mt-2">⭐⭐⭐⭐⭐</div>
                        <p class="mt-2"><?= htmlspecialchars($product['product_name']) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Export Button -->
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h5 class="mt-3 mb-0">Drinks Transactions:</h5>
        <button id="exportButton" class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf me-2"></i>Export to PDF
        </button>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40px">#</th>
                            <th>PRODUCT</th>
                            <th>CATEGORY</th>
                            <th>STOCK</th>
                            <th>PRICE</th>
                            <th>QTY</th>
                            <th>AMOUNT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="text-center row-number"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars('views/products/' . $product['image']) ?>" class="card-img-top w-px-50" alt="Product Image">
                                        <span class="ms-3"><?= htmlspecialchars($product['product_name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">
                                        <i class="bi bi-cup-hot me-1"></i>
                                        <?= htmlspecialchars($product['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="color: <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'red' : 'green' ?>;">
                                        <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'Low stock' : 'High stock' ?>
                                    </span>
                                </td>
                                <td>$<?= isset($product['price']) ? number_format($product['price'], 2) : '0.00' ?></td>
                                <td <?= isset($product['quantity']) && $product['quantity'] < 5 ? 'style="color: red;"' : '' ?>>
                                    <?= isset($product['quantity']) ? $product['quantity'] : 'N/A' ?>
                                </td>
                                <td>
                                    $<?= isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00' ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="/inventory/viewdrink/<?php echo $product['product_id'] ?>">
                                                    <i class="bi bi-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $product['product_id'] ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                                <form id="delete-form-<?= $product['product_id'] ?>" action="/drink/delete/<?= $product['product_id'] ?>" method="POST" style="display:none;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add both jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
const { jsPDF } = window.jspdf;

function confirmDelete(product_id) {
    if (confirm('Are you sure you want to delete this product?')) {
        document.getElementById('delete-form-' + product_id).submit();
    }
}

// Function to load image as base64
function loadImageAsBase64(url, callback) {
    const img = new Image();
    img.crossOrigin = 'Anonymous'; // Handle CORS if needed
    img.onload = function() {
        const canvas = document.createElement('canvas');
        canvas.width = this.width;
        canvas.height = this.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(this, 0, 0);
        const dataURL = canvas.toDataURL('image/png');
        callback(dataURL);
    };
    img.onerror = function() {
        console.error('Failed to load image:', url);
        callback(null);
    };
    img.src = url;
}

// Creative PDF Export functionality
document.getElementById('exportButton').addEventListener('click', function() {
    try {
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });
        const products = <?php echo json_encode($products) ?: '[]'; ?>;
        
        // Validate products array
        if (!Array.isArray(products) || products.length === 0) {
            alert('No products available to export!');
            return;
        }

        // Creative Header
        doc.setFillColor(66, 139, 202); // Blue gradient base
        doc.rect(0, 0, 210, 40, 'F');
        doc.setFillColor(100, 181, 246); // Lighter overlay
        doc.triangle(0, 0, 210, 0, 105, 40, 'F'); // Gradient triangle

        // Load and add the logo from the specified path
        const logoUrl = '/views/assets/modules/img/logo/logo.png'; // Updated path
        loadImageAsBase64(logoUrl, function(base64Image) {
            if (base64Image) {
                try {
                    doc.addImage(base64Image, 'PNG', 15, 5, 30, 30); // Adjust position and size as needed
                } catch (imgError) {
                    console.error('Error adding image to PDF:', imgError);
                    // Fallback: proceed without the image
                }
            } else {
                console.warn('Image could not be loaded. Proceeding without logo.');
            }

            // Add title and other header elements
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(24);
            doc.setFont('helvetica', 'bold');
            doc.text('Mak Oun Sing Shop', 50, 20); // Adjusted position to accommodate logo
            doc.setFontSize(11);
            doc.setFont('helvetica', 'normal');
            doc.text(`Generated: ${new Date().toLocaleString()}`, 50, 30);

            // Decorative elements
            doc.setDrawColor(255, 204, 0); // Yellow line
            doc.setLineWidth(0.5);
            doc.line(15, 35, 195, 35);
            
            // Table headers
            const headers = ['#', 'Product', 'Category', 'Stock', 'Price', 'Qty', 'Amount'];
            let rows = [];
            
            // Prepare data rows
            products.forEach((product, index) => {
                rows.push([
                    index + 1,
                    product.product_name || 'N/A',
                    product.category_name || 'N/A',
                    (product.quantity !== undefined && product.quantity < 5) ? 'Low stock' : 'High stock',
                    '$' + (product.price ? parseFloat(product.price).toFixed(2) : '0.00'),
                    product.quantity !== undefined ? product.quantity : 'N/A',
                    '$' + (product.price && product.quantity !== undefined ? 
                        (product.price * product.quantity).toFixed(2) : '0.00')
                ]);
            });
            
            // Generate creative table
            doc.autoTable({
                startY: 45,
                head: [headers],
                body: rows,
                theme: 'grid',
                styles: {
                    fontSize: 10,
                    cellPadding: 3,
                    textColor: [50, 50, 50],
                    lineColor: [200, 200, 200],
                    lineWidth: 0.1
                },
                headStyles: {
                    fillColor: [66, 139, 202],
                    textColor: [255, 255, 255],
                    fontSize: 11,
                    fontStyle: 'bold'
                },
                alternateRowStyles: {
                    fillColor: [245, 248, 250]
                },
                columnStyles: {
                    0: { cellWidth: 10, halign: 'center' },
                    1: { cellWidth: 50 },
                    2: { cellWidth: 30 },
                    3: { cellWidth: 25, halign: 'center' },
                    4: { cellWidth: 20, halign: 'right' },
                    5: { cellWidth: 15, halign: 'center' },
                    6: { cellWidth: 25, halign: 'right' }
                },
                didParseCell: function(data) {
                    // Color coding for stock status
                    if (data.column.index === 3) {
                        data.cell.styles.textColor = 
                            data.cell.text[0] === 'Low stock' ? [220, 53, 69] : [40, 167, 69];
                        data.cell.styles.fontStyle = 
                            data.cell.text[0] === 'Low stock' ? 'bold' : 'normal';
                    }
                },
                didDrawPage: function(data) {
                    const pageHeight = doc.internal.pageSize.height;
                    const pageWidth = doc.internal.pageSize.width;

                    // Creative Footer
                    doc.setFillColor(240, 248, 255); // Light blue background
                    doc.rect(0, pageHeight - 25, pageWidth, 25, 'F');
                    doc.setFontSize(9);
                    doc.setTextColor(66, 139, 202);
                    doc.text(`Page ${doc.internal.getNumberOfPages()}`, pageWidth - 25, pageHeight - 15);
                    doc.text('© 2025 Drink Management System', 15, pageHeight - 15);

                    // Footer decoration
                    doc.setDrawColor(255, 204, 0);
                    doc.setLineWidth(0.3);
                    doc.circle(195, pageHeight - 20, 3, 'S'); // Small circle decoration
                }
            });

            // Summary Section
            const finalY = doc.lastAutoTable.finalY + 10;
            doc.setFillColor(240, 240, 240);
            doc.rect(15, finalY, 180, 25, 'F');
            doc.setFontSize(14);
            doc.setTextColor(66, 139, 202);
            doc.text('Quick Summary', 20, finalY + 8);
            
            const totalAmount = products.reduce((sum, p) => 
                sum + (p.price * p.quantity || 0), 0);
            const lowStockCount = products.filter(p => p.quantity < 5).length;
            
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);
            doc.text(`Total Inventory Value: $${totalAmount.toFixed(2)}`, 20, finalY + 16);
            doc.text(`Items with Low Stock: ${lowStockCount}`, 20, finalY + 23);
            // Save the PDF
            doc.save(`mak_oun_sing_report_${new Date().toISOString().slice(0,10)}.pdf`);
        });
    } catch (error) {
        console.error('PDF Export Error:', error);
        alert('Error generating PDF: ' + error.message);
    }
});

// Row numbering
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.row-number').forEach((cell, index) => {
        cell.textContent = index + 1;
    });
});
</script>

<!-- Low Stock Alert -->
<?php
$low_stock_items = [];
foreach ($products as $product) {
    if (isset($product['quantity']) && $product['quantity'] < 5) {
        $low_stock_items[] = htmlspecialchars($product['product_name']) . " (" . $product['quantity'] . " units)";
    }
}
?>

<?php if (!empty($low_stock_items)): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="lowStockToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                <strong class="me-auto">Low Stock Alert</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <ul class="list-unstyled mb-0">
                    <?php foreach ($low_stock_items as $item): ?>
                        <li><?php echo $item; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lowStockToast = new bootstrap.Toast(document.getElementById('lowStockToast'), {
                delay: 5000
            });
            lowStockToast.show();
        });
    </script>
<?php endif; ?>