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
$correoEmisor = "SELECT * FROM Correo";
$resultado = mysqli_query($connLocalhost, $correoEmisor);
while ($rowCorreo = mysqli_fetch_assoc($resultado)) {
    $_SESSION['correoReceptor'] = $rowCorreo['receptor'];
    $_SESSION['correoEmisor'] = $rowCorreo['emisor'];
    $_SESSION['correoPassword'] = $rowCorreo['password'];
    $_SESSION['correoHost'] = $rowCorreo['host'];
}
function comprobar(){
  if ($_SESSION['rol'] == 'Admin') {

  
  } else {
      echo "hidden";
  }
}
?>

<?php

if (isset($_POST['agregar_send'])) {
  $claveP = $_POST['claveProblemas'];
  $queryConsultaClave="SELECT * FROM Problemas where claveProblemas = $claveP";
 $dato = mysqli_query($connLocalhost, $queryConsultaClave) or trigger_error("El query de inserción de problema falló");
/**
* 
*/
$duplicado = mysqli_num_rows($dato);


    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
   
   /**
    *Verificación que la clave del problema no exista. 
    */
    if ($duplicado == 0) {
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
}
 else {
  $error ="La clave del registro ya existe";
  echo "<script> alert('".$error."'); </script>";
  
}
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
            <span   class="details">Correo para</span>
            <input   type="email" name="correoDestinatario" placeholder="" value="<?php echo $_SESSION['correoReceptor']; if (isset($_POST['correoDestinatario'])); ?>" />
          </div>
          <div class="input-box">
            <span class="details">Nombre del problema</span>
            <input type="text" name="nombreP" placeholder="" value="<?php if (isset($_POST['nombreP'])) echo $_POST['nombreP']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Fecha</span>
            <input type="text" name="fecha" placeholder="<?php echo $fechaActual = date('d-m-Y');?>" value="<?php echo $fechaActual = date('d-m-Y'); if (isset($_POST['fecha']))  ?>" />
          </div>
          <div class="input-box">
            <span class="details">Detalles</span>
           
            <textarea name="detalles" rows="5" cols="214" value="<?php if (isset($_POST['detalles'])) echo $_POST['detalles']; ?>"></textarea>
          </div>
          <div class="input-box">
            <span class="details">Estado</span>
      
          <select class="caja-departamento" name="estadoP">
              <option  value="No realizado">No realizado</option>
              <option  value="Realizado">Realizado</option>
           </select>
          </div>
         
          <div class="input-box">
            <span class="details">Departamento</span>
            <script> 
             function cambio(){
          	document.getElementById("nombreD").value = document.getElementById("departamento").innerText}
              </script> 


            <select class="caja-departamento" id = "departamento"name="departamento" onchange="cambio()">
        
      <?php
         $resultado = mysqli_query($connLocalhost, $departamentos);
         while($row=mysqli_fetch_assoc($resultado)){
          echo '<option   value=' .$row["clave"].'>'.$row["nombreD"].'</option>';
      
        
          }
                                         
        ?>
  </select>

  <input type="hidden" id="nombreD" name="nombreD" value="<?php if (isset($_POST['nombreD'])) echo $_POST['nombreD']; ?>">
  </div>
  <div class="input-box">
            <span class="details">Centro de trabajo</span>

            <select class="caja-departamento" name="centroTrabajo">
        <?php
         $resultado = mysqli_query($connLocalhost, $centroTrabajo);
         while($row=mysqli_fetch_assoc($resultado)){
          echo '<option  value='.$row["clave"].'>'.$row["nombreC"].'</option>';
          
     
          }
                                         
        ?>
  </select>

  </div>

  <div class="input-box">
            <span class="details">Empleado</span>

            <select class="caja-departamento" name="empleado">
        <?php
         $resultado = mysqli_query($connLocalhost, $empleado);
         while($row=mysqli_fetch_assoc($resultado)){
          echo '<option  value='.$row["numeroEmpleado"].'>'.$row["nombreE"].'</option>';
          
          
          }
                                         
        ?>
  </select>
  </div>
          <div class="input-box">
            <span class="details">Prioridad</span>
            
          
            <select class="caja-departamento" name="Prioridad">
              <option  value="Urgente">Urgente</option>
              <option  value="Alta">Alta</option>
              <option  value="Media">Media</option>
              <option  value="Baja">Baja</option>
           </select>
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