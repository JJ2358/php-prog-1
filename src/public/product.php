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

if(isset($_POST['submit_review'])) {
    // Sanitize and validate input
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Insert review into database
    $success = insertReview($productID, $rating, $firstName, $lastName, $comment);

    if($success) {
        // Optionally, save user's name in session
        $_SESSION['user_name'] = $firstName . ' ' . $lastName;

        // Redirect to avoid form resubmission
        header("Location: product.php?id=$productID");
        exit;
    } else {
        // Handle error
        echo "Error adding review.";
    }
}

if (isset($_POST['toggle_review_form'])) {
    if (isset($_POST['show_review_form'])) {
        $_SESSION['show_review_form'] = true;
    } else {
        unset($_SESSION['show_review_form']);
    }
}

// Fetch reviews for the product if needed
$reviews = getReviewsForProduct($productID);

// Include the view for displaying the product
require dirname(__DIR__) . '/views/product.php';
