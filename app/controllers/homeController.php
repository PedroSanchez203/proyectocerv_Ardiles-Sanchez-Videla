<?php

class homeController {
    function __construct() {
    }
     

    function index() {
        $data = [
            'titulo' => 'Bienvenido al Core',
            // 'bg' => 'dark',
        ];

        View::render('coreview', $data);
    }
    function test() {
        // Crear instancia de Db (la conexión se establece automáticamente)
        $db = new Db();
        
        // Probar la conexión con una consulta simple
        $result = Db::query("SELECT 1 as test");
        $test = $result->fetch();
        
        // Crear notificación toast
        Toast::new("Conexión a BD exitosa: " . $test['test'], 'success');

        $data = [
            'titulo' => 'Página de Prueba - BD',
        ];
        
        View::render('testview', $data);
    }



}