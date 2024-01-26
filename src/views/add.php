<?php

$btnText = 'Add Customer';
$customerID = null;
$formAction = htmlspecialchars($_SERVER["PHP_SELF"]);

// errors array
$formErrors = [
    'lastName' => '',
    'firstName' => '',
    'address' => '',
    'city' => '',
    'province' => '',
    'postal' => '',
    'phone' => '',
    'photo' => '',
];
$formInputs = $formErrors;
$formSuccess = false;

if (isset($_GET['id'])) {
    $customerID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $btnText = 'Update Customer';
    $formAction .= '?id=' . $customerID;
}

if (isset($_POST['submit'])) {
    $formInputs['lastName'] = trim(filter_input(INPUT_POST, 'lastName'));
    $formInputs['firstName'] = trim(filter_input(INPUT_POST, 'firstName'));
    $formInputs['address'] = trim(filter_input(INPUT_POST, 'address'));
    $formInputs['city'] = trim(filter_input(INPUT_POST, 'city'));
    $formInputs['province'] = trim(filter_input(INPUT_POST, 'province'));
    $formInputs['postal'] = trim(filter_input(INPUT_POST, 'postal'));
    $formInputs['phone'] = trim(filter_input(INPUT_POST, 'phone'));

    if (empty($formInputs['lastName'])) {
        $formErrors['lastName'] = 'Last Name is required';
        // check if name only contains letters and whitespace
    } else if (strlen($formInputs['lastName']) > 50) {
        $formErrors['lastName'] = 'Last Name must be less than 50 characters';
    } else if (!preg_match("/^[a-zA-Z ]*$/", $formInputs['lastName'])) {
        $formErrors['lastName'] = 'Only letters and white space allowed';
    }

    if (empty($formInputs['firstName'])) {
        $formErrors['firstName'] = 'First Name is required';
    } else if (strlen($formInputs['firstName']) > 50) {
        $formErrors['firstName'] = 'First Name must be less than 50 characters';
    } else if (!preg_match("/^[a-zA-Z ]*$/", $formInputs['firstName'])) {
        $formErrors['firstName'] = 'Only letters and white space allowed';
    }

    if (empty($formInputs['postal'])) {
        $formErrors['postal'] = 'Postal is required';
        // check if postal is in format A1A 1A1 or A1A1A1
        // ^ - start of string
        // [A-Za-z] - any letter
        // \d - any digit
        // [ ]? - optional space
        // $ - end of string
    } else if (!preg_match("/^[A-Za-z]\d[A-Za-z][ ]?\d[A-Za-z]\d$/", $formInputs['postal'])) {
        $formErrors['postal'] = 'Postal must be in format A1A 1A1 or A1A1A1';
    }

    // check if photo was uploaded - UPLOAD_ERR_OK is a constant that equals 0 - means no errors
    if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $maxFileSize = 1024 * (1024 * 2); //2MB

        //our allowed file extensions
        $allowedFileExtension = [
            'jpg', 'jpeg', 'png',
        ];

        // get file name - only first 100 characters
        $fileName = substr($_FILES['photo']['name'], 0, 100);

        // get target path with file name - basename() gets the file name
        $target = UPLOADS_DIR . DIRECTORY_SEPARATOR . basename($fileName);
        // get file extension
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        //check size
        if ($_FILES['photo']['size'] >= $maxFileSize) {
            $formErrors['photo'] = 'Uploaded file exceeds maximum file size of ' . $maxFileSize / 1024 / 1024 . 'MB';
        }

        //check file type
        if (!in_array($extension, $allowedFileExtension)) {
            $formErrors['photo'] = 'Incorrect file type. Please upload a ' . implode(', ', $allowedFileExtension);
        }

        // no errors, attempt to upload
        if (!$formErrors['photo']) {
            // upload image to server

            // make uploads directory if it doesn't exist
            if (!is_dir(UPLOADS_DIR)) {
                mkdir(UPLOADS_DIR);
            }

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $formErrors['photo'] = 'Sorry, there was a problem uploading your file. Please try again.';
            }

            $_POST['photo'] = $fileName;
        }
    }

    if (implode('', $formErrors) === '') {
        if ($customerID) {
            updateCustomerPDO($customerID, $_POST);
            $formSuccess = true;
            $_SESSION['message'] = 'Updated Customer';
            header('Location: edit.php?' . http_build_query(['id' => $customerID]));
            exit;
        } else {
            insertCustomerPDO($_POST);
            $formSuccess = true;
            $_SESSION['message'] = 'New Customer added';
            header('Location: add.php');
            exit;
        }
    }
}

if ($customerID) {
    $customer = getCustomerPDO($customerID);

    if ($customer) {
        $formInputs = $customer;
    } else {
        return http_response_code(404);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP</title>
    <link rel="stylesheet" href="/assets/dist/main.css" />
</head>

<body class="p-5">

    <div class="m-auto max-w-6xl">
        <div class="w-10/12 md:w-4/12">
            <?php if (isset($_SESSION['message'])) : ?>
                <span class="text-green-500"><?= getSessionMessage(); ?></span>
            <?php endif; ?>

            <form method="POST" action="<?= $formAction; ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($formInputs['lastName']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <span class="text-red-500"><?= $formErrors['lastName']; ?></span>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($formInputs['firstName']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <span class="text-red-500"><?= $formErrors['firstName']; ?></span>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="address">Address</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="address" name="address" />
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="city">City</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="city" name="city" />
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="province">Province</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="province" name="province" />
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="postal">Postal</label>
                    <input value="<?= htmlspecialchars($formInputs['postal']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="postal" name="postal" />
                    <span class="text-red-500"><?= $formErrors['postal']; ?></span>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="phone">Phone</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="phone" name="phone" />
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="photo">Photo</label>
                    <input type="file" name="photo" />
                    <span class="text-red-500"><?= $formErrors['photo']; ?></span>

                    <?php if (isset($formInputs['photo'])) : ?>
                        <img src="<?= UPLOADS_DIR . DIRECTORY_SEPARATOR . $formInputs['photo']; ?>" alt="<?= $formInputs['photo']; ?>" width="150" />
                    <?php endif; ?>
                </div>

                <div class="mt-5">
                    <input class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2" type="submit" name="submit" value="<?= $btnText; ?>" />
                    <a href="index.php" class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</body>

<script src="./assets/dist/main.bundle.js">
</script>

</html>
