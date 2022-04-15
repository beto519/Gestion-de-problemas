<?php

/**Clase login, encargada de controlar el acceso de los usuarios a traves de un codigo de empleado y una contraseña, ademas de ser la encargada de definir las
 * variables de Session.
 */
/**Primero
 * Se realiza una consulta para saber si hay una sesión anteriormente iniciada.
 * En caso de haber una sesión iniciada te redireccionar a la pagina principal del programa.
 */
if (!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión
  if (isset($_SESSION['id'])) header('Location: Visualizar/principal.php');
}
/**  Incluimos la conexión a la base de datos*/
include("conexionBD/conexion.php");

/**  Evaluamos si el formulario ha sido enviado*/
if (isset($_POST['iniciarsesion'])) {

  /**  Validamos si las cajas están vacias*/
  foreach ($_POST as $cajas => $caja) {
    if ($caja == "") $error[] = "La caja $cajas es obligatoria";
  }
  echo '<script type="text/javascript">
  alert("Ingrese todos los datos");</script>';


  /**  Armamos el query para verificar el numero de empleado*/
  $queryLogin = sprintf(
    "SELECT idempleados, numeroEmpleado, nombreE,correo,usuario, contraseña,idDepartamentos,estado,rol FROM empleados WHERE numeroEmpleado = '%s'",
    mysqli_real_escape_string($connLocalhost, trim($_POST['numeroEmpleado']))

  );
  /**Obtenemos la contraseña que el usuario ingreso a traves de la caja de texto */
  $passwodDesifrada = $_POST['contraseña'];
  // Ejecutamos el query
  $resQueryLogin = mysqli_query($connLocalhost, $queryLogin) or trigger_error("El query de login de usuario falló");

  /** Determinamos si hay valores con los datos anteriormente ingresados
   * Contamos el recordset (el resultado esperado para un login valido es 1)
   */
  if (mysqli_num_rows($resQueryLogin)) {
    // Hacemos un fetch del recordset
    $userData = mysqli_fetch_assoc($resQueryLogin);

    // Definimos variables de sesion en $_SESSION
    $_SESSION['id'] = $userData['idempleados'];
    $_SESSION['numeroEmpleado'] = $userData['numeroEmpleado'];
    $_SESSION['nombreE'] = $userData['nombreE'];
    $_SESSION['correo'] = $userData['correo'];
    $_SESSION['correo'] = $userData['correo'];
    $_SESSION['usuario'] = $userData['usuario'];
    $_SESSION['contraseña'] = $userData['contraseña'];
    $_SESSION['departamento'] = $userData['departamento'];
    $_SESSION['estado'] = $userData['estado'];
    $_SESSION['rol'] = $userData['rol'];
    $hash = $_SESSION['contraseña'];
    $_SESSION['desifrada'] = $passwodDesifrada;
  } else {
    $error = "Login failed";
  }
  /**
   * Comprobamos que la contraseña coincida con la que está en la base de datos. 
   */
  if (password_verify($passwodDesifrada, $hash)) {
    header('Location: Visualizar/principal.php');
  }
  /**
   * En caso de que no se cumpla finalizamos los datos de sesion y se devuelve al login.
   */

  else {

    include("includes/cerrarSesion.php");

    header('Location: login.php');
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/login.css">
  <title>Inciar Sesión</title>
</head>

<body>
  <div class="wrapper">
    <div class="logo"> <img src="https://img.freepik.com/vector-gratis/icono-gestion-problemas-ilustracion-elemento-simple-diseno-simbolo-concepto-gestion-problemas-puede-utilizar-web-movil_159242-7242.jpg?size=338&ext=jpg" alt="Gestion de problemas"> </div>
    <div class="text-center mt-4 name centrar"> Iniciar <span>Sesión</span> </div>
    <form class="p-3 mt-3" action="login.php" method="post">
    <!--
    Colocamos los input necesarios para las credenciales de inicio de sesion
    Numero de empleado String
    Contraseña String
    -->
      <div class="form-field d-flex align-items-center"> <span class="far fa-user"></span> <input type="text" name="numeroEmpleado" id="numeroEmpleado" placeholder="Numero empleado"> </div>
      <div class="form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" value="<?php if (isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>">
      </div> <button id="iniciarSesion" name="iniciarsesion" class="btn mt-3">Iniciar Sesión</button>
    </form>
    <div class="centrar">
    </div>
  </div>
</body>

</html>