<?php
	
	session_start();
	
	if(!isset($_SESSION['id'])){
		header("Location: login.php");
	}
	
	$nombre = $_SESSION['nombre'];

    include("conexionBD/conexion.php");
    $reportes="SELECT * FROM Problemas";
	
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
        <link href="css/styles.css" rel="stylesheet" />
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
                        <a class="dropdown-item" href="#">Configuración</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="includes/cerrarSesion.php">Salir</a>
					</div>
				</li>
			</ul>
		</nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="#"
							><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Correo</a
							>
							
						
							
							<div class="sb-sidenav-menu-heading"></div>
							<a class="nav-link" href="departamentos.php"
							><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
								Departamentos</a
								><a class="nav-link" href="empleados.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
									Empleados</a
								>
                                <a class="nav-link" href="centrosTrabajo.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
									Centros de trabajo</a
								>
                               
                                
							</div>
					</div>
                    <div class="sb-sidenav-footer">
                      
				</nav>
			</div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Problemas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Problemas</li>
						</ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Poca urgencia</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Urgente</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Mucha urgencia</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Atención inmediata</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Un grafico o contador proximamente</div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
								</div>
							</div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Un grafico o contador proximamente</div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
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
                                                <th>Folio</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                                <th>Empleado</th>
                                                <th>Departamento</th>
                                                <th>Centro de trabajo</th>
                                                <th>Problema</th>
                                                <th>Observaciones</th>
											</tr>
										</thead>
                                        <tfoot>
                                            <tr>
                                            <th>Folio</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                                <th>Empleado</th>
                                                <th>Departamento</th>
                                                <th>Centro de trabajo</th>
                                                <th>Problema</th>
                                                <th>Observaciones</th>
											</tr>
										</tfoot>
                                        <tbody>

                                        <?php $resultado = mysqli_query($connLocalhost, $reportes);
                                            while($row=mysqli_fetch_assoc($resultado)){?>

                                    
                                                <tr>
                                                <td><?php echo $row['clave'];?></td>
                                                <td><?php echo $row['clave'];?></td>
                                                <td><?php echo $row['fecha'];?></td>
                                                <td><?php echo $row['estado'];?></td>
                                                <td><?php echo $row['nombre'];?></td>
                                                <td><?php echo $row['detalles'];?></td>
                                                <td><?php echo $row['estado'];?></td>
                                                <td><?php echo $row['estado'];?></td>
                                                </tr>
                                           
                                            <?php }?>


                                            
                                           
                                        
                                          
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
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="demo/chart-area-demo.js"></script>
        <script src="demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="demo/datatables-demo.js"></script>
	</body>
</html>
