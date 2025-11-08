<?php if (!empty($categorias)): ?>
    <ul class="list-group list-group-flush">
        <?php foreach ($categorias as $cat): ?>
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
