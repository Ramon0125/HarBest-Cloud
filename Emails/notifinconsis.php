<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender extends ConexionDB{

    private $conectdb;
    private $mail;
    private $hora;
    private $res;

    public function __construct()
    {
    parent::__construct();
    $this->conectdb = $this->obtenerConexion();
    $this->mail = new PHPMailer(true);
    $this->mail->isSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = true;
    $this->mail->Username = 'ramonemili15@gmail.com';
    $this->mail->Password = 'ewla zixa twmy wkcf';
    $this->mail->SMTPSecure = 'tls'; // tls o ssl
    $this->mail->Port = 587; // Puerto de SMTP
    $this->mail->setFrom('ramonemili15@gmail.com', 'Prueba HarBest');
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isHTML(true);
    $this->hora = date('Y-m-d H:i:s');
    }

    public function sendmailnotif($dat){

    $query = "CALL SENDMAIL_NOTIF(?,?)";
    $exec = $this->conectdb->prepare($query);
    $exec->bindParam(1, $this->hora, PDO::PARAM_STR);
    $exec->bindParam(2, $dat, PDO::PARAM_STR);
    $exec->execute();

    if ($exec->rowCount() > 0) {
    $res = $exec->fetchAll(PDO::FETCH_ASSOC);
    $exec->closeCursor();

    foreach ($res as $value) {
    $modelo = file_get_contents("../Data/modelos/notifinconsis.html");
    $modelo = str_replace("[Nombre del Cliente]", $value["NOCLT"], $modelo);
    $modelo = str_replace("[Número de Notificación]", $value["NONOTIF"], $modelo);
    $modelo = str_replace("[Nombre del Impuesto]", $value["NOIMPU"], $modelo);
    $modelo = str_replace("[Año]", $value["AIMPU"], $modelo);

    $this->mail->addAddress($value["EMCLT"], $value["NOCLT"]);
    $this->mail->Subject = mb_convert_encoding('Asunto: Notificación de Impuestos Internos - Acción Requerida', "UTF-8", "auto");
    $this->mail->Body = $modelo;
    $archivo_adjunto = '../Data/logo.ico'; // Ruta al archivo que deseas adjuntar
    $this->mail->addAttachment($archivo_adjunto);

    if ($this->mail->send()) {
    $RES = "UPDATE EMAILS_STATUS SET ESTATUS = 'T' WHERE NO_PROTOCOLO = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindParam(1, $value["NONOTIF"], PDO::PARAM_STR);
    $RES1->execute();
    $this->res['success'] = true;
    $this->res['message'] = 'EEC';
    } 
    
    else { 
    $this->res['success'] = false;
    $this->res['message'] = 'EECE';
    }
    }

    } 
    
    else { $this->res['error'] = true; }

    return $this->res;
    }

    }
?>
