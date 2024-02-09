<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $btnText; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
</head>
<body class="bg-gray-100 p-5">
    <div class="m-auto max-w-4xl bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h1 class="block w-full text-center text-gray-800 text-2xl font-bold mb-6"><?= $btnText; ?></h1>
        <form method="POST" action="<?= $formAction; ?>" enctype="multipart/form-data">
            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" name="title" type="text" value="<?= htmlspecialchars($formInputs['title'] ?? ''); ?>" required>
                <p class="text-red-500 text-xs italic"><?= $formErrors['title'] ?? ''; ?></p>
            </div>
            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" required><?= htmlspecialchars($formInputs['description'] ?? ''); ?></textarea>
                <p class="text-red-500 text-xs italic"><?= $formErrors['description'] ?? ''; ?></p>
            </div>
            <!-- Price -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price ($)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" type="number" step="0.01" min="0" value="<?= htmlspecialchars($formInputs['price'] ?? ''); ?>" required pattern="^\d*(\.\d{0,2})?$" maxlength="10">
                <p class="text-red-500 text-xs italic"><?= $formErrors['price'] ?? ''; ?></p>
            </div>
            <!-- Photo Upload and Preview -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">Photo</label>
                <input type="file" id="photo" name="photo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if (isset($imagePreview) && $imagePreview): ?>
                    <div class="mt-2">
                        <img src="<?= htmlspecialchars($imagePreview); ?>" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
                    </div>
                <?php endif; ?>
                <p class="text-red-500 text-xs italic"><?= $formErrors['photo'] ?? ''; ?></p>
            </div>
            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status</label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status">
                    <option value="new" <?= ($formInputs['status'] ?? '') == 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="used" <?= ($formInputs['status'] ?? '') == 'used' ? 'selected' : ''; ?>>Used</option>
                </select>
                <p class="text-red-500 text-xs italic"><?= $formErrors['status'] ?? ''; ?></p>
            </div>
            <!-- On Sale Checkbox -->
            <div class="mb-4">
                <label class="flex items-center">
                    <input class="form-checkbox" type="checkbox" id="on_sale" name="on_sale" value="1" <?= ($formInputs['on_sale'] ?? '') ? 'checked' : ''; ?>>
                    <span class="ml-2">On Sale</span>
                </label>
            </div>
            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit"><?= $btnText; ?></button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back to List</a>
            </div>
        </form>
    </div>
</body>
</html>
