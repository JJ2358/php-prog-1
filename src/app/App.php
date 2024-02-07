<?php

declare(strict_types=1);

$config = require_once 'Config.php';

// MySQLi Connection
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

// Fetch Products using MySQLi
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



// PDO Connection
function getConnectionPDO(): PDO {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}

// Fetch Products using PDO
function getProductsPDO(): array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->query('SELECT * FROM products'); // Adjusted to target 'products' table
    $products = [];
    while ($row = $stmt->fetch()) {
        $products[] = $row;
    }
    var_dump($products);
    return $products;
}

function getProductDetailsPDO($productID): ?array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindValue(':id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    return $product ?: null;
}

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



function getSessionMessage(): ?string {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the message after retrieving it
        return $message;
    }
    return null; // Return null if no message is set
}

function insertProductPDO(array $data): bool {
    $db = getConnectionPDO();

    $stmt = $db->prepare("
    INSERT INTO products (title, description, price, photo, status, on_sale)
    VALUES (:title, :description, :price, :photo, :status, :on_sale)");

    $stmt->bindValue(':title', $data['title']);
    $stmt->bindValue(':description', $data['description']);
    $stmt->bindValue(':price', $data['price']);
    $stmt->bindValue(':photo', $data['photo']);
    $stmt->bindValue(':status', $data['status']);
    $stmt->bindValue(':on_sale', $data['on_sale'], PDO::PARAM_INT);

    return $stmt->execute();
}


function updateProductPDO($productID, array $data): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("UPDATE products SET title = :title, description = :description, price = :price, photo = :photo, status = :status, on_sale = :on_sale WHERE id = :id");
    // Bind values
    $stmt->bindValue(':id', $productID, PDO::PARAM_INT);
    // Bind other values similarly
    return $stmt->execute();
}

function getReviewsForProduct($productID): array {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id = :product_id ORDER BY date DESC");
    $stmt->bindValue(':product_id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

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
function deleteReview($reviewId): bool {
    $pdo = getConnectionPDO();
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
    $stmt->bindValue(':id', $reviewId, PDO::PARAM_INT);
    return $stmt->execute();
}



