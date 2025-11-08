<?php require_once INCLUDES . 'inc_header.php'; ?>

    <div class="container">
        <h1 class="text-center mb-4">Error</h1>
        
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Oppss...</h5>
                <p class="card-text">Hubo un inconveniente.</p>
                
                <?php if (isset($d->titulo)): ?>
                    <div class="alert alert-warning">
                        <?= $d->titulo ?>
                    </div>
                <?php endif; ?>
                
                <a href="<?= URL . DEFAULT_CONTROLLER ?>" class="btn btn-primary">Volver al inicio</a>
            </div>
        </div>
    </div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>
