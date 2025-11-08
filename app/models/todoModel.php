<?php

class todoModel extends Model {
    
    protected $table = 'todos';
    protected $fillable = ['task', 'description', 'priority', 'completed', 'id_categoria'];

    public static function getAllWithDetails() {
        $db = Db::getInstance(); 
        $sql = "
            SELECT 
                t.*, 
                c.nombre AS categoria_nombre
            FROM todos t
            LEFT JOIN categoria c ON t.id_categoria = c.id
            ORDER BY t.created_at DESC
        ";
        $result = $db->query($sql);
        $todos = $result->fetchAll();

        foreach ($todos as &$todo) {
            $todo['priority_text'] = Todo::getPriorityText($todo['priority']);
            $todo['priority_color'] = Todo::getPriorityColor($todo['priority']);
            $todo['formatted_date'] = date('d/m/Y H:i', strtotime($todo['created_at']));
        }

        return $todos;
    }

    public static function getCompleted() {
        $db = Db::getInstance();
        $result = $db->query("SELECT * FROM todos WHERE completed = 1 ORDER BY updated_at DESC");
        return $result->fetchAll();
    }

    public static function getPending() {
        $db = Db::getInstance();
        $result = $db->query("SELECT * FROM todos WHERE completed = 0 ORDER BY priority DESC, created_at ASC");
        return $result->fetchAll();
    }

    public static function search($search) {
        $db = Db::getInstance();
        $sql = "
            SELECT 
                t.*, 
                c.nombre AS categoria_nombre
            FROM todos t
            LEFT JOIN categoria c ON t.id_categoria = c.id
            WHERE 
                t.task LIKE ? 
                OR t.description LIKE ? 
                OR c.nombre LIKE ?
            ORDER BY t.created_at DESC
        ";

        $result = $db->query($sql, [
            "%{$search}%",
            "%{$search}%",
            "%{$search}%"
        ]);

        $todos = $result->fetchAll();

        foreach ($todos as &$todo) {
            $todo['priority_text'] = Todo::getPriorityText($todo['priority']);
            $todo['priority_color'] = Todo::getPriorityColor($todo['priority']);
            $todo['formatted_date'] = date('d/m/Y H:i', strtotime($todo['created_at']));
        }

        return $todos;
    }
}
?>
