<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'Mailer-PHP/Exception.php';
require 'Mailer-PHP/PHPMailer.php';
require 'Mailer-PHP/SMTP.php';




//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_SESSION['correo'];                     //SMTP username
    $mail->Password   =  $_SESSION['contraseña'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_SESSION['correo'],  $_SESSION['nombreE']);
    $mail->addAddress('lopezbeto519@gmail.com','Trabajador: Beto');     //Add a recipient


    //Attachments


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $_POST['nombre'];
    $mail->Body    = $_POST['detalles'];


    $mail->send();
    echo 'El mensaje se envio';
    header("Location: ./../Visualizar/principal.php"); 
} catch (Exception $e) {
    echo "Error al enviar el correo {$mail->ErrorInfo}";
}
?>