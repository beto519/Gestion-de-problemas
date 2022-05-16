<?php
session_start();



if (!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión

}

// Incluimos la conexión a la base de datos
include("./../conexionBD/conexion.php");

$id = $_SESSION['id'];

$nombre = $_SESSION['nombreE'];
$departamentos = "SELECT * FROM Departamentos";
$codigoEmpleado = $_SESSION['numeroEmpleado'];


function comprobar()
{
  if ($_SESSION['rol'] == 'Admin') {
  } else {
    echo "hidden";
  }
}

function comprobarReparador()
{
  if ($_SESSION['rol'] == 'Admin' or $_SESSION['rol'] == 'Reparador') {
  } else {
    echo "hidden";
  }
}

$buscarEmpleado = "SELECT * FROM empleados where numeroEmpleado ='$codigoEmpleado'";
$resQueryLogin = mysqli_query($connLocalhost, $buscarEmpleado) or trigger_error("El query de login de usuario falló");


// Hacemos un fetch del recordset
$EmpleadoEdicion = mysqli_fetch_assoc($resQueryLogin);

// Definimos variables de sesion en $_SESSION


$CodigoBusqueda = $EmpleadoEdicion['numeroEmpleado'];
$nombreBusqueda = $EmpleadoEdicion['nombreE'];
$correoBusqueda = $EmpleadoEdicion['correo'];
$usuarioBusqueda = $EmpleadoEdicion['usuario'];

?>

<?php


// Lo primero que haremos será validar si el formulario ha sido enviado
if (isset($_POST['editar_send'])) {
  $pass = $_POST['contraseña'];
  // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
  if (!isset($error)) {
    $idDepartamentos = $_POST['departamento'];
    $pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);
    // Preparamos la consulta para guardar el registro en la BD
    $queryEdituser = sprintf(
      "UPDATE empleados SET numeroEmpleado='%s', nombreE='%s', correo='%s', usuario='%s', contraseña='%s' WHERE numeroEmpleado =%d",
      mysqli_real_escape_string($connLocalhost, trim($_POST['numeroEmpleado'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['nombreE'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['correo'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['usuario'])),
      mysqli_real_escape_string($connLocalhost, trim($pass_cifrada)),
      mysqli_real_escape_string($connLocalhost, trim($_POST['numeroEmpleado']))

    );

    // Ejecutamos el query en la BD
    mysqli_query($connLocalhost, $queryEdituser) or trigger_error("El query de edicion de usuarios falló");

    // Redireccionamos al usuario al Panel de Control

    header("Location: ./../Visualizar/empleados.php");
  }
} else {
  error_log("Fallo la query");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Mi perfil</title>
  <link href="./../css/styleEditar.css" rel="stylesheet" />

  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="./../Visualizar/principal.php">Gestión de problemas</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre; ?><i class="fas fa-user fa-fw"></i></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="./../Editar/MiPerfil.php">Mi perfil</a>
          <div class="dropdown-divider"></div>
          <a <?php comprobar(); ?> class="dropdown-item" href="./../correo/Configuracion.php">Configuracion correo</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./../includes/cerrarSesion.php">Salir</a>
        </div>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">

          <a class="nav-link" href="./../Visualizar/Problemas.php">
              <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Problemas
            </a>

            <a <?php comprobar();?> class="nav-link" href="./../Visualizar/Departamentos.php">
              <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Departamentos
            </a><a <?php comprobar();?> class="nav-link" href="./../Visualizar/empleados.php">
              <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Empleados
            </a>
            <a <?php comprobar();?> class="nav-link" href="./../Visualizar/centrosTrabajo.php">
              <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Centros de trabajo
            </a>

          
          </div>

      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Editar Empleado</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
           
            <li class="breadcrumb-item active"><a href="">Editar Empleados</a></li>
          </ol>



          <form action="MiPerfil.php" method='post'>

            <div class="user-details">
              <div class="input-box">
                <span class="details">Numero de empleado</span>
                <input readonly type="text" name="numeroEmpleado" placeholder=" <?php echo $codigoEmpleado; ?>" value="<?php echo $codigoEmpleado; ?><?php if (isset($_POST['numeroEmpleado'])) echo $_POST['numeroEmpleado']; ?>" />
              </div>
              <div class="input-box">
                <span class="details">Nombre</span>
                <input type="text" name="nombreE" placeholder="Ingresa tu nombre" value="<?php echo $nombreBusqueda; ?><?php if (isset($_POST['nombreE'])) echo $_POST['nombreE']; ?>" />
              </div>
              <div class="input-box">
                <span class="details">Correo</span>
                <input type="text" name="correo" placeholder="Ingresa tu correo" value="<?php echo $correoBusqueda; ?><?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" />
              </div>
              <div class="input-box">
                <span class="details">Usuario</span>
                <input type="text" name="usuario" placeholder="Ingresa tu usuario" value="<?php echo $usuarioBusqueda; ?><?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>" />
              </div>



              <div class="input-box">
                <span class="details">Contraseña</span>
                <input type="password" name="contraseña" placeholder="Ingresa su contraseña" value="<?php if (isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>" />
              </div>
              

            </div>
            <div class="button">
              <input type="submit" name="editar_send" value="Editar" />
            </div>

        </div>
        </form>
    </div>
  </div>
  </div>
  </main>
  <footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
      <div class="d-flex align-items-center justify-content-between small">

        <div>


        </div>
      </div>
    </div>
  </footer>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="./../js/scripts.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="./../demo/datatables-demo.js"></script>
</body>

</html>