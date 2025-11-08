<?php

class indexController {
    function __construct() {
        echo "Hola desde indexController <br>";
    }
     
    function index() {
        echo "Hola desde indexController->index <br>";
        require_once VIEWS.'coreview.php'; // Carga la vista de prueba
    }
}
