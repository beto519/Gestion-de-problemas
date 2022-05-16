<?php
session_start();



if (!isset($_SESSION)) {
	session_start();
	// Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión

}

// Incluimos la conexión a la base de datos
include("./../conexionBD/conexion.php");

$id = $_SESSION['id'];



function comprobar()
{
	if ($_SESSION['rol'] == 'Admin') {
	} else {
		echo "hidden";
	}
}

$nombre = $_SESSION['nombreE'];
$nombreDepartamento;
$departamentos = "SELECT * FROM Departamentos";
$centroTrabajo = "SELECT * FROM CentrosTrabajo";
$empleado = "SELECT * FROM empleados where idEmpleados = $id";
$codigoProblema = $_GET['claveSolucion'];


$correoEmisor = "SELECT * FROM Correo";
$resultado = mysqli_query($connLocalhost, $correoEmisor);
while ($rowCorreo = mysqli_fetch_assoc($resultado)) {
	$_SESSION['correoReceptor'] = $rowCorreo['receptor'];
	$_SESSION['correoEmisor'] = $rowCorreo['emisor'];
	$_SESSION['correoPassword'] = $rowCorreo['password'];
	$_SESSION['correoHost'] = $rowCorreo['host'];
	$_SESSION['correoPasswordReparador'] = $rowCorreo['passwordS'];
}
?>

<?php

if (isset($_POST['agregar_send'])) {

	// Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
	if (!isset($error)) {




		// Preparamos la consulta para guardar el registro en la BD
		$queryInsertProblema = sprintf(
			"INSERT INTO Soluciones (clave,nombre,detalles,idProblema,fechaS) VALUES ('%s', '%s', '%s', '%s', '%s')",
			mysqli_real_escape_string($connLocalhost, trim($_POST['clave'])),
			mysqli_real_escape_string($connLocalhost, trim($_POST['nombre'])),
			mysqli_real_escape_string($connLocalhost, trim($_POST['detalles'])),
			mysqli_real_escape_string($connLocalhost, trim($_POST['claveProblemas'])),
			mysqli_real_escape_string($connLocalhost, trim($_POST['fechaS']))

		);


		// Ejecutamos el query en la BD
		mysqli_query($connLocalhost, $queryInsertProblema) or trigger_error("El query de inserción de problema falló");


		$queryEditProblema = sprintf(
			"UPDATE Problemas SET  estadoP='%s' WHERE claveProblemas =%s",
			mysqli_real_escape_string($connLocalhost, trim($_POST['estadoP'])),
			mysqli_real_escape_string($connLocalhost, trim($_POST['claveProblemas']))

		);

		// Ejecutamos el query en la BD
		mysqli_query($connLocalhost, $queryEditProblema) or trigger_error("El query de edicion de usuarios falló");




		include("EnviarSolucion.php");
	}
} else {
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
	<title>Agregar Solución</title>
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
						<a class="nav-link" href="./../Visualizar/centrosTrabajo.php">
							<div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
							Centros de trabajo
						</a><a class="nav-link" href="./../Visualizar/empleados.php">
							<div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
							Empleados
						</a>
						<a class="nav-link" href="./../Visualizar/Departamentos.php">
							<div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
							Departamentos
						</a>


					</div>

			</nav>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid">
					<h1 class="mt-4">Agregar Solución</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
						<li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Solución</a></li>
						<li class="breadcrumb-item active"><a href="">Agregar</a></li>
					</ol>



					<form action="Solucion.php" method='post'>
						<form action="EnviarSolucion.php" method='post'>
							<div class="user-details">
								<div class="input-box">

									<span class="details">Clave</span>
									<input type="text" name="clave" placeholder="" value="<?php if (isset($_POST['clave'])) echo $_POST['clave']; ?>" />
								</div>
								<div class="input-box">
									<span class="details">Correo para</span>
									<input type="email" name="correoDestinatario" placeholder="" value="<?php echo $_SESSION['correoEmisor'];
																										if (isset($_POST['correoDestinatario'])); ?>" />
								</div>
								<div class="input-box">
									<span class="details">Fecha</span>
									<input type="" name="fechaS" placeholder="<?php echo $fechaActual = date('Y-m-d'); ?>" value="<?php echo $fechaActual = date('Y-m-d'); if (isset($_POST['fechaS'])) echo $_POST['fechaS']; ?>" />
								</div>

								<div class="input-box">
									<span class="details">Datos de la Solución</span>
									<input type="text" name="nombre" placeholder="" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" />
								</div>

								<div class="input-box">
									<span class="details">Detalles</span>

									<textarea name="detalles" rows="5" cols="214" value="<?php if (isset($_POST['detalles'])) echo $_POST['detalles']; ?>"></textarea>
								</div>

								<div class="input-box">
									<span class="details">Estado</span>

									<select class="caja-departamento" name="estadoP">
										<option value="Realizado">Realizado</option>
									</select>


								</div>
								<div class="input-box">
									<span class="details">Codigo Problema</span>

									<input readonly type="text" name="claveProblemas" placeholder=" <?php echo $codigoProblema; ?>" value="<?php echo $codigoProblema; ?><?php if (isset($_POST['claveProblemas'])); ?>" />
								</div>



							</div>
							<div class="button">
								<input type="submit" name="agregar_send" value="Enviar Solución" />
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