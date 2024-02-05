<?php

declare(strict_types=1);

session_start();

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'App.php';

// Initialize variables for form handling
$formErrors = [];
$productID = $_GET['id'] ?? null;
$isUpdate = !empty($productID);
$btnText = $isUpdate ? 'Update Product' : 'Add Product';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $data = [
        'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
        'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
        'price' => filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT),
        'photo' => '', // Assume photo handling is done separately
        'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING),
        'on_sale' => isset($_POST['on_sale']) ? 1 : 0,
    ];

    // Additional validation and file upload handling here

    // If validation passes, insert or update the product
    if (empty($formErrors)) {
        $success = $isUpdate ? updateProductPDO($productID, $data) : insertProductPDO($data);
        if ($success) {
            $_SESSION['message'] = $isUpdate ? 'Product updated successfully.' : 'Product added successfully.';
            header("Location: index.php"); // Redirect to a confirmation page or back to the product list
            exit;
        } else {
            $_SESSION['message'] = 'An error occurred during the operation.';
        }
    }
}

// If updating, fetch product details to prefill the form
if ($isUpdate) {
    // Assume getProductDetailsPDO() is a function you'll implement to fetch a product by ID
    $productDetails = getProductDetailsPDO($productID);
    if ($productDetails) {
        $data = $productDetails;
    } else {
        $_SESSION['message'] = 'Product not found.';
        header("Location: index.php");
        exit;
    }
}

require VIEWS_PATH . 'add.php'; // Load the view
