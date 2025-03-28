<?php

namespace App\Core;

class Controller{
    private $conn;
    private $data = [];

    final public function __construct(DatabaseConnection $conn) {
        $this->conn = $conn;
    }

    public function getDatabaseConnection(){
        return $this->conn;
    }

    final protected function setData(string $name, $value): bool{
        $result = false;
        if (preg_match('|^[a-z][a-zA-Z0-9]*$|', $name)) {
            $this->data[$name] = $value;
            $result = true;
        }
        return $result;
    }

    final public function getData(): array{
        return $this->data;
    }

}