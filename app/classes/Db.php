<?php

// Clase Db: Maneja la conexión y operaciones con la base de datos
// Implementa el patrón Singleton para evitar múltiples conexiones simultáneas
class Db {
    
    private static $instance = null; // Instancia única
    private $link;                   // Conexión a la base de datos
    
    private $engine;
    private $host;
    private $name;
    private $user;
    private $pass;
    private $charset;

    /**
     * Constructor privado: evita que se creen múltiples instancias
     */
    private function __construct() {
        // Configurar propiedades según el entorno
        $this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
        $this->host   = IS_LOCAL ? LDB_HOST   : DB_HOST;
        $this->name   = IS_LOCAL ? LDB_NAME   : DB_NAME;
        $this->user   = IS_LOCAL ? LDB_USER   : DB_USER;
        $this->pass   = IS_LOCAL ? LDB_PASS   : DB_PASS;
        $this->charset= IS_LOCAL ? LDB_CHARSET: DB_CHARSET;

        $this->connect();
    }

    /**
     * Obtener la instancia única de la base de datos
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Conectar a la base de datos (solo una vez)
     */
    private function connect() {
        try {
            $this->link = new PDO(
                "{$this->engine}:host={$this->host};dbname={$this->name};charset={$this->charset}",
                $this->user,
                $this->pass
            );
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(sprintf('No hay conexión a la base de datos, hubo un error: %s', $e->getMessage()));
        }
    }

    /**
     * Ejecutar una consulta SQL con parámetros
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->link->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die('Error en consulta: ' . $e->getMessage());
        }
    }

    /**
     * Versión estática de query (para mantener compatibilidad con tu código actual)
     */
    public static function staticQuery($sql, $params = []) {
        return self::getInstance()->query($sql, $params);
    }
}
