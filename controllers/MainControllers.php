<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\RadnjaModel;

class MainControllers extends Controller{

    public function home() {
        $radnjaModel = new RadnjaModel($this->getDatabaseConnection());
        $radnje = $radnjaModel->getAll();
        $this->setData("radnje", $radnje);
    }

}