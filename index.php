<?php
require_once 'DataBaseConfiguration.php';
require_once 'DatabaseConnection.php';

// 1. Kreiraj objekat klase DataBaseConfiguration sa podacima za bazu
$dbConfig = new DataBaseConfiguration('localhost', 'popis_bg', 'root', '');

// 2. Kreiraj instancu DatabaseConnection koristeći getInstance
$dbConnection = DatabaseConnection::getInstance($dbConfig);

// 3. Dobij PDO konekciju
$prep = $dbConnection->getConnection()->prepare('SELECT * FROM artikli');

$res = $prep->execute();

if ($res) {
    $artikli = $prep->fetchAll(PDO::FETCH_ASSOC);
}
var_dump($artikli);