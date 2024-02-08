<?php

// // Validate and ensure the necessary GET parameters are present
// if (!isset($_GET['product_id']) || !isset($_GET['review_id'])) {
//     // Redirect to a generic error page or home page
//     header('Location: index.php?error=missing_parameters');
//     exit;
// }

$productID = (int)$_GET['product_id'];
$reviewID = (int)$_GET['review_id'];

// Fetch product details
$product = getProductDetailsPDO($productID);
// Fetch review details
$review = getReviewDetails($reviewID);

// Redirect or show an error if the product or review is not found
if (!$product || !$review) {
    header('Location: index.php?error=not_found');
    exit;
}

// Handle form submission for review update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract and sanitize input data
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    // Update the review in the database
    $updateSuccess = updateReview($reviewID, $rating, $firstName, $lastName, $comment);

    if ($updateSuccess) {
        // Optionally set a success message in session or redirect to product page with success message
        $_SESSION['flash_message'] = 'Review updated successfully.';
        header("Location: product.php?id=$productID");
        exit;
    } else {
        // Handle error in update
        $errorMessage = 'Failed to update the review.';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Review for <?= htmlspecialchars($product['title']); ?></title>
    <link rel="stylesheet" href="/assets/dist/main.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-5">
    <div class="my-4 mx-5">
    <a href="product.php?id=<?= htmlspecialchars($productID); ?>" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition ease-in-out duration-150">
            ← Back
        </a>
    </div>
    <div class="max-w-4xl mx-auto bg-white p-5 rounded shadow">
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($product['title']); ?></h1>
        <img src="<?= htmlspecialchars($product['photo']); ?>" alt="<?= htmlspecialchars($product['title']); ?>" class="w-full h-auto mt-4 mb-4">
        <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
        <p class="mt-2"><strong>Price:</strong> $<?= htmlspecialchars($product['price']); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($product['status']); ?></p>
        <p><strong>On Sale:</strong> <?= $product['on_sale'] ? 'Yes' : 'No'; ?></p>
    </div>

    <div class="mt-8">
        <form action="edit_review.php?product_id=<?= $productID; ?>&review_id=<?= $reviewID; ?>" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                <select name="rating" id="rating" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Choose a rating</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i; ?>" <?= $i == $review['rating'] ? 'selected' : ''; ?>><?= $i; ?> Star<?= $i > 1 ? 's' : ''; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($review['first_name']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($review['last_name']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Comment:</label>
                <textarea id="comment" name="comment" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= htmlspecialchars($review['comment']); ?></textarea>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Review</button>
        </form>
    </div>
</body>
</html>
