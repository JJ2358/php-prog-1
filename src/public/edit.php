<?php

declare(strict_types=1);

session_start();

// include app
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'App.php';

require VIEWS_PATH . 'add.php';
