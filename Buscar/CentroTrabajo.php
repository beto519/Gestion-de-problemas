<?php
session_start();



if (!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión

}

// Incluimos la conexión a la base de datos
include("./../conexionBD/conexion.php");

$id = $_SESSION['numeroEmpleado'];

$nombre = $_SESSION['nombreE'];
$nombreDepartamento;
$departamentos = "SELECT * FROM Departamentos";
$centroTrabajo = "SELECT * FROM CentrosTrabajo";
$empleado = "SELECT * FROM empleados";

function comprobar()
{
  if ($_SESSION['rol'] == 'Admin') {
  } else {
    echo "hidden";
  }
}

function comprobarReparador()
{
  if ($_SESSION['rol'] == 'Reparador' or $_SESSION['rol'] == 'Admin' ) {
  } else {
    echo "hidden";
  }
}
?>

<?php

if (isset($_POST['buscar_send'])) {


  include("./../Reportes/FiltroCentroTrabajo.php");
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
  <title>Buscar Centro </title>
  <link href="./../css/styles.css" rel="stylesheet" />
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



            <div class="sb-sidenav-menu-heading"></div>
            
            <a <?php ComprobarReparador();?> class="nav-link" >
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                          Filtro
                        </a>
                        <a  <?php ComprobarReparador();?> class="nav-link" href="./../Buscar/Departamento.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Filtrar Departamentos
                        </a>
                        <a <?php ComprobarReparador();?> class="nav-link" href="./../Buscar/CentroTrabajo.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Filtrar Centros Trabajo
                        </a>
                        <a  <?php ComprobarReparador();?> class="nav-link" href="./../Buscar/Empleado.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Filtrar Empleados
                        </a>
                        <a <?php ComprobarReparador();?> class="nav-link" href="./../Buscar/Fecha.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Filtrar Fecha
                        </a>

          </div>

      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Buscar por Centro </h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
            <li class="breadcrumb-item"><a href="./../Visualizar/Problemas.php">Problemas</a></li>
            <li class="breadcrumb-item active"><a href="">Buscar</a></li>
          </ol>



          <form action="CentroTrabajo.php" method='post'>
            <form action="./../Reportes/FiltroCentroTrabajo.php" method='post'>
              <div class="user-details">


              </div>

              <div class="input-box">
                <span class="details">Centro Trabajo</span>
                <script>
                  function cambio() {
                    document.getElementById("nombreC").value = document.getElementById("centroTrabajo").innerText
                  }
                </script>


                <select class="caja-departamento" id="centroTrabajo" name="centroTrabajo" onchange="cambio()">

                  <?php
                  $resultado = mysqli_query($connLocalhost, $centroTrabajo);
                  while ($row = mysqli_fetch_assoc($resultado)) {
                    echo '<option   value=' . $row["clave"] . '>' . $row["nombreC"] . '</option>';
                  }

                  ?>
                </select>

                <input type="hidden" id="nombreC" name="nombreC" value="<?php if (isset($_POST['nombreC'])) echo $_POST['nombreC']; ?>">
              </div>








              <div class="button">
                <input type="submit" name="buscar_send" value="Buscar" />
              </div>

        </div>
        </form>
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