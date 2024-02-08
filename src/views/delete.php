<?php

// using $_GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    return http_response_code(404);
}

// if (isset($_POST['id']) && is_numeric($_POST['id'])) {
//     deleteCustomerPDO($_POST['id']);
//     return header('Location: index.php');
// }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP</title>
    <link rel="stylesheet" href="./assets/dist/main.css" />
</head>

<body class="p-5">

    <div class="m-auto max-w-6xl">
        <div class="w-10/12 md:w-4/12">
            <p>Are you sure you want to delete customer <?= htmlspecialchars($_GET['id']); ?></p>

            <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?= intval($_GET['id']); ?>">
                <input type="hidden" name="id" value="<?= intval($_GET['id']); ?>" />
                <div class="mt-5">
                    <input class="inline-block border border-red-800 bg-red-500 hover:bg-red-700 transition-colors ease-linear delay-100 text-white p-2 cursor-pointer" type="submit" name="submit" value="Delete customer" />
                    <a href="index.php" class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</body>

<script src="./assets/dist/main.bundle.js">
</script>

</html>
