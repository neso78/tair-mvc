<?php

require_once 'vendor/autoload.php';

use App\Controllers\MainControllers;
use App\Core\DataBaseConfiguration;
use App\Core\DatabaseConnection;

$dbConfig = new DataBaseConfiguration('localhost', 'servis_app', 'root', '');

$dbConnection = DatabaseConnection::getInstance($dbConfig);

$controller = new MainControllers($dbConnection );
$controller->home();
$data = $controller->getData();

foreach ($data as $key => $value) {
    $$key = $value;
}


require_once'views/Main/home.php';