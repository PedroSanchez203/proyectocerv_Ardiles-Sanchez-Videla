<?php
class Core {
   
    // 🔹 Propiedades del framework
    private $framework = 'Core Framework';
    private $version = '1.0.0';
    private $uri = [];
   
    // 🔹 Método constructor: se ejecuta automáticamente al instanciar la clase
    public function __construct() {
        $this->init();
    }  

    /**
     * Inicializa el sistema ejecutando métodos de manera consecutiva
     *
     * @return void  No devuelve ningún valor
     */
    private function init() {
        $this->init_session();
        $this->init_load_config();
        $this->init_load_functions();
        $this->init_autoload();

        $this->dispatch();
    }
   
    /**
     * Inicia la sesión en el sistema
     *
     * @return void  No devuelve ningún valor
     */
    private function init_session() {
        // Aquí va el código para inicializar la sesión
        // Ejemplo: session_start();
    }
   
    /**
     * Carga la configuración del sistema desde un archivo
     *
     * @return void  No devuelve ningún valor
     */
    private function init_load_config() {
        $file = 'core_config.php';
        
        // Verifica que el archivo exista en la carpeta de configuración
        if(!is_file('app/config/'.$file)) {
            die(sprintf(
                'El archivo %s no se encuentra, es requerido para que %s funcione.', 
                $file, 
                $this->framework
            ));
        }
       
        // Incluye el archivo de configuración
        require_once 'app/config/'.$file;
    }

    /**
     * Carga las funciones básicas y personalizadas del sistema
     *
     * @return void  No devuelve ningún valor
     */
    private function init_load_functions() {
        $file = 'core_basic_functions.php';
        if(!is_file(FUNCTIONS.$file)) {
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }
        // Carga las funciones básicas
        require_once FUNCTIONS.$file;
    
        $file = 'core_custom_functions.php';
        if(!is_file(FUNCTIONS.$file)) {
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }
        // Carga las funciones personalizadas
        require_once FUNCTIONS.$file;
    }

    /**
     * Carga automáticamente las clases principales del framework
     *
     * @return void  No devuelve ningún valor
     */
    private function init_autoload() {
        require_once CLASSES . 'Autoloader.php';
        Autoloader::init();
        // require_once CLASSES . 'Db.php';
        // require_once CLASSES . 'Model.php';
        // require_once CLASSES . 'Controller.php';

        // require_once CLASSES . 'View.php'; // para mostrar las vistas
        
    }

    private function filter_url() {
        // Procesar la URI de la URL y convertirla en array
        if(isset($_GET['uri'])) {
            $this->uri = $_GET['uri'];
            $this->uri = rtrim($this->uri, '/'); // Eliminar diagonales finales
            $this->uri = strtolower($this->uri); // Convertir a minúsculas
            $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL); // Sanitizar URL
            $this->uri = explode('/', $this->uri); // Convertir a array
        } else {
            $this->uri = [];
        }
        
        return $this->uri;
    }
    
    private function dispatch(){
        // Procesar la URL y determinar controlador, método y parámetros
        $this->filter_url();
        
        // Determinar el controlador
        if(isset($this->uri[0])) {
            $current_controller = $this->uri[0];
            if($current_controller === 'index') {
                $current_controller = DEFAULT_CONTROLLER;
            }
            unset($this->uri[0]);
        } else {
            $current_controller = DEFAULT_CONTROLLER;
        }
        
        // Verificar que existe la clase del controlador
        $controller = $current_controller.'Controller';
        if(!class_exists($controller)) {
            $current_controller = DEFAULT_ERROR_CONTROLLER;
            $controller = DEFAULT_ERROR_CONTROLLER.'Controller';
        }
        
        // Determinar el método
        if(isset($this->uri[1])) {
            $method = str_replace('-', '_', $this->uri[1]);
            if(!method_exists($controller, $method)) {
                $controller = DEFAULT_ERROR_CONTROLLER.'Controller';
                $current_method = DEFAULT_METHOD;
                $current_controller = DEFAULT_ERROR_CONTROLLER;
            } else {
                $current_method = $method;
            }
            unset($this->uri[1]);
        } else {
            $current_method = DEFAULT_METHOD;
        }
        
        // Crear constantes globales
        define('CONTROLLER', $current_controller);
        define('METHOD', $current_method);
        
        // Instanciar y ejecutar el controlador
        $controller = new $controller;
        $params = array_values(empty($this->uri) ? [] : $this->uri);
        
        if(empty($params)) {
            call_user_func([$controller, $current_method]);
        } else {
            call_user_func_array([$controller, $current_method], $params);
        }
        
        return;
    }

    public static function run(){
        $core = new self();
        return;
    }


    }
   

?>

