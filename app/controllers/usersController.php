<?php

class usersController {
	function __construct() {
		echo 'Ejecutando: '.__CLASS__;
	}

	function ver($id = NULL) {
		// %s: placeholder de cadena para sprintf (se reemplaza por valores)
		// $id: parámetro opcional recibido desde la URL (p.ej. /users/ver/2)
		// ?? : operador de fusión nula; usa 'sin id' si $id es null
		// null: valor por defecto cuando no se pasa $id en la URL
		// Muestra el id recibido y la clase actual
		echo sprintf("Viendo el perfil %s en %s", $id ?? 'sin id', __CLASS__);
	}

	function ver_usuario($id = NULL, $nombre = NULL, $apellido = 'Gonzalez') {
		// Método con tres parámetros: id, nombre y apellido de usuario
		// URL ejemplo: /users/ver-usuario/123/juan/garcia
		// $id: identificador del usuario
		// $nombre: nombre del usuario
		// $apellido: apellido del usuario
		echo sprintf("Viendo usuario ID: %s, Nombre: %s, Apellido: %s en %s", 
			$id ?? 'sin id', 
			$nombre ?? 'sin nombre', 
			$apellido ?? 'sin apellido',
			__CLASS__
		);
	}

	function agregar() {
		echo 'agregar';
	}

	function actualizar() {
		echo 'actualizar';
	}

	function borrar() {
		echo 'borrando...';
	}

	function calificar() {
		echo 'calificando...';
	}
}


