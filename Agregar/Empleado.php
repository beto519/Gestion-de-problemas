<?php
// Inicializamos la sesion o la retomamos


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
$departamentos="SELECT * FROM Departamentos";

// Lo primero que haremos será validar si el formulario ha sido enviado
if (isset($_POST['registrar_send'])) {
  $pass = $_POST['contraseña'];
  // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
  if (!isset($error)) {

    $pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);
    // Preparamos la consulta para guardar el registro en la BD
    $queryInsertUser = sprintf(
      "INSERT INTO empleados (numeroEmpleado,nombreE,correo,usuario,contraseña,idDepartamentos,estado,rol) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
      mysqli_real_escape_string($connLocalhost, trim($_POST['numeroEmpleado'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['nombreE'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['correo'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['usuario'])),
      mysqli_real_escape_string($connLocalhost, trim($pass_cifrada)),
      mysqli_real_escape_string($connLocalhost, trim($_POST['departamento'])),
      mysqli_real_escape_string($connLocalhost, trim('Activo')),
      mysqli_real_escape_string($connLocalhost, trim($_POST['tipoUsuario']))

    );

    // Ejecutamos el query en la BD
    mysqli_query($connLocalhost, $queryInsertUser) or trigger_error("El query de inserción de usuarios falló");

    // Redireccionamos al usuario al Panel de Control

    header("Location: ./../Visualizar/empleados.php"); 
  }
} else {
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./../css/registrar1.css" rel="stylesheet" type="text/css" />
  <title>Registrar</title>
</head>

<body>
  <form class="container_1" action="Empleado.php" method="post">
    <div class="title">Registrar</div>
    <div class="content">
      <form action="#">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Numero de empleado</span>
            <input type="text" name="numeroEmpleado" placeholder="000" value="000<?php if (isset($_POST['numeroEmpleado'])) echo $_POST['numeroEmpleado']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Nombre</span>
            <input type="text" name="nombreE" placeholder="Ingresa tu nombre" value="<?php if (isset($_POST['nombreE'])) echo $_POST['nombreE']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Correo</span>
            <input type="text" name="correo" placeholder="Ingresa tu correo" value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Usuario</span>
            <input type="text" name="usuario" placeholder="Ingresa tu usuario" value="<?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>" />
          </div>



          <div class="input-box">
            <span class="details">Contraseña</span>
            <input type="password" name="contraseña" placeholder="Ingresa su contraseña" value="<?php if (isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Departamento</span>

            <select class="caja-departamento" name="departamento">
        <?php
         $resultado = mysqli_query($connLocalhost, $departamentos);
         while($row=mysqli_fetch_assoc($resultado)){
          echo '<option  value='.$row["clave"].'>'.$row["nombreD"].'</option>';
          
          #echo "<option value=\"{$row['idDepartamentos']}\">{$row['nombre']}</option>"; 
          }
                                         
        ?>
      </select>
           
          </div>
          <div class="input-box">
            <span class="details">Tipo de usuario</span>

            <select class="caja-departamento" name="tipoUsuario">
       
        <option  value="Admin">Admin</option>
        <option  value="Reparador">Reparador</option>
        <option  value="Empleado">Empleado</option>
      </select>
           
          </div>
          
        </div>
        <div class="button">
          <input type="submit" name="registrar_send" value="Registrar" />
        </div>
        <div class="link_login">
         
        </div>
    </div>
  </form>
</body>

</html>