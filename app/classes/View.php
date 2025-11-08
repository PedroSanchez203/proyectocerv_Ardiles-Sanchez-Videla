<?php

// Clase View: Maneja la renderización de vistas en el sistema MVC
class View {
    
    // Método estático para renderizar vistas
    // $view: nombre de la vista a mostrar
    // $data: array con datos que se pasarán a la vista
    public static function render ($view, $data = []) {
        
        // Convertir el array asociativo en objeto para facilitar el acceso
        // Ejemplo: $producto['nombre'] se convierte en $producto->nombre
        $d = to_Object($data);

        // Verificar si existe el archivo de vista específico del controlador
        if ( is_file(VIEWS.CONTROLLER.DS.$view.'.php')) {
            // Si existe, incluir y mostrar la vista solicitada
            require_once VIEWS.CONTROLLER.DS.$view.'.php';
        } else {
            // Si no existe, mostrar la vista de error 404
            require_once VIEWS . 'error' . DS . '404View.php';
        }

    }
}