<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Models/generatePdf.php';

use Dompdf\Dompdf;

class GeneratePdfController
{
    public function index()
    {
        $generatePdfModel = new GeneratePdf();
        $products = $generatePdfModel->getProducts();
        $data = ['products' => $products];
        return $this->renderView('GeneratePDF/pdf', $data);
    }

    public function generatepdf()
    {
        $generatePdfModel = new GeneratePdf();
        $products = $generatePdfModel->getProducts();
        $html = $this->renderView('GeneratePDF/pdf', ['products' => $products]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('products.pdf', ['Attachment' => true]);
    }

    private function renderView($view, $data = [])
    {
        extract($data);
        ob_start();
        require_once __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
}