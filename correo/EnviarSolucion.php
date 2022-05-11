<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'Mailer-PHP/Exception.php';
require 'Mailer-PHP/PHPMailer.php';
require 'Mailer-PHP/SMTP.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$name = $_SESSION['nombreE'];
$coreoD = $_POST['correoDestinatario'];
$fecha = $_POST['fechaS'];
$estado = $_POST['nombre'];
$detalles = $_POST['detalles'];

$cuerpo = "Enviado desde Gestión de problemas<br>\n" .
    "Solución	<br>\n" .
    "Nombre: $name<br>\n" .
    "Correo para: $coreoD<br>\n" .
    "Fecha: $fecha<br>\n" .
    "Estado: $estado<br>\n" .
    "Detalles: $detalles<br>\n" .
    "";
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.' . $_SESSION['correoHost'] . '.com'; //Set the SMTP server to send through


    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_SESSION['correoReceptor'];               //SMTP username
    $mail->Password   = $_SESSION['correoPasswordReparador'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_SESSION['correoReceptor'],  $_SESSION['nombreE']);
    $mail->addAddress($_POST['correoDestinatario']);     //Add a recipient


    //Attachments


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $_POST['nombre'];
    $mail->Body    = $cuerpo;




    $mail->send();
    echo 'El mensaje se envio';
    header("Location: ./../Visualizar/Problemas.php");
} catch (Exception $e) {
    echo "Error al enviar el correo {$mail->ErrorInfo}";
}
