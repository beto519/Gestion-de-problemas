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


  $claveP = $_GET['claveProblemas'];
  $queryConsultaClave="SELECT * FROM Problemas where claveProblemas = $claveP";
 $con = mysqli_query($connLocalhost, $queryConsultaClave) or trigger_error("El query de inserción de problema falló");
 $dato=mysqli_fetch_assoc($con);

 $idD=$dato['idDepartamento'];
 $idC=$dato['idCentroTrabajo'];
 $idE=$dato['idEmpleado'];
 $departamentos="SELECT * FROM Departamentos where clave = $idD";
 $centroTrabajo="SELECT * FROM CentrosTrabajo where clave = $idC";
 $empleado="SELECT * FROM empleados where numeroEmpleado = $idE";


    
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
					<h1 class="mt-4">Detalles</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="./../Visualizar/principal.php">Principal</a></li>
            <li class="breadcrumb-item"><a href="./../Visualizar/Problemas.php">Problemas</a></li>
						<li class="breadcrumb-item active"><a href="">Detalles</a></li>
					</ol>
					
				
         
           
            <form action="Detalles.php" method='post'>
        <div class="user-details">
          <div class="input-box">
            <span class="details">Clave</span>
            <input  readonly type="text" name="claveProblemas" placeholder="" value="<?php echo  $dato['claveProblemas']; ?>" />
          </div>
          <div class="input-box">
            <span   class="details">Correo para</span>
            <input readonly   type="email" name="correoDestinatario" placeholder="" value="<?php echo $_SESSION['correoReceptor']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Nombre del problema</span>
            <input readonly type="text" name="nombreP" placeholder="" value="<?php echo $dato['nombreP']; ?>" />
          </div>
          <div class="input-box">
            <span class="details">Fecha</span>
            <input readonly type="text" name="fecha" placeholder="<?php echo $fechaActual = date('d-m-Y');?>" value="<?php echo $dato['fecha'];  ?>" />
          </div>
          <div class="input-box">
            <span class="details">Detalles</span>
           
            <textarea readonly name="detalles" rows="5" cols="214" placeholder=" "><?php echo $dato['detalles']; ?></textarea>
          </div>
          <div class="input-box">
            <span class="details">Estado</span>
      
            <input readonly type="text" name="estadoP" placeholder="<?php ;?>" value="<?php echo $dato['estadoP'];  ?>" />
         
          </div>
         
          <div class="input-box">
            <span class="details">Departamento</span>
            <script> 
             function cambio(){
          	document.getElementById("nombreD").value = document.getElementById("departamento").innerText}
              </script> 


            <select readonly class="caja-departamento" id = "departamento"name="departamento" onchange="cambio()">
        
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

            <select readonly class="caja-departamento" name="centroTrabajo">
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

            <select readonly class="caja-departamento" name="empleado">
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
            
            <input readonly type="text" id="Prioridad" name="Prioridad" value="<?php echo $dato['Prioridad']; ?>">
           
          </div>

        
          
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