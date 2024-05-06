<?php
use PHPMailer\PHPMailer\PHPMailer;

if (strpos($_SERVER['REQUEST_URI'], 'notifinconsis.php') === false) { 

class EmailSender extends ConexionDB{

    private $conectdb;
    private $mail;
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
    $this->mail->setFrom('ramonemili15@gmail.com', 'LR Consultoria');
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isHTML(true);
    }

    public function sendmailnotif($dat){

    $query = "CALL SENDMAIL_NOTIF(?)";
    $exec = $this->conectdb->prepare($query);
    $exec->bindParam(1, $dat, PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() > 0) {
    $value = $exec->fetch(PDO::FETCH_ASSOC);
    $exec->closeCursor();

    $modelo = file_get_contents("../Data/modelos/notifinconsis.html");
    $modelo = str_replace("[Nombre del Cliente]", $value["NOCLT"], $modelo);
    $modelo = str_replace("[Número de Notificación]", $value["NONOTIF"], $modelo);
    $modelo = str_replace("[Nombre del Impuesto]", $value["NOIMPU"], $modelo);
    $modelo = str_replace("[Año]", $value["AIMPU"], $modelo);
    $modelo = str_replace("[NOMBRE EJECUTIVO]", GetInfo('NOMBRES').' '.GetInfo('APELLIDOS'), $modelo);
    $modelo = str_replace("[EMAIL EJECUTIVO]",GetInfo('EMAIL'), $modelo); 

    $this->mail->addAddress($value["EMCLT"], $value["NOCLT"]);
    $this->mail->Subject = mb_convert_encoding('Notificación de Impuestos Internos - Acción Requerida', "UTF-8", "auto");
    $this->mail->Body = $modelo;
    
    $mime = explode('/',$value["MIME"]);

    $filename = 'Carta de notificación de inconsistencia.'.$mime[1];

    $archivo_temporal = tempnam(sys_get_temp_dir(), 'Carta_de_notificación_de_inconsistencia');
    file_put_contents($archivo_temporal, base64_decode($value["CARTA"]));
        
    $this->mail->addAttachment($archivo_temporal,$filename);

    if ($this->mail->send()) {
    $RES = "UPDATE EMAILS_NOTIF SET ESTATUS = 'T' WHERE ID_NOTIF = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindParam(1, $value["ID_NOTIF"], PDO::PARAM_INT);
    $RES1->execute();
    $this->res['success'] = true;
    $this->res['message'] = 'EEC';
    }
    
    else { 
    $this->res['success'] = false;
    $this->res['message'] = 'EECE';
    }

    } 
    
    else { $this->res['error'] = true; }

    return $this->res;
    }

    }}

    else 
    {header('LOCATION: ./404');}
?>
