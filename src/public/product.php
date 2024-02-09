<?php
declare(strict_types=1);

session_start();
require dirname(__DIR__) . '/app/App.php';

$productID = $_GET['id'] ?? null;
$product = getProductDetailsPDO($productID);

if (!$product) {
    echo "Product not found";
    exit;
}

if (isset($_POST['submit_review'])) {
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $success = insertReview($productID, $rating, $firstName, $lastName, $comment);

    if ($success) {
        $_SESSION['user_first_name'] = $firstName;
        $_SESSION['user_last_name'] = $lastName;
        header("Location: product.php?id=$productID");
        exit;
    }
}

if (isset($_GET['forget_me'])) {
    unset($_SESSION['user_first_name'], $_SESSION['user_last_name']);
    header("Location: product.php?id=$productID");
    exit;
}


$reviews = getReviewsForProduct($productID);

require dirname(__DIR__) . '/views/product.php';
