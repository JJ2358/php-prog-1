<?php

declare(strict_types=1);

session_start();

// Include app
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'App.php';

// Retrieve filter values from GET parameters
$status = $_GET['status'] ?? 'any'; // 'any' as default value if not specified
$onSale = isset($_GET['on_sale']) ? 1 : 0; // Check if 'on_sale' checkbox is checked

// Fetch filtered products based on the filters
$products = getFilteredProducts($status, $onSale); // Use your filtering function

// Pass products to the view
require VIEWS_PATH . 'home.php';
