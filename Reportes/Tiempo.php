<?php
include("./../conexionBD/conexion.php");
/*
*Retomamos la sesión
*/
session_start();
//Comprobamos que la sesión ya ha sido realizada, si no lo llevara al login
if (!isset($_SESSION['id'])) {
    header("Location: ./../login.php");
}
$numero = "02";
$sql = "SELECT * From Problemas
Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
Inner join Soluciones on Soluciones.idProblema = Problemas.claveProblemas
Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo   ORDER BY claveProblemas ASC
";

$resultado = mysqli_query($connLocalhost, $sql);









?>

<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reporte pdf</title>
    <link href="Http://<?php echo $_SERVER['HTTP_HOST']; ?>/GestionProblemas/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Reporte</h1>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>


                <tr>
                    <th>Clave</th>
                    <th>Problema</th>

                    <th>fecha</th>
                    <th>Solucion</th>
                    <th>Fecha</th>
                  




                </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
                <!--Se realiza la consulta con la sentencia anteriormente defenida en la linea 11, dicha consulta solicita los datos de reportes-->

                <?php $resultado = mysqli_query($connLocalhost, $sql);

                while ($row = mysqli_fetch_assoc($resultado)) { ?>

                    <?php 
                    ?>
                    <tr>
                        <!---->
                        <td><?php echo $row['claveProblemas']; ?></td>

                        <td><?php echo $row['nombreP']; ?></td>

                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['fechaS']; ?></td>

                     



                    </tr>

                <?php } ?>






            </tbody>
        </table>

    </div>
</body>

</html>

<?php
$html = ob_get_clean();
require_once('./../libraries/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$dompdf = new Dompdf();


$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->load_html($html);
$dompdf->setPaper('B4', 'landscape');
$dompdf->render();
$dompdf->stream("Reporte_.pdf", array("Attachment" => false));
?>