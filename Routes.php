<?php 

use App\Core\Route;

return [
    Route::get("|^radnja/([0-9]+)/?$|", "Radnje", "get"),


    Route::any("|^.*$|", "Main", "home")
];