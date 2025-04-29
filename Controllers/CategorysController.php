<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/CategorysModel.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class categoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $this->view('categorys/category-list', ['products' => $categories]); // Note: Consider renaming 'products' to 'categories' in the view for clarity
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION['error_message'] = "Invalid request method.";
            $this->redirect('/category');
            return;
        }

        $category_name = trim($_POST['category_name'] ?? '');
        if (empty($category_name)) {
            $_SESSION['error_message'] = "Category name is required.";
            $this->redirect('/category');
            return;
        }

        try {
            if ($this->categoryModel->storeCategory($category_name)) {
                $_SESSION['success_message'] = "Category added successfully!";
                $this->redirect('/category');
            } else {
                throw new Exception("Error inserting category into database.");
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            error_log("Store Error: " . $e->getMessage());
            $this->redirect('/category');
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryByID($id);
        if ($category === false) {
            $_SESSION['error_message'] = "Category not found.";
            $this->redirect('/category');
            return;
        }
        $this->view('categorys/editCategory', ['category' => $category]);
    }

    public function update($category_id)
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION['error_message'] = "Invalid request method.";
            $this->redirect('/category');
            return;
        }

        $category_name = trim($_POST['category_name'] ?? '');
        if (empty($category_name)) {
            $_SESSION['error_message'] = "Category name is required.";
            $this->redirect('/category');
            return;
        }

        try {
            if ($this->categoryModel->updateCategory($category_id, $category_name)) {
                $_SESSION['success_message'] = "Category updated successfully!";
                $this->redirect('/category');
            } else {
                throw new Exception("Error updating category.");
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            error_log("Update Error: " . $e->getMessage());
            $this->redirect('/category');
        }
    }

    public function delete($category_id)
    {
        try {
            $this->categoryModel->delete($category_id);
            $_SESSION['success_message'] = "Category deleted successfully!";
            $this->redirect('/category');
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            error_log("Delete Error: " . $e->getMessage());
            $this->redirect('/category');
        }
    }

    public function import()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION['error_message'] = "Invalid request method.";
            $this->redirect('/category');
            return;
        }

        if (!isset($_FILES['category_file']) || $_FILES['category_file']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_message'] = "No file uploaded or upload error.";
            $this->redirect('/category');
            return;
        }

        $file = $_FILES['category_file']['tmp_name'];
        $fileType = mime_content_type($file);
        $allowedTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
            'application/vnd.ms-excel' // .xls
        ];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error_message'] = "Invalid file type. Please upload an Excel file.";
            $this->redirect('/category');
            return;
        }

        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows); // Remove header row

            $importedCount = $this->categoryModel->importCategories($rows);
            $_SESSION['success_message'] = "$importedCount categories imported successfully!";
            $this->redirect('/category');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error importing categories: " . $e->getMessage();
            error_log("Import Error: " . $e->getMessage());
            $this->redirect('/category');
        }
    }

    public function export()
    {
        try {
            $categories = $this->categoryModel->getAllCategories();
            if (empty($categories)) {
                $_SESSION['error_message'] = "No categories available to export.";
                $this->redirect('/category');
                return;
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'category_name');
            $row = 2;
            foreach ($categories as $category) {
                $sheet->setCellValue('A' . $row, $category['category_name']);
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'categories_export.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error exporting categories: " . $e->getMessage();
            error_log("Export Error: " . $e->getMessage());
            $this->redirect('/category');
        }
    }
}