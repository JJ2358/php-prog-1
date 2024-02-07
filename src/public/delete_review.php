<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'App.php';

session_start();

// Check if the review ID and product ID are set
if (isset($_GET['review_id']) && isset($_GET['product_id'])) {
    $reviewId = (int) $_GET['review_id'];
    $productId = (int) $_GET['product_id'];

    // Call a function to delete the review
    $success = deleteReview($reviewId);

    if ($success) {
        $_SESSION['message'] = 'Review deleted successfully.';
    } else {
        $_SESSION['message'] = 'Failed to delete review.';
    }

    // Redirect back to the product page
    header("Location: product.php?id=$productId");
    exit;
} else {
    // Redirect to home if IDs not provided
    header('Location: index.php');
    exit;
}
