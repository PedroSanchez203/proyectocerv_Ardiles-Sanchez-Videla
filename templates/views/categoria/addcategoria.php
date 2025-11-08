<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Mostrar notificaciones toast -->
<?= Toast::flash() ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <?= $data['page_title'] ?? 'Nueva Categoría' ?>
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= URL ?>categoria/store">
                    <!-- Nombre de la categoría -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                               placeholder="Ej: Trabajo, Personal, Estudio..." required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion"
                                  rows="3" placeholder="Detalles o propósito de esta categoría (opcional)"></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= URL ?>todo" class="btn btn-outline-secondary me-md-2">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Guardar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>
