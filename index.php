<?php
require_once"configuration.php";
require_once 'vendor/autoload.php';

use App\Controllers\MainControllers;
use App\Core\DataBaseConfiguration;
use App\Core\DatabaseConnection;
use App\Core\Router;

$dbConfig = new DataBaseConfiguration(
    Configuration::DATABASE_HOST,
    Configuration::DATABASE_NAME,
    Configuration::DATABASE_USER,
    Configuration::DATABASE_PASS,
    );

$dbConnection = DatabaseConnection::getInstance($dbConfig);

$url = filter_input(INPUT_GET,'URL', FILTER_SANITIZE_URL);
$url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); // Sprečava XSS
$httpMetod = filter_input(INPUT_SERVER,'REQUEST_METHOD', FILTER_SANITIZE_URL);

$router = new Router();
$routes = require_once'Routes.php';
foreach ($routes as $route) {
    $router->add($route);
}
$route = $router->find($httpMetod, $url);
$arguments = $route->extractsArguments($url);
print_r($route);
print_r($arguments);
die('');

$controller = new MainControllers($dbConnection );
$controller->home();
$data = $controller->getData();

foreach ($data as $key => $value) {
    $$key = $value;
}


require_once'views/Main/home.php';