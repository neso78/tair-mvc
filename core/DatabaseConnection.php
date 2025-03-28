<?php
namespace App\Core;
class DatabaseConnection {
    private static $instance = null;  // Singleton instanca
    private $conn;                    // PDO objekat za konekciju
    private $dbConfig;                // Objekat DataBaseConfiguration

    // Privatni konstruktor koji prima DataBaseConfiguration objekat
    private function __construct(DataBaseConfiguration $dbConfig) {
        $this->dbConfig = $dbConfig;
        $this->connect();
    }

    // Privatna metoda za uspostavljanje konekcije
    private function connect() {
        try {
            // Povezivanje sa bazom koristeći podatke iz DataBaseConfiguration
            $this->conn = new \PDO(
                $this->dbConfig->getSource(),
                $this->dbConfig->getUser(),
                $this->dbConfig->getPass()
            );
            // Postavi UTF-8 kao podrazumevani karakter set
            $this->conn->exec("set names utf8");
        } catch (\PDOException $exception) {
            // Ako dođe do greške, ispiši grešku u JSON formatu
            http_response_code(500); // Internal server error
            echo json_encode([
                'error' => true,
                'message' => 'Connection error: ' . $exception->getMessage()
            ]);
            exit; // Prekini dalji rad skripte
        }
    }

    // Metoda koja vraća jedinstvenu instancu DatabaseConnection
    public static function getInstance(DataBaseConfiguration $dbConfig) {
        // Ako instanca ne postoji, kreiraj je
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection($dbConfig);
        }
        // Vratimo jedinstvenu instancu
        return self::$instance;
    }

    // Metoda za dobijanje PDO konekcije
    public function getConnection() {
        return $this->conn;
    }

    // Sprečava kopiranje objekta (cloniranje)
    private function __clone() {}

}
?>
