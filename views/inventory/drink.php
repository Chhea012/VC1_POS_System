<?php
// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Authentication check
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

// Include model
require_once "Models/drinkModel.php";

// Ensure $products is defined
$products = $products ?? [];
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Popular Items Section -->
    <h5 class="mb-3">Popular Items:</h5>
    <div class="row text-center">
        <?php 
        $popular_products = array_filter($products, function($product) {
            return isset($product['price'], $product['quantity']) && 
                   ($product['price'] * $product['quantity'] >= 20);
        });
        
        if (empty($popular_products)) {
            echo "<p class='text-center text-muted'>No popular items yet.</p>";
        } else {
            foreach ($popular_products as $product) {
        ?>
                <div class="col-md-3">
                    <div class="card p-4 shadow-sm">
                        <img src="<?= htmlspecialchars('views/products/' . ($product['image'] ?? 'default.jpg')) ?>" 
                             class="w-100" 
                             alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>">
                        <div class="mt-2">⭐⭐⭐⭐⭐</div>
                        <p class="mt-2"><?= htmlspecialchars($product['product_name'] ?? 'N/A') ?></p>
                    </div>
                </div>
        <?php 
            }
        }
        ?>
    </div>

    <!-- Transactions Section -->
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
                        <?php foreach ($products as $index => $product): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars('views/products/' . ($product['image'] ?? 'default.jpg')) ?>" 
                                             class="card-img-top w-px-50" 
                                             alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>">
                                        <span class="ms-3"><?= htmlspecialchars($product['product_name'] ?? 'N/A') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">
                                        <i class="bi bi-cup-hot me-1"></i>
                                        <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="color: <?= ($product['quantity'] ?? 0) < 5 ? 'red' : 'green' ?>;">
                                        <?= ($product['quantity'] ?? 0) < 5 ? 'Low stock' : 'High stock' ?>
                                    </span>
                                </td>
                                <td>$<?= number_format($product['price'] ?? 0, 2) ?></td>
                                <td style="color: <?= ($product['quantity'] ?? 0) < 5 ? 'red' : 'inherit' ?>">
                                    <?= $product['quantity'] ?? 'N/A' ?>
                                </td>
                                <td>$<?= number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 0), 2) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" 
                                                   href="/inventory/viewdrink/<?= $product['product_id'] ?? '' ?>">
                                                    <i class="bi bi-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" 
                                                   href="#" 
                                                   onclick="confirmDelete(<?= $product['product_id'] ?? 0 ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                                <form id="delete-form-<?= $product['product_id'] ?? '' ?>" 
                                                      action="/drink/delete/<?= $product['product_id'] ?? '' ?>" 
                                                      method="POST" 
                                                      style="display:none;">
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

<!-- JavaScript Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
const { jsPDF } = window.jspdf;

function confirmDelete(productId) {
    if (productId && confirm('Are you sure you want to delete this product?')) {
        document.getElementById(`delete-form-${productId}`).submit();
    }
}

function loadImageAsBase64(url) {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'Anonymous';
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            canvas.getContext('2d').drawImage(img, 0, 0);
            resolve(canvas.toDataURL('image/png'));
        };
        img.onerror = () => resolve(null);
        img.src = url;
    });
}

document.getElementById('exportButton').addEventListener('click', async () => {
    try {
        const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
        const products = <?php echo json_encode($products) ?: '[]'; ?>;

        if (!Array.isArray(products) || !products.length) {
            alert('No products available to export!');
            return;
        }

        // Header
        doc.setFillColor(66, 139, 202);
        doc.rect(0, 0, 210, 40, 'F');
        doc.setFillColor(100, 181, 246);
        doc.triangle(0, 0, 210, 0, 105, 40, 'F');

        const logoUrl = '/views/assets/modules/img/logo/logo.png';
        const logoBase64 = await loadImageAsBase64(logoUrl);
        if (logoBase64) {
            doc.addImage(logoBase64, 'PNG', 15, 5, 30, 30);
        }

        doc.setTextColor(255, 255, 255);
        doc.setFontSize(24);
        doc.setFont('helvetica', 'bold');
        doc.text('Mak Oun Sing Shop', 50, 20);
        doc.setFontSize(11);
        doc.setFont('helvetica', 'normal');
        doc.text(`Generated: ${new Date().toLocaleString()}`, 50, 30);
        doc.setDrawColor(255, 204, 0);
        doc.setLineWidth(0.5);
        doc.line(15, 35, 195, 35);

        // Table
        doc.autoTable({
            startY: 45,
            head: [['#', 'Product', 'Category', 'Stock', 'Price', 'Qty', 'Amount']],
            body: products.map((p, i) => [
                i + 1,
                p.product_name || 'N/A',
                p.category_name || 'N/A',
                (p.quantity ?? 0) < 5 ? 'Low stock' : 'High stock',
                `$${Number(p.price || 0).toFixed(2)}`,
                p.quantity ?? 'N/A',
                `$${Number((p.price || 0) * (p.quantity || 0)).toFixed(2)}`
            ]),
            theme: 'grid',
            styles: { fontSize: 10, cellPadding: 3 },
            headStyles: { fillColor: [66, 139, 202], textColor: [255, 255, 255] },
            didParseCell: (data) => {
                if (data.column.index === 3) {
                    data.cell.styles.textColor = data.cell.text[0] === 'Low stock' ? [220, 53, 69] : [40, 167, 69];
                }
            },
            didDrawPage: (data) => {
                const pageHeight = doc.internal.pageSize.height;
                doc.setFillColor(240, 248, 255);
                doc.rect(0, pageHeight - 25, 210, 25, 'F');
                doc.setFontSize(9);
                doc.setTextColor(66, 139, 202);
                doc.text(`Page ${doc.internal.getNumberOfPages()}`, 185, pageHeight - 15);
                doc.text('© 2025 Drink Management System', 15, pageHeight - 15);
            }
        });

        // Summary
        const finalY = doc.lastAutoTable.finalY + 10;
        const totalAmount = products.reduce((sum, p) => sum + ((p.price || 0) * (p.quantity || 0)), 0);
        const lowStockCount = products.filter(p => (p.quantity ?? 0) < 5).length;

        doc.setFontSize(14);
        doc.setTextColor(66, 139, 202);
        doc.text('Quick Summary', 20, finalY + 8);
        doc.setFontSize(10);
        doc.setTextColor(50, 50, 50);
        doc.text(`Total Inventory Value: $${totalAmount.toFixed(2)}`, 20, finalY + 16);
        doc.text(`Items with Low Stock: ${lowStockCount}`, 20, finalY + 23);

        doc.save(`mak_oun_sing_report_${new Date().toISOString().slice(0,10)}.pdf`);
    } catch (error) {
        console.error('PDF Export Error:', error);
        alert('Error generating PDF. Please try again.');
    }
});
</script>

<!-- Low Stock Alert -->
<?php
$low_stock_items = array_filter($products, fn($p) => ($p['quantity'] ?? 0) < 5);
if (!empty($low_stock_items)): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="lowStockToast" class="toast" role="alert">
            <div class="toast-header">
                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                <strong class="me-auto">Low Stock Alert</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                <ul class="list-unstyled mb-0">
                    <?php foreach ($low_stock_items as $item): ?>
                        <li><?= htmlspecialchars($item['product_name'] ?? 'Unknown') ?> (<?= $item['quantity'] ?? 0 ?> units)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new bootstrap.Toast(document.getElementById('lowStockToast'), { delay: 5000 }).show();
        });
    </script>
<?php endif; ?>