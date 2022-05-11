<?php
/*
*Retomamos la sesión
*/
session_start();
//Comprobamos que la sesión ya ha sido realizada, si no lo llevara al login
if (!isset($_SESSION['id'])) {
    header("Location: ./../login.php");
}
/*
*Variables
*$nombre = $_SESSION['nombreE']; utilizada para obtener el nombre del usuario que está logeado.
*$EstadoProblemas="No realizado"; utilizada para obtener los problemas que no ha sido realizados.
*/
$EstadoProblemas = "No realizado";
$nombre = $_SESSION['nombreE'];
$codigoE = $_SESSION['numeroEmpleado'];


/**
 * Se incluye la conexión a la base de datos y se realiza una sentencia sql
 */
include("./../conexionBD/conexion.php");
/**
 * Se realiza la consulta para obtener los datos de la base de datos
 */



if ($_SESSION['rol'] == 'Admin') {

    $reportes = "SELECT * FROM Problemas";
    $sql = "SELECT * From Problemas
    Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
    Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
    Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
    where Problemas.estadoP = '$EstadoProblemas' 
    ";
} else {
    $reportes = "SELECT * FROM Problemas";
    $sql = "SELECT * From Problemas
    Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
    Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
    Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
    where Problemas.idEmpleado = '$codigoE'";
}

$rowsAlta = "SELECT * From Problemas 
Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
WHERE Problemas.Prioridad ='Alta'
";

$resultado = mysqli_query($connLocalhost, $rowsAlta);
$rowcountAlta = mysqli_num_rows($resultado);

$rowsBaja = "SELECT * From Problemas 
Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
WHERE Problemas.Prioridad ='Baja'
";

$resultado = mysqli_query($connLocalhost, $rowsBaja);
$rowcountBaja = mysqli_num_rows($resultado);

$rowsMedia = "SELECT * From Problemas 
Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
WHERE Problemas.Prioridad ='Media'
";

$resultado = mysqli_query($connLocalhost, $rowsMedia);
$rowcountMedia = mysqli_num_rows($resultado);

$rowsUrgente = "SELECT * From Problemas 
Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
WHERE Problemas.Prioridad ='Urgente'
";

$resultado = mysqli_query($connLocalhost, $rowsUrgente);
$rowcountUrgente = mysqli_num_rows($resultado);

function comprobar()
{
    if ($_SESSION['rol'] == 'Admin') {
    } else {
        echo "hidden";
    }
}


function comprobarReparador()
{
    if ($_SESSION['rol'] == 'Reparador' or $_SESSION['rol'] == 'Admin') {
    } else {
        echo "hidden";
    }
}

?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pagina Principal</title>
    <link href="./../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="./../css/position.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="principal.php">Gestión de problemas</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
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
                        <a class="nav-link" href="Problemas.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Problemas
                        </a>

                        <div class="sb-sidenav-menu-heading"></div>

                        <a class="nav-link" href="departamentos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Departamentos
                        </a><a class="nav-link" href="empleados.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Empleados
                        </a>
                        <a class="nav-link" href="centrosTrabajo.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Centros de trabajo
                        </a>


                    </div>
                </div>
                <div class="sb-sidenav-footer">


            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Inicio</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Pagina principal</li>
                    </ol>
                    <div <?php comprobarReparador(); ?> class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="position-prioridades"> <b><?php echo $rowcountBaja; ?></b></div>

                                <div class="card-body">Baja </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="./Prioridades/Baja.php"> Ver Detalles</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="position-prioridades"> <b><?php echo $rowcountMedia; ?></b></div>

                                <div class="card-body">Media </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="./Prioridades/Media.php">Ver Detalles</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="position-prioridades"> <b><?php echo $rowcountAlta; ?></b> </div>

                                <div class="card-body">Alta </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="./Prioridades/Alta.php">Ver Detalles</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="position-prioridades"> <b><?php echo $rowcountUrgente; ?></b></div>
                                <div class="card-body">Urgente</b></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="./Prioridades/Urgente.php">Ver Detalles</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">

                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">

                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-table mr-1"></i>Problemas</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>


                                        <tr>
                                            <th>Clave</th>
                                            <th>Fecha</th>

                                            <th>Descripcion</th>
                                            <th>Detalles</th>
                                            <th>Estado</th>
                                            <th>Departamento</th>
                                            <th>Centro de trabajo</th>
                                            <th>Empleado</th>
                                            <th>Prioridad</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>

                                            <th>Descripcion</th>
                                            <th>Detalles</th>
                                            <th>Estado</th>
                                            <th>Departamento</th>
                                            <th>Centro de trabajo</th>
                                            <th>Empleado</th>
                                            <th>Prioridad</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php /**
                                         * Se realiza la consulta con la sentencia anteriormente defenida en la linea 25, dicha consulta solicita los datos de reportes
                                         * */
                                        $resultado = mysqli_query($connLocalhost, $sql);
                                        while ($row = mysqli_fetch_assoc($resultado)) { ?>


                                            <tr>

                                                <td><?php
                                                    /**
                                                     * Se comienzan a llenar las columnas con las filas correspondientes de la base de datos.
                                                     */
                                                    echo $row['claveProblemas']; ?></td>

                                                <td><?php echo $row['fecha']; ?></td>

                                                <td><?php echo $row['nombreP']; ?></td>
                                                <td><?php echo $row['detalles']; ?></td>
                                                <td><?php echo $row['estadoP']; ?></td>
                                                <td><?php echo $row['nombreD']; ?></td>
                                                <td><?php echo $row['nombreC']; ?></td>
                                                <td><?php echo $row['nombreE']; ?></td>
                                                <td><?php echo $row['Prioridad']; ?></td>
                                            </tr>

                                        <?php } ?>






                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy;2022</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="./../demo/datatables-demo.js"></script>
</body>

</html>