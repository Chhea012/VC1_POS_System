<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Models/ExportInventoryModel.php';

use Dompdf\Dompdf;

class ExportInventoryController
{
    public function index()
    {
        $inventoryPdfModel = new ExportInventoryModel();
        $products = $inventoryPdfModel->getProducts();
        $data = ['products' => $products];
        return $this->renderView('ExportInvntory/exportInventory', $data); // Updated path
    }

    public function exportInventoryPdf()
    {
        $exportInventoryModel = new ExportInventoryModel();
        $products = $exportInventoryModel->getProducts();
        $imagePath = realpath(__DIR__ . '/../views/assets/modules/img/logo/logo.png');
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $mimeType = mime_content_type($imagePath);
            $logoSrc = "data:$mimeType;base64,$imageData";
        } else {
            $logoSrc = '';
        }
        $html = $this->renderView('ExportInvntory/exportInventory', ['products' => $products]); // Updated path

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('inventory.pdf', ['Attachment' => true]);
    }

    private function renderView($view, $data = [])
    {
        extract($data);
        ob_start();
        require_once __DIR__ . '/../views/' . $view . '.php'; // Lowercase 'views' to match your path
        return ob_get_clean();
    }
}
