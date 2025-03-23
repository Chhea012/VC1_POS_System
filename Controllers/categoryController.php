<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/CategoryModel.php';

class categoryController extends BaseController
{
    private $categoryModel;
    private $productManager; // Add this property

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productManager = new ProductModel();
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
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryByID($id); // Use categoryModel instead of productManager
        if ($category === false) {
            // Handle the case where the category is not found
            // For example, redirect to an error page or display a message
            header("Location: /category?error=CategoryNotFound");
            exit();
        }
        // Proceed with the category data (e.g., pass it to a view)
        // Example: Render an edit form
        require_once __DIR__ . '/../views/categorys/editCategory.php';
    }
    public function update($category_id)
    {
        $category_name = $_POST['category_name']; // Get the updated category name from the form
        
        $result = $this->categoryModel->updateCategory($category_id, $category_name);
        
        if ($result) {
            // Redirect or return a success message
            header("Location: /category"); // Redirect back to the categories list
            exit();
        } else {
            // Handle the error case
            echo "Failed to update category.";
        }
    }
    

public function delete($category_id)
{
    // Perform the deletion
    $this->categoryModel->delete($category_id);
    
    // Set a success message
    $_SESSION['success_message'] = "Product deleted successfully!";
    
    // Redirect to the product list page
    header("Location: /category");
    exit;
}

}
