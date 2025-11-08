<?php

class categoriaController extends Controller
{
    // Título de la sección
    protected $title = 'Categorías';

    /**
     * Mostrar todas las categorías
     */
    function index()
    {
        $categorias = categoriaModel::getAllWithDetails();

        $data = [
            'categorias' => $categorias,
            'page_title' => 'Listado de Categorías'
        ];

        View::render('categoria/index', $data);

    }

    /**
     * Mostrar formulario para agregar nueva categoría
     */
    function add()
    {
        $tarea = todoModel::getAllWithDetails();

        $data = [
            'page_title' => 'Agregar Nueva Categoría',
            'tareas' => $tarea
        ];

        View::render('addCategoria', $data);
        
    }

    /**
     * Procesar formulario de nueva categoría
     */
    function store()
    {
        // Validar datos requeridos
        if (!$this->validatePost(['nombre'])) {
            $this->redirectWithMessage('categoria/add', 'Debe ingresar un nombre para la categoría', 'warning');
            return;
        }

        // Datos del formulario
        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $id_todos = $_POST['id_todos'] ?? null;

        // Crear categoría
        categoriaModel::createCategoria($nombre, $descripcion, $id_todos);

        $this->redirectWithMessage('todo', 'Categoría creada exitosamente', 'success');
    }

    /**
     * Mostrar formulario de edición
     */
    function edit()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('categoria', 'ID de categoría inválido', 'danger');
            return;
        }

        $id = $_GET['id'];
        $categoria = categoriaModel::getById($id);

        if (!$categoria) {
            $this->redirectWithMessage('categoria', 'Categoría no encontrada', 'danger');
            return;
        }

        $tareas = categoriaModel::getAllWithDetails();

        $data = [
            'page_title' => 'Editar Categoría',
            'categoria' => $categoria,
            'tareas' => $tareas
        ];

        View::render('editCategoria', $data);
    }

    /**
     * Procesar actualización de categoría
     */
    function update()
    {
        if (!$this->validatePost(['id', 'nombre'])) {
            $this->redirectWithMessage('categoria', 'Datos inválidos para actualizar', 'danger');
            return;
        }

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $id_todos = $_POST['id_todos'] ?? null;

        categoriaModel::updateCategoria($id, $nombre, $descripcion, $id_todos);

        $this->redirectWithMessage('todo', 'Categoría actualizada correctamente', 'success');
    }

    /**
     * Eliminar una categoría
     */
    function delete()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('categoria', 'ID de categoría inválido', 'danger');
            return;
        }

        $id = $_GET['id'];

        $categoria = categoriaModel::getById($id);
        if (!$categoria) {
            $this->redirectWithMessage('categoria', 'Categoría no encontrada', 'danger');
            return;
        }

        categoriaModel::deleteCategoria($id);

        $this->redirectWithMessage('todo', 'Categoría eliminada exitosamente', 'info');
    }
}
?>
