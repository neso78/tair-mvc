<?php
namespace App\Core;
class DataBaseConfiguration {
    private $host;
    private $db_name;
    private $username;
    private $password;

    // Konstruktor klase koji prima parametre
    public function __construct($host, $db_name, $username, $password) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
    }

    // Metoda za vraćanje DSN (Data Source Name)
    public function getSource() {
        return "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
    }

    // Metoda za vraćanje korisničkog imena
    public function getUser() {
        return $this->username;
    }

    // Metoda za vraćanje lozinke
    public function getPass() {
        return $this->password;
    }
}
?>
