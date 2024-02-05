<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($product['title']); ?></title>
    <link rel="stylesheet" href="/assets/dist/main.css" />
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-4xl mx-auto bg-white p-5 rounded shadow">
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($product['title']); ?></h1>
        <img src="<?= htmlspecialchars($product['photo']); ?>" alt="<?= htmlspecialchars($product['title']); ?>" class="w-full h-auto mt-4 mb-4">
        <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
        <p class="mt-2"><strong>Price:</strong> $<?= htmlspecialchars($product['price']); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($product['status']); ?></p>
        <p><strong>On Sale:</strong> <?= $product['on_sale'] ? 'Yes' : 'No'; ?></p>
        <div class="mt-4">
            <a href="add_review.php?product_id=<?= $productID; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Review</a>
        </div>
    </div>
    <div class="max-w-4xl mx-auto mt-8">
        <h2 class="text-xl font-semibold mb-4">Reviews</h2>
        <?php if($product): ?>
            <div class="add-review">
                <h2>Add a Review</h2>
                <form action="product.php?id=<?= $productID; ?>" method="post">
                    <input type="hidden" name="product_id" value="<?= $productID; ?>">
                    <div>
                        <label for="rating">Rating:</label>
                        <select name="rating" id="rating" required>
                            <option value="">Choose a rating</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                    <div>
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" required></textarea>
                    </div>
                    <button type="submit" name="submit_review">Submit Review</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="bg-white p-4 rounded shadow mb-4">
                    <p><?= nl2br(htmlspecialchars($review['comment'])); ?></p>
                    <p class="text-sm">Rating: <?= str_repeat('★', $review['rating']); ?></p>
                    <p class="text-sm">By: <?= htmlspecialchars($review['first_name']) . ' ' . htmlspecialchars($review['last_name']); ?> on <?= date('F j, Y', strtotime($review['date'])); ?></p>
                    <div class="mt-2">
                        <a href="edit_review.php?review_id=<?= $review['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                        <a href="delete_review.php?review_id=<?= $review['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
