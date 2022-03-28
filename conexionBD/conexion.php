<?php
$baseDatos = "bkcx10cn1dpbf3cc0liw";
$servidor = "bkcx10cn1dpbf3cc0liw-mysql.services.clever-cloud.com";
$usuarioBd = "uvcod8w9tfxghujt";
$passwordBd = "2P460clYhqXaDyEkKWM2";


// Creamos la conexión
$connLocalhost = mysqli_connect($servidor, $usuarioBd, $passwordBd);

if (mysqli_connect_error()) {
    echo "Error al Conectar a la base de Datos: " . mysqli_connect_error();
}
// Definimos el cotejamiento para la conexion (igual al cotejamiento de la BD)
mysqli_query($connLocalhost, "SET NAMES 'utf8'");

// Seleccionamos la base de datos por defecto para el proyecto
mysqli_select_db($connLocalhost, $baseDatos);
#me daba problemas, las funciones se declaran en includes/common_functions c:
#ya lo arregle, te faltaba hacer el include del archivo en la que estaba la funcion
#function formatfecha($fecha){

#   return date('g:i a',strtotime($fecha));
#}

?>
