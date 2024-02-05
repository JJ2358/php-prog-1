<?php

declare(strict_types=1);

session_start();

// Include the application logic
require dirname(__DIR__) . '/app/App.php';

// Check if an ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to home or show an error if no product ID is provided
    header('Location: index.php');
    exit;
}

$productID = (int) $_GET['id'];

// Fetch product details using the provided ID
$product = getProductDetailsPDO($productID);

// Redirect or show an error if the product is not found
if (!$product) {
    echo "Product not found";
    exit;
}

// Fetch reviews for the product if needed
$reviews = getReviewsForProduct($productID);

// Include the view for displaying the product
require dirname(__DIR__) . '/views/product.php';
