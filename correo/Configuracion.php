<?php
session_start();



if (!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente sea visible cuando NO HAS INICIADO sesión
 
}
if($_SESSION['rol']=="Empleado"){
 //Poner una alerta de que no es posible si no es administrador
 header("Location: ./../Visualizar/principal.php"); 
}
// Incluimos la conexión a la base de datos
include("./../conexionBD/conexion.php");

$id = $_SESSION['id'];

$nombre = $_SESSION['nombreE'];
$queryBuscarConfirguracion ="SELECT * FROM Correo";
$dato = mysqli_query($connLocalhost, $queryBuscarConfirguracion) or trigger_error("El query de inserción de problema falló");
if (mysqli_num_rows($dato)) {
    // Hacemos un fetch del recordset
    $correoData = mysqli_fetch_assoc($dato);

	$correoData['receptor'];
	$correoData['emisor'];
	$correoData['host'];
}


function comprobar(){
    if ($_SESSION['rol'] == 'Admin' or $_SESSION['rol']=="Reparador") {

    
    } else {
        echo "hidden";
    }
}
?>

<?php

if (isset($_POST['agregar_send'])) {

	
    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if (!isset($error)) {
   
      // Preparamos la consulta para guardar el registro en la BD
	  $queryEdituser = sprintf(
		"UPDATE Correo SET receptor='%s', emisor='%s', password='%s', host='%s', passwordS='%s' WHERE idCorreo =%d",
		mysqli_real_escape_string($connLocalhost, trim($_POST['receptor'])),
		mysqli_real_escape_string($connLocalhost, trim($_POST['emisor'])),
		mysqli_real_escape_string($connLocalhost, trim( $_POST['password'])),
		mysqli_real_escape_string($connLocalhost, trim($_POST['host'])),
		mysqli_real_escape_string($connLocalhost, trim($_POST['passwordS'])),
		mysqli_real_escape_string($connLocalhost, trim(1))
	);
  
      // Ejecutamos el query en la BD
      mysqli_query($connLocalhost, $queryEdituser) or trigger_error("El query de inserción de usuarios falló");
  
      // Redireccionamos al usuario al Panel de Control
  
      header("Location: ./../Visualizar/Principal.php"); 
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
	<title>Configuración correo</title>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Generar Problema
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
					<h1 class="mt-4">Configurar correo</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
            <li class="breadcrumb-item"><a href="./../Correo/Configuracion.php">Correo</a></li>
			
					</ol>
					
				
            
            <form action="Configuracion.php" method='post'>

        <div class="user-details">
          <div class="input-box">
            <span class="details">Correo emisor</span>
            <input type="email" name="emisor" placeholder="Ingrese su correo" value="<?php echo $correoData['emisor']; if (isset($_POST['emisor'])); ?>" />
          </div>
          <div class="input-box">
            <span class="details">Correo Receptor</span>
            <input type="email" name="receptor" placeholder="Ingrese el correo Destinatario" value="<?php echo $correoData['receptor']; if (isset($_POST['receptor'])) ; ?>" />
          </div>
		  <div class="input-box">
            <span class="details">Contraseña</span>
            <input type="password" name="password" placeholder="" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" />
          </div>
		  <div class="input-box">
            <span class="details">Contraseña reparador</span>
            <input type="password" name="passwordS" placeholder="" value="<?php if (isset($_POST['passwordS'])) echo $_POST['passwordS']; ?>" />
          </div>

		  <div class="input-box">
            <span class="details">Tipo de correo</span>
            <input type="text" name="host" placeholder="Ingrese el host" value="<?php echo $correoData['host']; if (isset($_POST['host'])); ?>" />
          </div>
        
          
        </div>
        <div class="button">
          <input type="submit" name="agregar_send" value="Confirmar" />
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