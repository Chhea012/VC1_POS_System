<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Models/ExportExcelModel.php';  // Ensure the model file path is correct

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelController {
    public function exportToExcel() {
        // Get product data from the model
        $productModel = new ProductExport();
        $products = $productModel->getProductsExport();  // Ensure this matches the model method name

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers for the spreadsheet
        $sheet->setCellValue('A1', 'PRODUCT');
        $sheet->setCellValue('B1', 'CATEGORY');
        $sheet->setCellValue('C1', 'STOCK');
        $sheet->setCellValue('D1', 'PRICE');
        $sheet->setCellValue('E1', 'Quantity');
        $sheet->setCellValue('F1', 'Total Price');
        
        // Populate the spreadsheet with data
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product['name']);
            $sheet->setCellValue('B' . $row, $product['category_name']);
            $sheet->setCellValue('C' . $row, $product['quantity'] < 5 ? 'Low stock' : 'High stock');
            $sheet->setCellValue('D' . $row, $product['price']);
            $sheet->setCellValue('E' . $row, $product['quantity']);
            $sheet->setCellValue('F' . $row, $product['price'] * $product['quantity']);
            $row++;
        }
        
        // Set headers for Excel download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="products_list.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Write the file to the output stream
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
?>
