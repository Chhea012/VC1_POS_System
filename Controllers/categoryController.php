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
                    if ($result) {
                        $_SESSION['success_message'] = "Category added successfully!";
                        header("Location: /category");
                        exit;
                    } else {
                        throw new Exception("Error inserting category into database.");
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = $e->getMessage();
                    error_log("Store Error: " . $e->getMessage());
                    header("Location: /category");
                    exit;
                }
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
        try {
        $category_name = $_POST['category_name']; // Get the updated category name from the form
        
        $result = $this->categoryModel->updateCategory($category_id, $category_name);
        
        if ($result) {
            header("Location: /category");
            $_SESSION['success_message'] = "Edit Category Name successfully!";
            exit;
        } else {
            throw new Exception("Error updating category.");
        }
    } catch (Exception $e) {
        error_log("Update Error: " . $e->getMessage());
        echo "<script>alert('" . $e->getMessage() . "');</script>";
    }
}
    

public function delete($category_id)
{
    // Perform the deletion
    $this->categoryModel->delete($category_id);
    
    // Set a success message
    $_SESSION['success_message'] = "Category deleted successfully!";
    
    // Redirect to the product list page
    header("Location: /category");
    exit;
}

}
