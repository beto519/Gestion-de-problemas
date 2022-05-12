<?php
session_start();
if (!isset($_SESSION)) {
    session_start();
    // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión
}
if ($_SESSION['rol'] != "Admin") {
    //Poner una alerta de que no es posible si no es administrador
    header("Location: ./../Visualizar/principal.php");
}
// Incluimos la conexión a la base de datos
include("./../conexionBD/conexion.php");

$id = $_SESSION['id'];

$nombre = $_SESSION['nombreE'];

$claveCentoTrabajo = $_GET['clave'];

function comprobar(){
    if ($_SESSION['rol'] == 'Admin') {

    
    } else {
        echo "hidden";
    }
}



$buscarCentroTrabajo = "SELECT * FROM CentrosTrabajo where clave ='$claveCentoTrabajo'";
$resQueryLogin = mysqli_query($connLocalhost, $buscarCentroTrabajo) or trigger_error("El query de login de usuario falló");
// Hacemos un fetch del recordset
$CentrosTrabajoEdicion = mysqli_fetch_assoc($resQueryLogin);
// Definimos variables de sesion en $_SESSION
$CodigoBusqueda = $CentrosTrabajoEdicion['clave'];
$nombreBusqueda = $CentrosTrabajoEdicion['nombreC'];
?>
<?php
// Lo primero que haremos será validar si el formulario ha sido enviado
if (isset($_POST['editar_send'])) {
    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if (!isset($error)) {
        // Preparamos la consulta para guardar el registro en la BD
        $queryEdituser = sprintf(
            "UPDATE CentrosTrabajo SET clave='%s', nombreC='%s' WHERE clave =%d",
            mysqli_real_escape_string($connLocalhost, trim($_POST['clave'])),
            mysqli_real_escape_string($connLocalhost, trim($_POST['nombreC'])),
            mysqli_real_escape_string($connLocalhost, trim($_POST['clave']))
        );
        // Ejecutamos el query en la BD
        mysqli_query($connLocalhost, $queryEdituser) or trigger_error("El query de edicion de usuarios falló");
        // Redireccionamos al usuario al Panel de Control
        header("Location: ./../Visualizar/centrosTrabajo.php");
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
    <title>Editar centros de trabajo</title>
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
					<a <?php comprobar();?> class="dropdown-item" href="./../correo/Configuracion.php">Configuracion correo</a>
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
                        <a class="nav-link" href="./../correo/correo.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Generar Problema
                        </a>
                  

                  


                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link" href="./../Visualizar/departamentos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Departamentos
                        </a><a class="nav-link" href="./../Visualizar/empleados.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Empleados
                        </a>
                        <a class="nav-link" href="./../Visualizar/centrosTrabajo.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Centros de trabajo
                        </a>

                    </div>

            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Editar Centro Trabajo</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
                        <li class="breadcrumb-item"><a href="./../Visualizar/centrosTrabajo.php">Centro de Trabajo</a></li>
                        <li class="breadcrumb-item active"><a href="">Editar</a></li>
                    </ol>



                    <form action="CentroTrabajo.php" method='post'>

                        <div class="user-details">
                            <div class="input-box">
                                <span class="details">Clave</span>
                                <input disabled type="text" name="clave" placeholder=" <?php echo $CodigoBusqueda; ?>" value="<?php echo $CodigoBusqueda; ?><?php if (isset($_POST['clave'])) echo $_POST['clave']; ?>" />
                            </div>
                            <div class="input-box">
                                <span class="details">Nombre</span>
                                <input type="text" name="nombreC" placeholder="Ingresa el nombre del centro de trabajo" value="<?php echo $nombreBusqueda; ?><?php if (isset($_POST['nombreC'])) echo $_POST['nombreC']; ?>" />
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