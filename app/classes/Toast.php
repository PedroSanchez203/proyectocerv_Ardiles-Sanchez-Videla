<?php

// Clase Toast: Maneja notificaciones toast/flash en el sistema
// 
// ¿POR QUÉ USAR SESIONES EN LUGAR DE MOSTRAR DIRECTAMENTE?
// ========================================================
// 1. NAVEGACIÓN: Cuando el usuario hace clic en un enlace o envía un formulario,
//    la página se recarga y cualquier echo/print se pierde. Las sesiones persisten.
//
// 2. REDIRECCIONES: Después de guardar datos, redirigimos al usuario a otra página.
//    Sin sesiones, el mensaje "Datos guardados" se perdería en la redirección.
//
// 3. FLASH MESSAGES: Las notificaciones se muestran UNA SOLA VEZ y luego se eliminan
//    automáticamente. Esto evita que aparezcan en cada recarga de página.
//
// 4. EXPERIENCIA DE USUARIO: El usuario ve el mensaje en la página de destino,
//    confirmando que su acción fue exitosa.
//
// FLUJO TÍPICO:
// 1. Usuario envía formulario → Controlador procesa → Toast::new() → Redirect
// 2. Usuario llega a nueva página → Vista ejecuta Toast::flash() → Mensaje visible
// 3. Usuario recarga página → Toast::flash() no encuentra mensajes → Página limpia
//
class Toast {
    
    // Tipos válidos de notificaciones (colores de Bootstrap)
    private $valid_types = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
    
    // Tipo por defecto si no se especifica
    private $default = 'primary';
    
    // Propiedades para almacenar el tipo y mensaje actual
    private $type;
    private $msg;
    
    /**
     * Método para guardar una notificación toast en la sesión
     * 
     * ¿CUÁNDO USAR ESTE MÉTODO?
     * - Después de procesar un formulario (guardar, eliminar, actualizar)
     * - Antes de hacer una redirección con Redirect::to()
     * - Cuando necesitas mostrar un mensaje en la siguiente página
     * 
     * @param string|array $msg Mensaje o array de mensajes
     * @param string $type Tipo de notificación (opcional)
     * @return bool
     */
    public static function new($msg, $type = null) {
        $self = new self();
        
        // Establecer el tipo de notificación por defecto
        if($type === null) {
            $self->type = $self->default;
        }
        
        // Validar que el tipo sea válido, sino usar el por defecto
        $self->type = in_array($type, $self->valid_types) ? $type : $self->default;
        
        // Guardar la notificación en un array de sesión
        if(is_array($msg)) {
            // Si es un array, guardar cada mensaje individualmente
            foreach ($msg as $m) {
                $_SESSION[$self->type][] = $m;
            }
            return true;
        }
        
        // Si es un string, guardarlo directamente
        $_SESSION[$self->type][] = $msg;
        return true;
    }
    
    /**
     * Renderiza las notificaciones a nuestro usuario
     * 
     * ¿CÓMO FUNCIONA LA AUTO-LIMPIEZA?
     * ================================
     * 1. Este método lee las notificaciones de $_SESSION
     * 2. Las convierte en HTML de Bootstrap
     * 3. Las elimina de $_SESSION con unset()
     * 4. Retorna el HTML para mostrar
     * 
     * ¿CUÁNDO SE AUTO-CIERRA?
     * - Al hacer clic en la X del alert
     * - Después de unos segundos (si se agrega JavaScript)
     * - Al recargar la página (porque ya no están en $_SESSION)
     * 
     * ¿DÓNDE USAR ESTE MÉTODO?
     * - En las vistas (templates) donde quieres mostrar notificaciones
     * - Normalmente al inicio del contenido principal
     * - Solo una vez por página
     *
     * @return string HTML de las notificaciones
     */
    public static function flash() {
        $self = new self();
        $output = '';
        
        // Recorrer todos los tipos de notificación válidos
        foreach ($self->valid_types as $type) {
            // Verificar si existe notificaciones de este tipo en la sesión
            if(isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
                // Recorrer cada mensaje de este tipo
                foreach ($_SESSION[$type] as $m) {
                    // Crear el HTML del alert de Bootstrap 5
                    $output .= '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">';
                    $output .= $m;
                    $output .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>';
                    $output .= '</div>';
                }
                // AUTO-LIMPIEZA: Eliminar las notificaciones de la sesión después de mostrarlas
                // Esto asegura que solo se muestren UNA VEZ y no aparezcan en recargas
                unset($_SESSION[$type]);
            }
        }
        
        return $output;
    }
}
