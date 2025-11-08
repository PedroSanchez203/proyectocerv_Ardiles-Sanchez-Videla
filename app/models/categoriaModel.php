<?php

class categoriaModel extends Model
{
    protected $table = 'categoria';
    protected $fillable = ['nombre', 'descripcion', 'id_todos'];

    /**
     * Obtener todas las categorías con el nombre de la tarea asociada
     * @return array
     */
    public static function getAllWithDetails()
    {
        $db = Db::getInstance();
        $sql = "
            SELECT 
                c.*, 
                t.task AS tarea_nombre
            FROM categoria c
            LEFT JOIN todos t ON c.id_todos = t.id
            ORDER BY c.id DESC
        ";
        $result = $db->query($sql);
        return $result->fetchAll();
    }

    /**
     * Buscar una categoría por su ID
     * @param int $id
     * @return array|null
     */
    public static function getById($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM categoria WHERE id = ?";
        $result = $db->query($sql, [$id]);
        return $result->fetch();
    }

    /**
     * Guardar una nueva categoría
     * @param string $nombre
     * @param string $descripcion
     * @param int|null $id_todos
     */
    public static function createCategoria($nombre, $descripcion, $id_todos = null)
    {
        $db = Db::getInstance();
        $sql = "INSERT INTO categoria (nombre, descripcion, id_todos, created_at) VALUES (?, ?, ?, NOW())";
        $db->query($sql, [$nombre, $descripcion, $id_todos]);
    }

    /**
     * Actualizar una categoría existente
     */
    public static function updateCategoria($id, $nombre, $descripcion, $id_todos)
    {
        $db = Db::getInstance();
        $sql = "UPDATE categoria SET nombre = ?, descripcion = ?, id_todos = ? WHERE id = ?";
        $db->query($sql, [$nombre, $descripcion, $id_todos, $id]);
    }

    /**
     * Eliminar una categoría
     */
    public static function deleteCategoria($id)
    {
        $db = Db::getInstance();
        $sql = "DELETE FROM categoria WHERE id = ?";
        $db->query($sql, [$id]);
    }
}
?>
