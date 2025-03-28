<?php
namespace App\Models;

use App\Core\DatabaseConnection;

class StatusservisaModel {
    private $conn;  // \PDO objekat za konekciju
    private $id;
    private $naziv;

    // Konstruktor prima DatabaseConnection objekat
    public function __construct(DatabaseConnection $dbConnection) {
        // Spremamo \PDO konekciju
        $this->conn = $dbConnection->getConnection();
    }

    // Metoda za postavljanje ID-a
    public function setId($id) {
        $this->id = $id;
    }

    // Metoda za postavljanje Naziva
    public function setNaziv($naziv) {
        $this->naziv = $naziv;
    }


    public function getAll(): array {
        $query = "SELECT * FROM status_servisa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Uzimamo sve rezultate kao objekat
        $statusServisa = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // Kreiramo niz objekata RadnjaModel
        $radnje = [];

        foreach ($statusServisa as $statusServisaDataItem) {
            $this->setId($statusServisaDataItem->id);
            $this->naziv = $statusServisaDataItem->naziv;          
            // Dodajemo objekat u niz
            $radnje[] = $this;
        }

        return $radnje;
    }

    // Metoda za dobijanje podataka o statusu servisa prema ID-u
    public function getById($id): mixed {
        // Postavi ID
        $this->setId($id);

        // Pripremi SQL upit za dobijanje podataka
        $query = "SELECT * FROM status_servisa WHERE id = :id";

        // Pripremi \PDO upit
        $stmt = $this->conn->prepare($query);

        // Bind parametar :id na vrednost $id
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        // Izvrši upit
        $stmt->execute();

        $status = $stmt->fetch(\PDO::FETCH_OBJ);

        // Ako je pronađena status servis, vrati objekat klase StatusservisaModel
        if ($stmt) {
            $this->setId($status->id);
            $this->naziv = $status->naziv;
            return $this;
        }

        // Ako status servis nije pronađen, vraća null
        return null;
    }

    // Metoda za dobijanje podataka o statusu servisa prema nazivu (pretraga)
    public function getByNaziv($naziv): mixed {
        // Postavi naziv
        $this->setNaziv($naziv);

        // Pripremi SQL upit za dobijanje podataka prema nazivu
        $query = "SELECT * FROM status_servisa WHERE naziv LIKE :naziv";

        // Pripremi \PDO upit
        $stmt = $this->conn->prepare($query);

        // Bind parametar :naziv na vrednost $naziv
        $naziv = "%" . $this->naziv . "%"; // dodajemo % za delimično podudaranje
        $stmt->bindParam(':naziv', $naziv, \PDO::PARAM_STR);

        // Izvrši upit
        $stmt->execute();

        // Ako je pronađen status servis, vrati objekat klase StatusservisaModel
        if ($stmt) {
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        // Ako status servis nije pronađen, vraća null
        return null;
    }

    // Getter za ID
    public function getId() {
        return $this->id;
    }

    // Getter za naziv
    public function getNaziv() {
        return $this->naziv;
    }
}
?>
