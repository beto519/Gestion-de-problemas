<?php
  // Inicializamos la sesion o la retomamos


if(!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión
  if(isset($_SESSION['id'])) header('Location: index.php');

}

// Incluimos la conexión a la base de datos
include("conexionBD/conexion.php");


  // Lo primero que haremos será validar si el formulario ha sido enviado
  if(isset($_POST['registrar_send'])) {
    $pass = $_POST['contraseña'];
    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if(!isset($error)) {
    
      $pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);
      // Preparamos la consulta para guardar el registro en la BD
      $queryInsertUser = sprintf("INSERT INTO empleados (numeroEmpleado,nombre,correo,usuario,contraseña,departamento) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
          mysqli_real_escape_string($connLocalhost, trim($_POST['numeroEmpleado'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['nombre'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['correo'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['usuario'])),
          mysqli_real_escape_string($connLocalhost, trim($pass_cifrada)),
          mysqli_real_escape_string($connLocalhost, trim($_POST['departamento']))

      );

      // Ejecutamos el query en la BD
      mysqli_query($connLocalhost, $queryInsertUser) or trigger_error("El query de inserción de usuarios falló");

      // Redireccionamos al usuario al Panel de Control
      
      header("Location:index.php?insertUser=true");
    }

  }
  else {
    
  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/registrar.css" rel="stylesheet" type="text/css" />
    <title>Registrar</title>
</head>
<body>
<form class="container_1" action="Registrar.php" method="post">
    <div class="title">Registrar</div>
    <div class="content">
      <form action="#">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Numero de empleado</span>
            <input type="text" name="numeroEmpleado" placeholder="000" value="<?php if(isset($_POST['numeroEmpleado'])) echo $_POST['numeroEmpleado']; ?>"/>
          </div>
          <div class="input-box">
            <span class="details">Nombre</span>
            <input type="text" name="nombre" placeholder="Ingresa tu nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>"/>
          </div>
          <div class="input-box">
            <span class="details">Correo</span>
            <input type="text" name="correo" placeholder="Ingresa tu correo"  value="<?php if(isset($_POST['correo'])) echo $_POST['correo']; ?>"/>
          </div>
          <div class="input-box">
            <span class="details">Usuario</span>
            <input type="text" name="usuario" placeholder="Ingresa tu usuario" value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario']; ?>"/>
          </div>
         
         
         
          <div class="input-box">
            <span class="details">Contraseña</span>
            <input type="password" name="contraseña" placeholder="Ingresa su contraseña" value="<?php if(isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>"/>
          </div>
          <div class="input-box">
            <span class="details">Departamento</span>
            <input type="text" name="departamento" placeholder="Ingresa tu departamento"  value="<?php if(isset($_POST['departamento'])) echo $_POST['departamento']; ?>"/>
          </div>
        </div>
        <div class="button">
          <input type="submit" name="registrar_send" value="Registrar"/>
        </div>
        <div class="link_login">
        <a href="login.php" class="h5">¿Ya tienes una cuenta?</a>
        </div>
  </div>
  </form>
</body>
</html>

