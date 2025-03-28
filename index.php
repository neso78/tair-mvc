<?php

require_once 'vendor/autoload.php';

use App\Core\DataBaseConfiguration;
use App\Core\DatabaseConnection;
use App\Models\RadnjaModel;
use App\Models\StatusservisaModel;

// 1. Kreiraj objekat klase DataBaseConfiguration sa podacima za bazu
$dbConfig = new DataBaseConfiguration('localhost', 'servis_app', 'root', '');


$dbConnection = DatabaseConnection::getInstance($dbConfig);

$radnja = new RadnjaModel($dbConnection);

$status = new StatusservisaModel( $dbConnection);

var_dump($status->getAll());  