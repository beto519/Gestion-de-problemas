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

$nombre = $_SESSION['nombreE'];

$claveCentoTrabajo = $_GET['clave'];


$querybusquedaFilas = "SELECT * From Problemas where idCentroTrabajo = '$claveCentoTrabajo';
";

$resultado = mysqli_query($connLocalhost, $querybusquedaFilas);
$rowCount=mysqli_num_rows($resultado);

if($rowCount!=0){
 
	echo'<script type="text/javascript">
alert("El dato ya se encuentra en un problema.");
window.location.href="./../Visualizar/centrosTrabajo.php";
</script>';



}else
{
  $borrarEmpleados ="Delete FROM CentrosTrabajo where clave ='$claveCentoTrabajo'";
  $resQueryLogin = mysqli_query($connLocalhost, $borrarEmpleados) or trigger_error("El query de login de usuario falló");
  
  echo'<script type="text/javascript">
alert("Eliminación exitosa");
window.location.href="./../Visualizar/centrosTrabajo.php";
</script>';



}




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