<?php

// Clase Redirect: Maneja redirecciones HTTP de forma robusta
// Soluciona problemas comunes como headers ya enviados y URLs externas
class Redirect {
    
    // Propiedad privada para almacenar la URL de destino
    private $location;
    
    /**
     * Método estático para redirigir al usuario a una sección determinada
     * @param string $location URL de destino (relativa o absoluta)
     * @return void
     */
    public static function to($location) {
        // Crear instancia de la clase para acceder a propiedades
        $self = new self();
        $self->location = $location;
        
        // PROBLEMA 1: Headers ya enviados
        // Si PHP ya envió headers al navegador, no podemos usar header('Location:')
        // Si se redirecciona a una url cuando ya se enviaron headers, no se redirecciona a la pagina deseada
        
        // headers_sent(): función nativa de PHP que verifica si ya se enviaron headers HTTP
        if (headers_sent()) {
            
            // Redirección con JavaScript (funciona en navegadores modernos)
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.URL.$self->location.'";';
            echo '</script>';
            
            // Respaldo para navegadores sin JavaScript
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.URL.$self->location.'" />';
            echo '</noscript>';
            
            die(); // Terminar ejecución después de la redirección
        }
        
        // PROBLEMA 2: URLs externas vs internas
        // Las URLs externas necesitan el protocolo completo (http/https)
        // Las URLs internas se construyen con la constante URL
        // Si se redirecciona a una url externa puede suceder que el usuario se vaya a otra pagina y no se redireccione a la pagina deseada
        
        // strpos(): función nativa de PHP que busca la posición de una subcadena en una cadena

        if (strpos($self->location, 'http') !== false) {
            // URL externa: usar tal como está
            header('Location: '.$self->location);
        } else {
            // URL interna: construir con la URL base del sitio
            header('Location: '.URL.$self->location);
        }
        
        die(); // Terminar ejecución después de la redirección

        // Redirigir al usuaario a otra seccion
        header('Location: '.URL.$self->location);
        die();
    }
}
