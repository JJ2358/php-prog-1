<?php

// path to the root of the project
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);
define('UPLOADS_DIR', $root . 'public' . DIRECTORY_SEPARATOR . 'uploads');

//database constants
define('DB_HOST', 'mysql-server');
define('DB_USER', 'root');
define('DB_PASS', 'secret');
define('DB_NAME', 'customers');
