<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP</title>
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
            <a href="add.php" class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2">Add Customer</a>
        </div>

        <table class="w-full">
            <thead>
                <tr class="border-b border-b-slate-900">
                    <th class="py-2 px-2">Last Name</th>
                    <th class="py-2">First Name</th>
                    <th class="py-2">Address</th>
                    <th class="py-2">City</th>
                    <th class="py-2">Province</th>
                    <th class="py-2">Postal</th>
                    <th class="py-2">Phone</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                    <tr class="border-b border-slate-900 even:bg-stone-100">
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['lastName']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['firstName']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['address']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['city']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['province']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['postal']); ?></td>
                        <td class="py-2 px-2"><?= htmlspecialchars($customer['phone']); ?></td>
                        <td class="py-2 px-2">
                            <a href="edit.php?id=<?= $customer['customerID']; ?>" class="inline-block border border-slate-800 bg-slate-500 hover:bg-slate-700 transition-colors ease-linear delay-100 text-slate-50 p-2">Edit</a>
                            <a class="inline-block border border-red-800 bg-red-500 hover:bg-red-700 text-white transition-colors ease-linear delay-100 p-2" href="delete.php?id=<?= $customer['customerID']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src=" ./assets/dist/main.bundle.js">
    </script>

</body>



</html>
