<?php

// Configuración principal del framework
// Centraliza todas las constantes para facilitar el mantenimiento

// Detección automática de entorno (desarrollo vs producción)
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

// Zona horaria del sistema
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Idioma por defecto del sistema
define('LANG', 'es');

// Rutas base del proyecto (diferentes para local y producción)
define('BASEPATH', IS_LOCAL ? '/proyectocerv/' : '____EL BASEPATH EN PRODUCCIÓN___');


// Clave secreta para encriptación (cambiar en producción)
define('AUTH_SALT', 'CoreFramework!');


// Configuración del servidor web
define('PORT', '80');
define('URL', IS_LOCAL ? 'http://localhost/proyectocerv/' : '___URL EN PRODUCCIÓN___');

// Sistema de archivos
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd() . DS);


// Estructura de directorios MVC
define('APP', ROOT . 'app' . DS);
define('CLASSES', APP . 'classes' . DS);
define('CONFIG', APP . 'config' . DS);
define('CONTROLLERS', APP . 'controllers' . DS);
define('FUNCTIONS', APP . 'functions' . DS);
define('MODELS', APP . 'models' . DS);

// Directorios de presentación
define('TEMPLATES', ROOT . 'templates' . DS);
define('INCLUDES', TEMPLATES . 'includes' . DS);
define('MODULES', TEMPLATES . 'modules' . DS);
define('VIEWS', TEMPLATES . 'views' . DS);

// Recursos estáticos (assets)
define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('FAVICON', ASSETS . 'favicon/');
define('FONTS', ASSETS . 'fonts/');
define('IMAGES', ASSETS . 'images/');
define('JS', ASSETS . 'js/');
define('PLUGINS', ASSETS . 'plugins/');
define('UPLOADS', ASSETS . 'uploads/');

// Base de datos - Entorno local
define('LDB_ENGINE', 'mysql');
define('LDB_HOST', 'localhost');
define('LDB_NAME', 'u4_p1_db');
define('LDB_USER', 'root');
define('LDB_PASS', '');
define('LDB_CHARSET', 'utf8');

// Base de datos - Entorno producción
define('DB_ENGINE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', '___REMOTE DB___');
define('DB_USER', '___REMOTE DB___');
define('DB_PASS', '___REMOTE DB___');
define('DB_CHARSET', '___REMOTE CHARTSET___');

// Configuración del enrutador
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ERROR_CONTROLLER', 'error');
define('DEFAULT_METHOD', 'index');
