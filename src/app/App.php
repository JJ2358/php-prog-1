<?php

declare(strict_types=1);

/**
 * Application utility functions for database operations, session management, and image handling.
 */

// Load configuration settings
$config = require_once 'Config.php';

/**
 * Establishes a MySQLi connection to the database.
 *
 * @return mysqli The database connection object.
 * @throws Exception if connection fails.
 */
function getConnectionMySQLi(): mysqli {
    try {
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        return $db;
    } catch (Exception $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

/**
 * Retrieves all products from the database using MySQLi.
 *
 * @return array An array of products.
 */
function getProductsMySQLi(): array {
    $db = getConnectionMySQLi();
    if (!$stmt = $db->prepare('SELECT * FROM products')) {
        die("Prepare statement failed: " . $db->error);
    }
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    if (empty($products)) {
        echo "No products found in database.<br>";
    }
    return $products;
}

/**
 * Establishes a PDO connection to the database.
 *
 * @return PDO The PDO database connection object.
 */
function getConnectionPDO(): PDO {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}

/**
 * Retrieves all products from the database using PDO.
 *
 * @return array An array of products.
 */
function getProductsPDO(): array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->query('SELECT * FROM products');
    $products = [];
    while ($row = $stmt->fetch()) {
        $products[] = $row;
    }
    return $products;
}

/**
 * Retrieves details of a single product by its ID using PDO.
 *
 * @param mixed $productID The ID of the product.
 * @return array|null An associative array of the product details or null if not found.
 */
function getProductDetailsPDO($productID): ?array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindValue(':id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Retrieves products filtered by status and sale flag using PDO.
 *
 * @param string $status The status to filter by ('any' for no filter).
 * @param int $onSale The sale flag to filter by (0 for no filter, 1 for on sale).
 * @return array An array of filtered products.
 */
function getFilteredProducts($status = 'any', $onSale = 0): array {
    $pdo = getConnectionPDO();
    $query = "SELECT * FROM products WHERE 1";
    $params = [];

    if ($status !== 'any') {
        $query .= " AND status = :status";
        $params[':status'] = $status;
    }
    if ($onSale) {
        $query .= " AND on_sale = :on_sale";
        $params[':on_sale'] = 1;
    }

    $stmt = $pdo->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Retrieves a session message if set, then clears it.
 *
 * @return string|null The session message if set, otherwise null.
 */
function getSessionMessage(): ?string {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        return $message;
    }
    return null;
}

/**
 * Inserts a new product into the database using PDO.
 *
 * @param array $data Associative array containing product data.
 * @return bool True on success, false on failure.
 */
function insertProductPDO(array $data): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("INSERT INTO products (title, description, price, photo, status, on_sale) VALUES (:title, :description, :price, :photo, :status, :on_sale)");

    foreach ($data as $key => $value) {
        $stmt->bindValue(':'.$key, $value);
    }

    try {
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Updates an existing product in the database using PDO.
 *
 * @param mixed $productID The ID of the product to update.
 * @param array $data Associative array containing updated product data.
 * @return bool True on success, false on failure.
 */
function updateProductPDO($productID, array $data): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("UPDATE products SET title = :title, description = :description, price = :price, photo = :photo, status = :status, on_sale = :on_sale WHERE id = :id");

    $stmt->bindValue(':id', $productID, PDO::PARAM_INT);
    foreach ($data as $key => $value) {
        $stmt->bindValue(':'.$key, $value);
    }

    return $stmt->execute();
}

/**
 * Retrieves all reviews for a specific product using PDO.
 *
 * @param mixed $productID The ID of the product to retrieve reviews for.
 * @return array An array of reviews for the specified product.
 */
function getReviewsForProduct($productID): array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id = :product_id ORDER BY date DESC");
    $stmt->bindValue(':product_id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Inserts a new review for a product into the database using PDO.
 *
 * @param mixed $productID The ID of the product the review is for.
 * @param int $rating The rating given in the review.
 * @param string $firstName The first name of the reviewer.
 * @param string $lastName The last name of the reviewer.
 * @param string $comment The review comment.
 * @return bool True on success, false on failure.
 */
function insertReview($productID, $rating, $firstName, $lastName, $comment): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("INSERT INTO reviews (product_id, rating, first_name, last_name, comment) VALUES (:product_id, :rating, :first_name, :last_name, :comment)");

    $stmt->bindValue(':product_id', $productID, PDO::PARAM_INT);
    $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindValue(':first_name', $firstName);
    $stmt->bindValue(':last_name', $lastName);
    $stmt->bindValue(':comment', $comment);

    return $stmt->execute();
}

/**
 * Deletes a review from the database using PDO.
 *
 * @param mixed $reviewId The ID of the review to delete.
 * @return bool True on success, false on failure.
 */
function deleteReview($reviewId): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
    $stmt->bindValue(':id', $reviewId, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Retrieves details for a specific review using PDO.
 *
 * @param int $reviewID The ID of the review to retrieve details for.
 * @return array|null An associative array of the review details or null if not found.
 */
function getReviewDetails(int $reviewID): ?array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :id");
    $stmt->execute([':id' => $reviewID]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Updates an existing review in the database using PDO.
 *
 * @param int $reviewID The ID of the review to update.
 * @param int $rating The updated rating.
 * @param string $firstName The updated first name of the reviewer.
 * @param string $lastName The updated last name of the reviewer.
 * @param string $comment The updated review comment.
 * @return bool True on success, false on failure.
 */
function updateReview(int $reviewID, int $rating, string $firstName, string $lastName, string $comment): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("UPDATE reviews SET rating = :rating, first_name = :first_name, last_name = :last_name, comment = :comment WHERE id = :id");

    $stmt->bindValue(':id', $reviewID, PDO::PARAM_INT);
    $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindValue(':first_name', $firstName);
    $stmt->bindValue(':last_name', $lastName);
    $stmt->bindValue(':comment', $comment);

    return $stmt->execute();
}

/**
 * Handles the upload of an image file and stores it in a specified directory.
 *
 * @param array $imageFile The image file to upload.
 * @return array An associative array containing the upload status and either the path of the uploaded image or an error message.
 */
function uploadImageAndStorePath($imageFile) {
    $targetDir = __DIR__ . '/src/_assets/';
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = uniqid() . '-' . basename($imageFile['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($imageFile['tmp_name'], $targetFilePath)) {
        return ['success' => true, 'path' => 'src/_assets/' . $fileName];
    } else {
        return ['success' => false, 'error' => 'Failed to upload image.'];
    }
}
