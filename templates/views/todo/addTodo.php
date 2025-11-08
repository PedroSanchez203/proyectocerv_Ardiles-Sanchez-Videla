<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Mostrar notificaciones toast -->
<?= Toast::flash() ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <?= $data['page_title'] ?? 'Nueva Tarea' ?>
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= URL ?>todo/store">
                    <div class="mb-3">
                        <label for="task" class="form-label">Tarea *</label>
                        <input type="text" class="form-control" id="task" name="task"
                            placeholder="¿Qué necesitas hacer?" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3" placeholder="Detalles adicionales (opcional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioridad</label>
                        <select class="form-select" id="priority" name="priority">
                            <option value="low">🟢 Baja</option>
                            <option value="medium" selected>🟡 Media</option>
                            <option value="high">🔴 Alta</option>
                        </select>
                    </div>

                     <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria_id" name="categoria_id">
                            <option value="">-- Sin categoría --</option>
                            <?php if (!empty($data['categorias'])): ?>
                                <?php foreach ($data['categorias'] as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= htmlspecialchars($cat['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>No hay categorías creadas</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= URL ?>todo" class="btn btn-outline-secondary me-md-2">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Guardar Tarea
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>