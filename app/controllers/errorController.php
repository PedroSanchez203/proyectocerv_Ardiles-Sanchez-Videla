<?php

class errorController {
    function __construct() {
        // echo "ErrorController";
    }
     
    function index() {
       
    $data =
    [
        'titulo' => 'Error 404 Página no encontrada',
    ];

    View::render('404', $data);
    }
}