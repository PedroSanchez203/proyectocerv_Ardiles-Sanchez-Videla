-- Tabla para el sistema de tareas
CREATE TABLE `todos` (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `task` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `id_categoria` int,
    `completed` TINYINT(1) DEFAULT 0,
    `priority` ENUM('low', 'medium', 'high') DEFAULT 'medium',
    `created_at` DATETIME NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     `Favorite` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`)
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo
INSERT INTO `todos` (`task`, `description`, `priority`, `created_at`) VALUES
('Aprender el framework', 'Estudiar la estructura MVC del proyecto', 'high', NOW()),
('Crear todo list', 'Implementar funcionalidad completa', 'medium', NOW()),
('Documentar código', 'Crear README con flujo de aplicación', 'low', NOW());
