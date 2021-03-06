<?php
session_start();
require './../conexionBD/conexion.php';

if (!isset($_SESSION['id'])) {
	header("Location: ./../login.php");
}

$id = $_SESSION['id'];

$nombre = $_SESSION['nombreE'];
if ($_SESSION['rol'] != 'Admin') {
	header("Location: ./../Visualizar/principal.php");
}

$sql = "SELECT * FROM CentrosTrabajo";

function comprobar(){
    if ($_SESSION['rol'] == 'Admin') {

    
    } else {
        echo "hidden";
    }
}



?>

<script type="text/javascript">
function ConfirmarDelete(){
var respuesta = confirm("Estas seguro que deseas eliminar?");
if(respuesta == true){

  return true;
}else {

  return false;
}

}
</script>;


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Centros de Trabajo</title>
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
					

						<a class="nav-link" href="./../Visualizar/Problemas.php">
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



					</div>

			</nav>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid">
					<h1 class="mt-4">Lista centros de Trabajo</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="principal.php">Principal</a></li>
						<li class="breadcrumb-item active"><a href="centrosTrabajo.php">Centros de Trabajo</a></li>
					</ol>
					<div class="card mb-4">
						<div class="card-body">
						<div class="position-Registrar">
                            <input <?php comprobar();?> class="diseño-boton" type="submit" onclick="location.href='./../Agregar/centroTrabajo.php';" name="registrar_send" value="Agregar Centro" />
                        </div>
						
						</div>
					</div>
					<div class="card mb-4">
						<div class="card-header"><i class="fas fa-table mr-1"></i>Lista de centros de trabajo.</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Clave</th>
											<th>Nombre</th>
											<th <?php comprobar();?>>Editar</th>
											<th <?php comprobar();?>>Eliminar</th>
											<th <?php ?>>Reporte</th>

										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Clave</th>
											<th>Nombre</th>
											<th <?php comprobar();?>>Editar</th>
											<th <?php comprobar();?>>Eliminar</th>
											<th <?php ?>>Reporte</th>
										</tr>
									</tfoot>
									<tbody>

										<?php $resultado = mysqli_query($connLocalhost, $sql);
										while ($row = mysqli_fetch_assoc($resultado)) { ?>
											<tr>
												<td><?php echo $row['clave']; ?></td>
												<td><?php echo $row['nombreC']; ?></td>
												<td <?php comprobar();?>><a href="./../Editar/centroTrabajo.php?clave=<?php echo $row['clave']; ?>">Editar</a></td>
												<td <?php comprobar();?> class="eliminar" id="eliminar"><a href="./../Eliminar/CentrosTrabajo.php?clave=<?php echo $row['clave']; ?>" onclick="return ConfirmarDelete();">Eliminar</a></td>
												<td <?php ?> class="editar"   id="reporte"><a href="./../Reportes/ReportesCentroTrabajo.php?clave=<?php echo $row['clave']; ?>"  >Reporte</a></td>
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