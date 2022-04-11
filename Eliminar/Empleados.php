<?php
session_start();
if (!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión
}
if($_SESSION['rol']!="Admin"){
 //Poner una alerta de que no es posible si no es administrador
  header("Location: ./../Visualizar/principal.php"); 
}
// Incluimos la conexión a la base de datos
include("./../conexionBD/conexion.php");

$id = $_SESSION['id'];

$nombre = $_SESSION['nombre'];

$codigoEmpleado = $_GET['codigoEmpleado'];

$borrarEmpleados ="Delete FROM empleados where numeroEmpleado ='$codigoEmpleado'";
$resQueryLogin = mysqli_query($connLocalhost, $borrarEmpleados) or trigger_error("El query de login de usuario falló");

header("Location: ./../Visualizar/empleados.php");



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminado</title>
</head>
<body>
    
</body>
</html>