


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Listing</title>
    <link rel="stylesheet" href="/assets/dist/main.css" />
</head>
<body class="p-5">
    <div class="m-auto w-4/5">
        <div class="mb-4">
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="text-green-500">
                    <?= getSessionMessage(); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <a href="add.php" class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2">Add Product</a>
        </div>
        <form action="index.php" method="GET" class="mb-4">
            <div class="mb-2">
                <label for="status">Status:</label>
                <select name="status" id="status" class="border border-gray-400">
                    <option value="any" <?= $status == 'any' ? 'selected' : ''; ?>>Any</option>
                    <option value="new" <?= $status == 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="used" <?= $status == 'used' ? 'selected' : ''; ?>>Used</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="on_sale">On Sale:</label>
                <input type="checkbox" name="on_sale" id="on_sale" value="1" <?= $onSale ? 'checked' : ''; ?> class="border border-gray-400">
            </div>
            <button type="submit" class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2">Filter</button>
        </form>
        <table class="w-full">
            <thead>
                <tr class="border-b border-b-slate-900">
                    <th class="py-2 px-2">Title</th>
                    <th class="py-2">Description</th>
                    <th class="py-2">Price</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">On Sale</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr class="border-b border-slate-900 even:bg-stone-100">
                        <td class="py-2 px-2"><a href="product.php?id=<?= $product['id']; ?>"><?= htmlspecialchars($product['title']); ?></a></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($product['description']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($product['price']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($product['status']); ?></td>
                        <td class="py-2 px-2"><?= $product['on_sale'] ? 'Yes' : 'No'; ?></td>
                        <td class="py-2 px-2">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="./assets/dist/main.bundle.js"></script>
</body>
</html>
