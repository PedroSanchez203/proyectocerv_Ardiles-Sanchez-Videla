<?php

// esta funcion convierte un array asociativo en un objeto
function to_Object($array) {
 return json_decode(json_encode($array));
 // json_decode es una funcion que convierte un json en un array asociativo
 // json_encode es una funcion que convierte un array asociativo en un json
 // usando ambos podemos convertir un array asociativo en un objeto por que el array se volvio un objeto json y luego se convirtio en un objeto.
 
}

function get_sitename() {
    return 'Core';
}