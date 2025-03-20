<?php
require_once 'vendor/autoload.php'; // Load Dompdf
require_once 'Models/ExportProductDetailModel.php'; // Ensure correct path

use Dompdf\Dompdf;
use Dompdf\Options;

class ExportInventoryController
{
    public function export($category_id)
    {
        // Fetch data from model
        $exportPdfModel = new ExportInventoryModel();
        $products = $exportPdfModel->getInventory($category_id);

        // Start HTML for PDF
        $html = '<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Inventory Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                <h2>Inventory Report</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Check if there are products
        if (!empty($products)) {
            foreach ($products as $product) {
                $html .= "<tr>
                            <td>{$product['id']}</td>
                            <td>{$product['name']}</td>
                            <td>{$product['category_name']}</td>
                            <td>\${$product['price']}</td>
                            <td>{$product['quantity']}</td>
                          </tr>";
            }
        } else {
            $html .= '<tr><td colspan="5" style="text-align: center;">No products found in this category</td></tr>';
        }

        // Close table and HTML
        $html .= '</tbody></table></body></html>';

        // Initialize Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Output the PDF as a downloadable file
        $dompdf->stream("inventory_report.pdf", ["Attachment" => true]);

        exit; // Stop further execution
    }
}
