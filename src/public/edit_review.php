<?php

declare(strict_types=1);

session_start();

// Include app logic
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'App.php';

// Check if a review ID is provided
if (!isset($_GET['review_id'])) {
    // Redirect to a generic error page or home page with an error message
    header('Location: index.php?error=missing_review_id');
    exit;
}

$reviewID = (int)$_GET['review_id'];
$productID = null; // Initialize productID variable

// Fetch review details to pre-populate the form
$review = getReviewDetails($reviewID);

if ($review) {
    $productID = $review['product_id'];
} else {
    // Redirect if the review doesn't exist
    header('Location: index.php?error=review_not_found');
    exit;
}
// If a "forget me" request is detected
if (isset($_GET['forget_me'])) {
    unset($_SESSION['user_first_name']);
    unset($_SESSION['user_last_name']);
    // Redirect to avoid repeating the action on refresh
    header("Location: product.php?id=$productID");
    exit;
}

require VIEWS_PATH . 'edit_review.php';
