<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Mostrar notificaciones toast -->
<?= Toast::flash() ?>

<div class="row">

    <!-- LISTA DE TAREAS -->
    <div class="col-md-8">
        <h1 class="d-flex justify-content-between align-items-center">
            <?= $data['page_title'] ?? 'Mi Lista de Tareas' ?>
            <a href="<?= URL ?>todo/add" class="btn btn-primary d-flex justify-content-between align-items-center">
                Nueva Tarea
            </a>
        </h1>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <form method="GET" action="<?= URL ?>todo/search" class="d-flex">
                <input type="text" class="form-control me-2" name="q"
                    placeholder="Buscar tareas..." value="<?= $data['search_term'] ?? '' ?>">
                <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            </form>
        </div>

        <!-- Lista de tareas -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tareas</h5>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($data['todos'])): ?>
                    <?php foreach ($data['todos'] as $todo): ?>
                        <div class="todo-item p-3 border-bottom <?= $todo['completed'] ? 'completed-task' : '' ?>">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2 <?= $todo['completed'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                            <?= htmlspecialchars($todo['task']) ?>
                                        </h6>
                                        <span class="badge priority-badge bg-<?= $todo['priority_color'] ?>">
                                            <?= $todo['priority_text'] ?>
                                        </span>
                                    </div>

                                    <?php if ($todo['description']): ?>
                                        <p class="text-muted mb-2 small">
                                            <?= htmlspecialchars($todo['description']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($todo['categoria_nombre'])): ?>
                                        <p class="fs-6 fw-bold ">
                                            <span class="border border-primary rounded px-3 py-1 text-primary">
                                                <?= htmlspecialchars($todo['categoria_nombre']) ?>
                                            </span>
                                        </p>
                                    <?php endif; ?>

                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?= URL ?>todo/edit?id=<?= $todo['id'] ?>"
                                        class="btn btn-sm btn-outline-secondary">
                                        Editar
                                    </a>
                                    <a href="#"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#BorrarModal"
                                        data-todo-id="<?= $todo['id'] ?>">
                                        Eliminar
                                    </a>
                                    <a href="<?= URL ?>todo/toggle?id=<?= $todo['id'] ?>"
                                        class="btn btn-sm d-flex align-items-center gap-1 <?= $todo['completed'] ? 'btn-outline-success' : 'btn-success' ?>">
                                        <?php if ($todo['completed']): ?>
                                            <i class="bi bi-check-circle"></i> Completada
                                        <?php else: ?>
                                            <i class="bi bi-circle"></i> Completar
                                        <?php endif; ?>
                                    </a>

                                    <a href="<?= URL ?>todo/toggleFavorito?id=<?= $todo['id'] ?>"
                                        class="btn btn-sm d-flex align-items-center gap-1 <?= $todo['Favorite'] ? 'btn-dark' : 'btn-outline-dark' ?>">
                                        <i class="bi"></i> Favorito
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5>No hay tareas</h5>
                        <p>
                            <?php if (isset($data['search_term'])): ?>
                                No se encontraron tareas para "<?= htmlspecialchars($data['search_term']) ?>"
                            <?php else: ?>
                                Â¡Agrega tu primera tarea!
                            <?php endif; ?>
                        </p>
                        <a href="<?= URL ?>todo/add" class="btn btn-primary">
                            Nueva Tarea
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- PANEL LATERAL CON CATEGORÍAS -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3 d-flex justify-content-between align-items-center">
                    Categorías
                    <a href="<?= URL ?>categoria/add" class="btn btn-sm btn-primary">
                        Nueva
                    </a>
                </h5>

                <?php if (!empty($data['categorias'])): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($data['categorias'] as $cat): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= htmlspecialchars($cat['nombre']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($cat['descripcion']) ?></small>
                                    <?php if (!empty($cat['tarea_nombre'])): ?>
                                        <div class="small text-muted">📝 <?= htmlspecialchars($cat['tarea_nombre']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="btn-group">
                                    <a href="<?= URL ?>categoria/edit?id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#BorrarCategoriaModal"
                                        data-categoria-id="<?= $cat['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center my-4">No hay categorías creadas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación de tarea -->
<div class="modal fade" id="BorrarModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="deleteModalLabel">¿Seguro de eliminar?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                Si das en <strong>"Eliminar"</strong> no se puede deshacer.<br>
                ¿Estás seguro de eliminar esta tarea?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="ConfirmarBorradoModal" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación de categoría -->
<div class="modal fade" id="BorrarCategoriaModal" tabindex="-1" aria-labelledby="deleteCatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="deleteCatModalLabel">¿Seguro de eliminar la categoría?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                Si das en <strong>"Eliminar"</strong> no se puede deshacer.<br>
                ¿Estás seguro de eliminar esta categoría?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="ConfirmarBorradoCategoria" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const BorrarModal = document.getElementById('BorrarModal');
        const ConfirmarBorradoModal = document.getElementById('ConfirmarBorradoModal');
        const BorrarCategoriaModal = document.getElementById('BorrarCategoriaModal');
        const ConfirmarBorradoCategoria = document.getElementById('ConfirmarBorradoCategoria');

        // Modal de tareas
        BorrarModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const todoId = button.getAttribute('data-todo-id');
            ConfirmarBorradoModal.href = "<?= URL ?>todo/delete?id=" + todoId;
        });

        // Modal de categorías
        BorrarCategoriaModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const catId = button.getAttribute('data-categoria-id');
            ConfirmarBorradoCategoria.href = "<?= URL ?>categoria/delete?id=" + catId;
        });
    });
</script>

<?php require_once INCLUDES . 'inc_footer.php'; ?>