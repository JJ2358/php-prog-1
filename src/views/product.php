

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($product['title']); ?></title>
    <link rel="stylesheet" href="/assets/dist/main.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-5">
    <div class="my-4 mx-5">
        <a href="index.php" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition ease-in-out duration-150">
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
    <div class="max-w-4xl mx-auto mt-8">
        <h2 class="text-xl font-semibold mb-4">Reviews</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="bg-white p-4 rounded shadow mb-4">
                    <p><?= nl2br(htmlspecialchars($review['comment'])); ?></p>
                    <p class="text-sm">Rating: <?= str_repeat('★', $review['rating']); ?></p>
                    <p class="text-sm">By: <?= htmlspecialchars($review['first_name']) . ' ' . htmlspecialchars($review['last_name']); ?> on <?= date('F j, Y', strtotime($review['date'])); ?></p>
                    <div class="mt-2">
                        <a href="edit_review.php?review_id=<?= $review['id']; ?>&product_id=<?= $product['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                        <a href="delete_review.php?review_id=<?= $review['id']; ?>&product_id=<?= $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this review?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>

        <?php
        // Check if the user's name is stored in the session
        $firstName = $_SESSION['user_first_name'] ?? '';
        $lastName = $_SESSION['user_last_name'] ?? '';
        ?>

        <div class="mt-4">
            <label for="toggleReview" class="inline-flex items-center cursor-pointer text-lg text-blue-600 hover:text-blue-800">
                <input type="checkbox" id="toggleReview" class="form-checkbox rounded text-blue-500 focus:ring-blue-500" onchange="document.getElementById('reviewForm').classList.toggle('hidden');">
                <span class="ml-2">Add a Review</span>
            </label>
        </div>

        <div id="reviewForm" class="hidden mt-4">
        <form action="product.php?id=<?= $productID; ?>" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="product_id" value="<?= $productID; ?>">
            <!-- Rating Select -->
            <div class="mb-4">
                <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                <select name="rating" id="rating" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Choose a rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <!-- First Name Input -->
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($firstName); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <!-- Last Name Input -->
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($lastName); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <!-- Comment Textarea -->
            <div class="mb-4">
                <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Comment:</label>
                <textarea id="comment" name="comment" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
                <button type="submit" name="submit_review" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit Review</button>
                <?php if (!empty($firstName) || !empty($lastName)): ?>
                    <a href="product.php?id=<?= $productID; ?>&forget_me=1" class="text-sm text-blue-500 hover:text-blue-800">Forget Me</a>
                <?php endif; ?>
            </form>
        </div>
            <!-- "Forget Me" Link (Shown if user's name is remembered) -->
        <?php if (!empty($firstName) || !empty($lastName)): ?>
            <div class="mt-4">
                <a href="product.php?id=<?= $productID; ?>&forget_me=1" class="text-sm text-blue-500 hover:text-blue-800">Forget Me</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
