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
$nombreDepartamento;
$departamentos="SELECT * FROM Departamentos";
$centroTrabajo="SELECT * FROM CentrosTrabajo";
$empleado="SELECT * FROM empleados where idEmpleados = $id";

?>

<?php

if (isset($_POST['agregar_send'])) {

    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if (!isset($error)) {
   
      // Preparamos la consulta para guardar el registro en la BD
      $queryInsertProblema = sprintf(
        "INSERT INTO Problemas (claveProblemas,nombreP,fecha,detalles,estadoP,idDepartamento,idCentroTrabajo,idEmpleado,Prioridad) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($connLocalhost, trim($_POST['claveProblemas'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['nombreP'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['fecha'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['detalles'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['estadoP'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['departamento'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['centroTrabajo'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['empleado'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['Prioridad']))
  
      );
  
      // Ejecutamos el query en la BD
      mysqli_query($connLocalhost, $queryInsertProblema) or trigger_error("El query de inserción de problema falló");
       
include("enviar.php");
      // Redireccionamos al usuario al Panel de Control
  
 
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
	<title>Agregar centro de trabajo</title>
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
					<a class="dropdown-item" href="#">Configuración</a>
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
						<a class="nav-link" href="#">
							<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
							
						</a>



						<div class="sb-sidenav-menu-heading"></div>
						<a class="nav-link" href="./../Visualizar/centrosTrabajo.php">
							<div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
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
					<h1 class="mt-4">Agregar Problema</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
            <li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Problemas</a></li>
						<li class="breadcrumb-item active"><a href="">Agregar</a></li>
					</ol>
					
				
         
            <form action="correo.php" method='post'>
            <form action="enviar.php" method='post'>
        <div class="user-details">
          <div class="input-box">
            <span class="details">Clave</span>
            <input type="text" name="claveProblemas" placeholder="" value="<?php if (isset($_POST['claveProblemas'])) echo $_POST['claveProblemas']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Correo para</span>
            <input type="text" name="correoDestinatario" placeholder="" value="<?php if (isset($_POST['correoDestinatario'])) echo $_POST['correoDestinatario']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Nombre del problema</span>
            <input type="text" name="nombreP" placeholder="" value="<?php if (isset($_POST['nombreP'])) echo $_POST['nombreP']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Fecha</span>
            <input type="text" name="fecha" placeholder="<?php echo $fechaActual = date('d-m-Y');?>" value="<?php echo $fechaActual = date('d-m-Y'); if (isset($_POST['fecha'])) echo $_POST['fecha']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Detalles</span>
            <input type="text" name="detalles" placeholder="" value="<?php if (isset($_POST['detalles'])) echo $_POST['detalles']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Estado</span>
            <input type="text" name="estadoP" placeholder="" value="<?php if (isset($_POST['estadoP'])) echo $_POST['estadoP']; ?>" />
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


  <div class="input-box">
            <span class="details">Centro de trabajo</span>

            <select class="caja-departamento" name="centroTrabajo">
        <?php
         $resultado = mysqli_query($connLocalhost, $centroTrabajo);
         while($row=mysqli_fetch_assoc($resultado)){
          echo '<option  value='.$row["clave"].'>'.$row["nombreC"].'</option>';
          
          #echo "<option value=\"{$row['idDepartamentos']}\">{$row['nombre']}</option>"; 
          }
                                         
        ?>
  </select>



  <div class="input-box">
            <span class="details">Empleado</span>

            <select class="caja-departamento" name="empleado">
        <?php
         $resultado = mysqli_query($connLocalhost, $empleado);
         while($row=mysqli_fetch_assoc($resultado)){
          echo '<option  value='.$row["numeroEmpleado"].'>'.$row["nombreE"].'</option>';
          
          #echo "<option value=\"{$row['idDepartamentos']}\">{$row['nombre']}</option>"; 
          }
                                         
        ?>
  </select>
          
          <div class="input-box">
            <span class="details">Prioridad</span>
            <input type="text" name="Prioridad" placeholder="" value="<?php if (isset($_POST['Prioridad'])) echo $_POST['Prioridad']; ?>" />
          </div>

        
          
        </div>
        <div class="button">
          <input type="submit" name="agregar_send" value="Agregar" />
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