<?php
namespace App\Models;

use App\Core\DatabaseConnection;
class RadnjaModel {
    private $conn;  // PDO objekat za konekciju
    private $id;
    private $naziv;
    private $adresa;
    private $telefon;

    // Konstruktor prima DatabaseConnection objekat
    public function __construct(DatabaseConnection $dbConnection) {
        // Spremamo PDO konekciju
        $this->conn = $dbConnection->getConnection();
    }

    // Metoda za postavljanje ID-a
    public function setId($id) {
        $this->id = $id;
    }

    // Metoda za dobijanje podataka o radnji prema ID-u
    public function getById($id): mixed {
        // Postavi ID
        $this->setId($id);

        // Pripremi SQL upit za dobijanje podataka
        $query = "SELECT * FROM radnje WHERE id = :id";

        // Pripremi PDO upit
        $stmt = $this->conn->prepare($query);

        // Bind parametar :id na vrednost $id
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        // Izvrši upit
        $stmt->execute();

        // Ako je pronađena radnja, ažuriraj trenutni objekat sa podacima
        $radnjaData = $stmt->fetch(\PDO::FETCH_OBJ);
        
        if ($radnjaData) {
            // Ažuriraj trenutni objekat sa podacima
            $this->id = $radnjaData->id;
            $this->naziv = $radnjaData->naziv;
            $this->adresa = $radnjaData->adresa;
            $this->telefon = $radnjaData->telefon;
            
            // Vratimo trenutni objekat sa ažuriranim podacima
            return $this;
        }

        // Ako radnja nije pronađena, vraća null
        return null;
    }

     // Metoda za dobijanje svih radnji
     public function getAll(): array {
        $query = "SELECT * FROM radnje";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Uzimamo sve rezultate kao objekat
        $radnjeData = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // Kreiramo niz objekata RadnjaModel
        $radnje = [];

        foreach ($radnjeData as $radnjaDataItem) {
            $this->setId($radnjaDataItem->id);
            $this->naziv = $radnjaDataItem->naziv;
            $this->adresa = $radnjaDataItem->adresa;
            $this->telefon = $radnjaDataItem->telefon;
            
            // Dodajemo objekat u niz
            $radnje[] = $this;
        }

        return $radnje;
    }

        // Metoda za dobijanje radnje prema nazivu (pretraga)
        public function getByName($naziv): array {
            // Pripremi SQL upit za pretragu po nazivu
            $query = "SELECT * FROM radnje WHERE naziv LIKE :naziv";
            $stmt = $this->conn->prepare($query);
    
            // Bind parametar :naziv sa vrednošću unetog naziva, sa % za delimično podudaranje
            $naziv = "%" . $naziv . "%"; // dodajemo % na početak i kraj za delimično podudaranje
            $stmt->bindParam(':naziv', $naziv, \PDO::PARAM_STR);
    
            // Izvrši upit
            $stmt->execute();
    
            // Uzimamo sve rezultate kao objekat
            $radnjeData = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            // Kreiramo niz objekata RadnjaModel
            $radnje = [];
    
            foreach ($radnjeData as $radnjaDataItem) {
                $this->setId($radnjaDataItem->id);
                $this->naziv = $radnjaDataItem->naziv;
                $this->adresa = $radnjaDataItem->adresa;
                $this->telefon = $radnjaDataItem->telefon;
                $radnje[] = $this;
            }
    
            return $radnje;
        }

    // Metode za dobijanje vrednosti pojedinih polja (getter)
    public function getNaziv() {
        return $this->naziv;
    }

    public function getAdresa() {
        return $this->adresa;
    }

    public function getTelefon() {
        return $this->telefon;
    }

    // Getter za ID
    public function getId() {
        return $this->id;
    }
}
?>
