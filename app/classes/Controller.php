<?php

// Clase base para todos los controladores
// Proporciona funcionalidades comunes y métodos helper
class Controller {
    
    // Propiedad para datos que se pasan a las vistas
    protected $data = [];
    
    // Propiedad para el título de la página
    protected $title = 'Core Framework';
    
    /**
     * Constructor base - se ejecuta en todos los controladores
     */
    function __construct() {
        // Inicializar datos básicos
        $this->data['title'] = $this->title;
        $this->data['site_name'] = get_sitename();
    }
    
    /**
     * Helper para renderizar vistas con datos
     * @param string $view Nombre de la vista
     * @param array $data Datos adicionales (opcional)
     */
    protected function render($view, $data = []) {
        // Combinar datos del controlador con datos adicionales
        $viewData = array_merge($this->data, $data);
        View::render($view, $viewData);
    }
    
    /**
     * Helper para redirecciones con notificación
     * @param string $url URL de destino
     * @param string $message Mensaje de notificación
     * @param string $type Tipo de notificación (success, error, etc.)
     */
    protected function redirectWithMessage($url, $message, $type = 'success') {
        Toast::new($message, $type);
        Redirect::to($url);
    }
    
    /**
     * Helper para validar datos POST
     * @param array $required Campos requeridos
     * @return bool True si todos los campos están presentes
     */
    protected function validatePost($required = []) {
        foreach ($required as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                return false;
            }
        }
        return true;
    }
}
?>
