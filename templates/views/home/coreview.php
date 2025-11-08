<?php require_once INCLUDES . 'inc_header.php'; ?>

    <div class="container">
        <h1 class="text-center mb-4">¡Bienvenido!</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $d->titulo ?? 'Framework MVC Educativo' ?></h5>
                <p class="card-text">Sistema MVC simple para aprender:</p>
                <ul>
                    <li><strong>Modelo:</strong> Datos</li>
                    <li><strong>Vista:</strong> Interfaz</li>
                    <li><strong>Controlador:</strong> Lógica</li>
                </ul>
                <hr>
                <p><strong>Controlador:</strong> <?= CONTROLLER ?? 'home' ?> | <strong>Método:</strong> <?= METHOD ?? 'index' ?></p>
            </div>
        </div>
        
<?php require_once INCLUDES . 'inc_footer.php'; ?>