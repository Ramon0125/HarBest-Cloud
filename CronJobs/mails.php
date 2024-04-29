<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 if (strpos($_SERVER['REQUEST_URI'], 'sendmail.php') === false) 
{ 
    require '../vendor/autoload.php';
    require '../Controllers/Conexion.php';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ramonemili15@gmail.com';
    $mail->Password = 'ewla zixa twmy wkcf';
    $mail->SMTPSecure = 'tls'; // tls o ssl
    $mail->Port = 587; // Puerto de SMTP
    $mail->setFrom('ramonemili15@gmail.com', 'Prueba HarBest');
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    $hora = date('Y-m-d H:i:s');
    
    $conect = new ConexionDB();
    $conectdb = $conect->obtenerConexion();

    $query = "CALL SENDMAIL_NOTIF(?,NULL)";
    $exec = $conectdb->prepare($query);
    $exec->bindParam(1,$hora,PDO::PARAM_STR);
    $exec->execute();
    
    if($exec->rowCount() > 0){
    $res = $exec->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $value) {
    $modelo = file_get_contents("../Data/modelos/notifinconsis.html");
    $modelo = str_replace("[Nombre del Cliente]",$value["NOCLT"],$modelo);
    $modelo = str_replace("[Número de Notificación]",$value["NONOTIF"],$modelo);
    $modelo = str_replace("[Nombre del Impuesto]",$value["NOIMPU"],$modelo);
    $modelo = str_replace("[Año]",$value["AIMPU"],$modelo);   

    $mail->addAddress($value["EMCLT"], $value["NOCLT"]);
    $mail->Subject = mb_convert_encoding('Asunto: Notificación de Impuestos Internos - Acción Requerida', "UTF-8", "auto");
    $mail->Body= $modelo;
    $archivo_adjunto = '../Data/logo.ico'; // Ruta al archivo que deseas adjuntar
    $mail->addAttachment($archivo_adjunto);


    if($mail->send()) {
     $exec->closeCursor();
     $RES = "UPDATE EMAILS_STATUS SET ESTATUS = 'T' WHERE NO_PROTOCOLO = ?";
     $RES1 = $conectdb->prepare($RES);
     $RES1->bindParam(1,$value["NONOTIF"],PDO::PARAM_STR);
     $RES1->execute();
    }

    }
    }

}
else { header("LOCATION: ./404");}