<?php

// Controlador para manejar todas las operaciones del todo list
class todoController extends Controller {
    
    protected $title = 'Lista de Tareas';
    
    /**
     * Página principal - mostrar todas las tareas y categorías
     */
    function index() {
        $todos = todoModel::getAllWithDetails();
        $categorias = categoriaModel::getAllWithDetails();
        
        $data = [
            'todos' => $todos,
            'categorias' => $categorias,
            'page_title' => 'Mi Lista de Tareas'
        ];
        
        View::render('todolist', $data);
    }
    
    /**
     * Mostrar formulario para agregar nueva tarea
     */
    function add() {
        $categorias = categoriaModel::getAllWithDetails();

        $data = [
            'page_title' => 'Agregar Nueva Tarea',
            'categorias' => $categorias
        ];

        View::render('addTodo', $data);
    }
    
    /**
     * Guardar una nueva tarea
     */
    function store() {
        if (!$this->validatePost(['task'])) {
            $this->redirectWithMessage('todo/add', 'Debe ingresar una tarea', 'warning');
            return;
        }

        $todoData = [
            'task' => trim($_POST['task']),
            'description' => trim($_POST['description'] ?? ''),
            'id_categoria' => !empty($_POST['categoria_id']) ? $_POST['categoria_id'] : null,
            'priority' => $_POST['priority'] ?? 'medium',
            'completed' => 0,
        ];

        todoModel::create($todoData);

        $this->redirectWithMessage('todo', 'Tarea agregada exitosamente', 'success');
    }

    /**
     * Editar tarea existente
     */
    function edit() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('todo', 'ID de tarea inválido', 'danger');
            return;
        }
        
        $id = $_GET['id'];
        $todo = todoModel::find($id);
        $categorias = categoriaModel::getAllWithDetails();

        if (!$todo) {
            $this->redirectWithMessage('todo', 'Tarea no encontrada', 'danger');
            return;
        }
        
        $data = [
            'page_title' => 'Editar Tarea',
            'todo' => $todo,
            'categorias' => $categorias
        ];
        
        View::render('editTodo', $data);
    }

    /**
     * Actualizar tarea existente
     */
    function update() {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            $this->redirectWithMessage('todo', 'ID de tarea inválido', 'danger');
            return;
        }
        
        if (!$this->validatePost(['task'])) {
            $this->redirectWithMessage('todo/edit?id=' . $_POST['id'], 'Debe ingresar una tarea', 'warning');
            return;
        }
        
        $id = $_POST['id'];
        $todo = todoModel::find($id);
        
        if (!$todo) {
            $this->redirectWithMessage('todo', 'Tarea no encontrada', 'danger');
            return;
        }
        
        $todoData = [
            'task' => trim($_POST['task']),
            'description' => trim($_POST['description'] ?? ''),
            'priority' => $_POST['priority'] ?? 'medium',
            'id_categoria' => !empty($_POST['id_categoria']) ? $_POST['id_categoria'] : null

        ];
        
        todoModel::update($id, $todoData);
        
        $this->redirectWithMessage('todo', 'Tarea actualizada exitosamente', 'success');
    }

    /**
     * Cambiar estado de una tarea (completada/pendiente)
     */
    function toggle() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('todo', 'ID de tarea inválido', 'danger');
            return;
        }
        
        $id = $_GET['id'];
        $todo = todoModel::find($id);
        
        if (!$todo) {
            $this->redirectWithMessage('todo', 'Tarea no encontrada', 'danger');
            return;
        }
        
        Todo::toggleStatus($id);
        $newStatus = $todo['completed'] ? 'pendiente' : 'completada';
        
        $this->redirectWithMessage('todo', "Tarea marcada como {$newStatus}", 'info');
    }

    /**
     * Marcar o desmarcar tarea como favorita
     */
    function toggleFavorito() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('todo', 'ID de tarea inválido', 'danger');
            return;
        }
        
        $id = $_GET['id'];
        $todo = todoModel::find($id);
        
        if (!$todo) {
            $this->redirectWithMessage('todo', 'Tarea no encontrada', 'danger');
            return;
        }
        
        Todo::FavoriteStatus($id);
        $this->redirectWithMessage('todo', "Tarea marcada como favorita", 'info');
    }

    /**
     * Eliminar una tarea
     */
    function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('todo', 'ID de tarea inválido', 'danger');
            return;
        }
        
        $id = $_GET['id'];
        $todo = todoModel::find($id);
        
        if (!$todo) {
            $this->redirectWithMessage('todo', 'Tarea no encontrada', 'danger');
            return;
        }
        
        todoModel::delete($id);
        
        $this->redirectWithMessage('todo', 'Tarea eliminada exitosamente', 'info');
    }
    
   
    /**
    * Buscar tareas (por nombre, descripción o categoría)
    */
function search() {
    $search = $_GET['q'] ?? '';
    
    if (empty($search)) {
        $this->redirectWithMessage('todo', 'Debe ingresar un término de búsqueda', 'warning');
        return;
    }
    
    $todos = todoModel::search($search);
    $categorias = categoriaModel::getAllWithDetails(); 
    
    $data = [
        'todos' => $todos,
        'categorias' => $categorias,
        'search_term' => $search,
        'page_title' => "Resultados para: {$search}"
    ];
    
    View::render('todolist', $data);
}


}
?>
