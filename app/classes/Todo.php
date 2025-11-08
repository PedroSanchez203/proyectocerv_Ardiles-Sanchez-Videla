<?php

// Clase helper para funcionalidades específicas del todo list
class Todo {
    
    /**
     * Obtener estadísticas de tareas
     * @return array Array con estadísticas
     */
    public static function getStats() {
        $db = Db::getInstance(); 
        $result = $db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN completed = 0 THEN 1 ELSE 0 END) as pending
            FROM todos
        ");
        return $result->fetch();
    }
    
    /**
     * Obtener tareas por prioridad
     * @param string $priority Prioridad (low, medium, high)
     * @return array Array de tareas
     */
    public static function getByPriority($priority) {
        $db = Db::getInstance(); 
        $result = $db->query("SELECT * FROM todos WHERE priority = ? ORDER BY created_at DESC", [$priority]);
        return $result->fetchAll();
    }
    
    /**
     * Cambiar el estado de completado de una tarea
     * @param int $id ID de la tarea
     * @return bool True si se cambió exitosamente
     */
    public static function toggleStatus($id) {
        $db = Db::getInstance();
        $db->query("UPDATE todos SET completed = NOT completed WHERE id = ?", [$id]);
        return true;
    }

    /**
     * Cambiar el estado de favorito
     * @param int $id ID de la tarea
     * @return bool True si se cambió exitosamente
     */
    public static function FavoriteStatus($id) {
        $db = Db::getInstance(); 
        $db->query("UPDATE todos SET Favorite = NOT Favorite WHERE id = ?", [$id]);
        return true;
    }
    
    /**
     * Obtener el texto de prioridad en español
     * @param string $priority Prioridad en inglés
     * @return string Prioridad en español
     */
    public static function getPriorityText($priority) {
        $priorities = [
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta'
        ];
        return $priorities[$priority] ?? 'Media';
    }
    
    /**
     * Obtener el color de Bootstrap para la prioridad
     * @param string $priority Prioridad
     * @return string Clase CSS de Bootstrap
     */
    public static function getPriorityColor($priority) {
        $colors = [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger'
        ];
        return $colors[$priority] ?? 'secondary';
    }
}
?>
