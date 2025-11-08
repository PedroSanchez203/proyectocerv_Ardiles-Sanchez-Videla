<?php require_once INCLUDES . 'inc_header.php'; ?>

    <div class="container">
        <h1 class="text-center mb-4">Test!</h1>
        
        <!-- Mostrar notificaciones toast -->
        <?= Toast::flash() ?>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $d->titulo ?? 'Página de Prueba' ?></h5>
                <p class="card-text">Esta página demuestra el sistema de notificaciones toast.</p>
            </div>
        </div>
        

    
<?php require_once INCLUDES . 'inc_footer.php'; ?>