<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Models/ExportExcelModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExportExcelController {
    public function exportToExcel() {
        // Get product data from the model
        $productModel = new ProductExport();
        $products = $productModel->getProductsExport();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers for the spreadsheet (removed Total Price)
        $sheet->setCellValue('A1', 'product_name');
        $sheet->setCellValue('B1', 'description');
        $sheet->setCellValue('C1', 'category_name');
        $sheet->setCellValue('D1', 'price');
        $sheet->setCellValue('E1', 'cost_product');
        $sheet->setCellValue('F1', 'quantity');
        $sheet->setCellValue('G1', 'image');
        $sheet->setCellValue('H1', 'barcode');

        // Populate the spreadsheet with data (removed Total Price)
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product['product_name']);
            $sheet->setCellValue('B' . $row, $product['description']);
            $sheet->setCellValue('C' . $row, $product['category_name']);
            $sheet->setCellValue('D' . $row, $product['price']);
            $sheet->setCellValue('E' . $row, $product['cost_product']);
            $sheet->setCellValue('F' . $row, $product['quantity']);
            
            // Handle image if exists
            if (!empty($product['image']) && file_exists($product['image'])) {
                $drawing = new Drawing();
                $drawing->setPath($product['image']);
                $drawing->setCoordinates('G' . $row);
                $drawing->setWidth(50);
                $drawing->setHeight(50);
                $drawing->setWorksheet($sheet);
            } else {
                $sheet->setCellValue('G' . $row, 'No Image');
            }

            // Set barcode as text explicitly
            $sheet->setCellValueExplicit('H' . $row, $product['barcode'], DataType::TYPE_STRING);

            $row++;
        }

        // Adjust column widths for better readability
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set headers for Excel download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="products_export.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the output stream
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
?>