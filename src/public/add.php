<?php

declare(strict_types=1);

session_start();
require dirname(__DIR__) . '/app/App.php';

$productID = $_GET['id'] ?? null;
$isUpdate = !empty($productID);
$formAction = $isUpdate ? "add.php?id=$productID" : "add.php";
// Initialize formErrors array to avoid undefined variable errors
$formErrors = [
    'title' => '',
    'description' => '',
    'price' => '',
    'status' => '',
    'on_sale' => '',
    'photo' => ''
];

$btnText = $isUpdate ? 'Update Product' : 'Add Product';
$data = [
    'title' => '',
    'description' => '',
    'price' => 0,
    'status' => '',
    'on_sale' => 0,
    'photo' => ''
];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'price' => filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT),
        'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'on_sale' => isset($_POST['on_sale']) ? 1 : 0,
    ];

    // Validate inputs
    if (empty($data['title'])) {
        $formErrors['title'] = 'Title is required.';
    }
    if (empty($data['description'])) {
        $formErrors['description'] = 'Description is required.';
    }
    if ($data['price'] === false) {
        $formErrors['price'] = 'Valid price is required.';
    }

    // Handle file upload for 'photo'
    if (!empty($_FILES['photo']['name'])) {
        $uploadResult = uploadImageAndStorePath($_FILES['photo']);
        if ($uploadResult['success']) {
            $data['photo'] = $uploadResult['path']; // Store the relative path to the uploaded image
        } else {
            $formErrors['photo'] = $uploadResult['error'];
        }
    } elseif ($isUpdate) {
        // If updating and no new photo is uploaded, keep the old photo
        $existingProduct = getProductDetailsPDO($productID);
        $data['photo'] = $existingProduct['photo'] ?? '';
    }

    if (empty($formErrors)) {
        if ($isUpdate) {
            $success = updateProductPDO($productID, $data);
            $message = 'Product updated successfully.';
        } else {
            $success = insertProductPDO($data);
            $message = 'Product added successfully.';
        }

        if ($success) {
            $_SESSION['message'] = $message;
            header("Location: index.php");
            exit;
        } else {
            $formErrors['general'] = 'An error occurred during the operation.';
        }
    }
}

// If updating, load existing product details for the form
if ($isUpdate && !$_POST) {
    $productDetails = getProductDetailsPDO($productID);
    if ($productDetails) {
        $data = $productDetails;
        $imagePreview = '/_assets/' . $productDetails['photo'];
    } else {
        $_SESSION['message'] = 'Product not found.';
        header("Location: index.php");
        exit;
    }
}


// Load the view
require VIEWS_PATH . 'add.php';
?>
