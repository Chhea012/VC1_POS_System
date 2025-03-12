<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/CategoryModel.php';

class categoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Fetch products from the model
        $productModel = new ProductModel();
        $products     = $productModel->getAllProducts();

        // Pass products to the view
        $this->view('categorys/category-list', ['products' => $products]);

    }

    public function store()
    {
        // Logic for storing the new category
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $category_name = trim($_POST['category_name']);

            if (! empty($category_name)) {
                try {
                    if ($this->categoryModel->storeCategory($category_name)) {
                        // Redirect after success
                        $this->redirect('/category');
                    }
                } catch (Exception $e) {
                    echo "<script>alert('" . $e->getMessage() . "');</script>";
                }
            } else {
                echo "<script>alert('Please enter a category name.');</script>";
            }
        }
    }
}
