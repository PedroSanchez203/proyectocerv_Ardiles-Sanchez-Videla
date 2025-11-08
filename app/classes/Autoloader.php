<?php

// Clase Autoloader: Maneja la carga automática de clases en el sistema MVC
class Autoloader {
    
    // Inicializar y registrar el autoloader
    public static function init() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    // Cargar automáticamente las clases según su tipo
    private static function autoload($class_name) {
        
        // Buscar en clases principales
        if (is_file(CLASSES . $class_name . '.php')) {
            require_once CLASSES . $class_name . '.php';
        }
        // Buscar en controladores
        elseif (is_file(CONTROLLERS . $class_name . '.php')) {
            require_once CONTROLLERS . $class_name . '.php';
        }
        // Buscar en modelos (manejar tanto 'Model' como 'todoModel')
        elseif (is_file(MODELS . $class_name . '.php')) {
            require_once MODELS . $class_name . '.php';
        }
        // Buscar modelos con sufijo 'Model' (para casos como 'todo' -> 'todoModel')
        elseif (is_file(MODELS . $class_name . 'Model.php')) {
            require_once MODELS . $class_name . 'Model.php';
        }
        else {
            die(sprintf('No existe la clase "%s" en nuestro sistema.', $class_name));
        }
        
        return;
    }
}