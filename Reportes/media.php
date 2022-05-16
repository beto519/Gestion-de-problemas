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
$codigoE = $_SESSION['numeroEmpleado'];
$EstadoProblemas = "Realizado";


    $reportes = "SELECT * FROM Problemas";
    $sql = "SELECT * From Problemas
    Inner join Departamentos on Departamentos.clave = Problemas.idDepartamento
    Inner join empleados on empleados.numeroEmpleado = Problemas.idEmpleado
    Inner join CentrosTrabajo on CentrosTrabajo.clave = Problemas.idCentroTrabajo
    where Problemas.Prioridad ='Media'
    ORDER BY claveProblemas desc
    ";




$resultado = mysqli_query($connLocalhost, $sql);

while ($row = mysqli_fetch_assoc($resultado)) {
}
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

            </tfoot>
            <tbody>
                <!--Se realiza la consulta con la sentencia anteriormente defenida en la linea 11, dicha consulta solicita los datos de reportes-->

                <?php $resultado = mysqli_query($connLocalhost, $sql);

                while ($row = mysqli_fetch_assoc($resultado)) { ?>


                    <tr>
                        <!---->
                        <td><?php echo $row['claveProblemas']; ?></td>

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