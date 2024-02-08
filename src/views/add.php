<?php
// Start output buffering to prevent "headers already sent" issues
ob_start();

$btnText = 'Add Product';
$productID = null;
$formAction = htmlspecialchars($_SERVER["PHP_SELF"]);

// Initialize or reset errors and input values
$formErrors = ['title' => '', 'description' => '', 'price' => '', 'photo' => '', 'status' => '', 'on_sale' => ''];
$formInputs = ['title' => '', 'description' => '', 'price' => '', 'photo' => '', 'status' => '', 'on_sale' => ''];
$formSuccess = false;

if (isset($_GET['id'])) {
    $productID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $btnText = 'Update Product';
    $formAction .= '?id=' . $productID;
    // Fetch product details to prefill the form for updating
    $product = getProductDetailsPDO($productID);
    if ($product) {
        $formInputs = array_merge($formInputs, $product);
    } else {
        $_SESSION['message'] = "Product not found.";
        header("Location: index.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $formInputs['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formInputs['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formInputs['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $formInputs['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formInputs['on_sale'] = isset($_POST['on_sale']) ? 1 : 0;


    // Validate inputs (basic example)
    if (empty($formInputs['title'])) {
        $formErrors['title'] = 'Title is required.';
    }

    // Handle file upload for 'photo'
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/_assets'; // Adjust as necessary
        $fileName = time() . '-' . basename($_FILES['photo']['name']); // To avoid file name conflicts
        $targetPath = $uploadsDir . '/' . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $formInputs['photo'] = $fileName; // Adjust according to how you want to save the file name in the DB
        } else {
            $formErrors['photo'] = 'Failed to upload photo.';
        }
        if (empty($formErrors)) {
            // Attempt database operation...
            if ($success) {
                $_SESSION['message'] = 'Success message.';
                header("Location: index.php");
                exit; // Ensure no further output is sent to avoid "headers already sent" warning
            } else {
                $_SESSION['message'] = 'Error message.';
                // Consider redirecting or handling the error appropriately
            }
        }
    }

    // Check for errors before proceeding to database operation
    if (array_filter($formErrors) === []) {
        if ($productID) {
            // Update product
            $success = updateProductPDO($productID, $formInputs);
        } else {
            // Add new product
            $success = insertProductPDO($formInputs);
        }

        if ($success) {
            $_SESSION['message'] = $productID ? 'Product updated successfully.' : 'Product added successfully.';
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message'] = 'An error occurred.';
        }
    }
}

if ($productID) {
    // Fetch product details to prefill the form for updating
    $product = getProductDetailsPDO($productID);
    if ($product) {
        // Merge the product details with form inputs to prefill the form
        $formInputs = array_merge($formInputs, $product);
    } else {
        // Handle the case where no product is found for the given ID
        $_SESSION['message'] = "Product not found.";
        header("Location: index.php");
        exit;
    }
}

ob_end_flush();
?>

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
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" name="title" type="text" value="<?= htmlspecialchars($formInputs['title']); ?>" required>
                <p class="text-red-500 text-xs italic"><?= $formErrors['title']; ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" required><?= htmlspecialchars($formInputs['description']); ?></textarea>
                <p class="text-red-500 text-xs italic"><?= $formErrors['description']; ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price ($)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" type="number" step="0.01" value="<?= htmlspecialchars($formInputs['price']); ?>" required>
                <p class="text-red-500 text-xs italic"><?= $formErrors['price']; ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">Photo</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="photo" name="photo" type="file">
                <p class="text-red-500 text-xs italic"><?= $formErrors['photo']; ?></p>

            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status</label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status">
                    <option value="new" <?= $formInputs['status'] == 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="used" <?= $formInputs['status'] == 'used' ? 'selected' : ''; ?>>Used</option>
                </select>
                <p class="text-red-500 text-xs italic"><?= $formErrors['status']; ?></p>
            </div>
            <div class="mb-4">
                <label class="flex items-center">
                    <input class="form-checkbox" type="checkbox" id="on_sale" name="on_sale" value="1" <?= $formInputs['on_sale'] ? 'checked' : ''; ?>>
                    <span class="ml-2">On Sale</span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit"><?= $btnText; ?></button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back to List</a>
            </div>
        </form>
    </div>
</body>
</html>
