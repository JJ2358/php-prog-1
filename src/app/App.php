<?php

declare(strict_types=1);

$config = require_once 'Config.php';


// **************** MySQLi *******************************

function getConnectionMySQLi(): mysqli
{
    //create connection
    try {
        $db = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );
        return $db;
    } catch (Exception $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

function getCustomersMySQLi(): array
{
    //get connection
    $db = getConnectionMySQLi();

    //create query
    $stmt = $db->prepare('SELECT * FROM tblCustomer');
    //execute query
    $stmt->execute();
    //get results
    $result = $stmt->get_result();

    $customers = [];

    //loop through results and add to customers array
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    return $customers;
}

// **************** PDO *******************************

function getConnectionPDO(): PDO
{
    // construct dsn
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

    // options for PDO - set default fetch mode to assoc
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    return $pdo;
}

function getCustomersPDO(): array
{
    //get connection
    $db = getConnectionPDO();

    //create query
    $stmt = $db->query('SELECT * FROM tblCustomer');

    $customers = [];

    //loop through results and add to customers array
    while ($row = $stmt->fetch()) {
        $customers[] = $row;
    }

    return $customers;
}

function getCustomerPDO(int $id): array|bool
{
    //get connection
    $db = getConnectionPDO();

    //create query
    $stmt = $db->prepare('SELECT * FROM tblCustomer WHERE customerId=?');

    //execute query
    $stmt->execute([$id]);

    //get results
    $result = $stmt->fetch();

    return $result;
}

function insertCustomerPDO(array $data): bool
{
    //get connection
    $db = getConnectionPDO();

    // method one
    // $stmt = $db->prepare("
    // INSERT INTO tblCustomer (lastName, firstName, address, city, province, postal, phone)
    // VALUES (?, ?, ?, ?, ?, ?, ?)");

    // return $stmt->execute($data);

    // method two
    $stmt = $db->prepare("
    INSERT INTO tblCustomer (lastName, firstName, address, city, province, postal, phone, photo)
    VALUES (:lastName, :firstName, :address, :city, :province, :postal, :phone, :photo)");

    $stmt->bindValue(':lastName', $data['lastName']);
    $stmt->bindValue(':firstName', $data['firstName']);
    $stmt->bindValue(':address', $data['address']);
    $stmt->bindValue(':city', $data['city']);
    $stmt->bindValue(':province', $data['province']);
    $stmt->bindValue(':postal', $data['postal']);
    $stmt->bindValue(':phone', $data['phone']);
    $stmt->bindValue(':photo', $data['photo']);

    return $stmt->execute();
}

function updateCustomerPDO(int $id, array $data): bool
{
    // unset submit button
    unset($data['submit']);

    //get connection
    $db = getConnectionPDO();

    // add customer id to data array
    $data['customerId'] = $id;

    //construct set string
    $set = "SET lastName=:lastName, firstName=:firstName, address=:address, city=:city, province=:province, postal=:postal, phone=:phone";

    // if photo provided, add to set string
    if (!empty($data['photo'])) {
        $set .= ', photo=:photo';
    }

    $stmt = $db->prepare("
        UPDATE tblCustomer
        $set
        WHERE customerId=:customerId");

    return $stmt->execute($data);

    // return $stmt->execute([$data['lastName'], $data['firstName'], $data['address'], $data['city'], $data['province'], $data['postal'], $data['phone'], $data['photo'], $id]);
}

function deleteCustomerPDO(int $id): bool
{
    //get connection
    $db = getConnectionPDO();

    $stmt = $db->prepare("DELETE FROM tblCustomer WHERE customerId=?");

    $_SESSION['message'] = "Customer <i>$id</i> deleted successfully";

    return $stmt->execute([$id]);
}

function getSessionMessage(): bool|string
{
    $message = '';

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }

    return $message;
}
