<?php
use PHPMailer\PHPMailer\PHPMailer;

if (strpos($_SERVER['REQUEST_URI'], 'ControllerEmails.php') === false) { 

class EmailSender extends ConexionDB{

    private $conectdb;
    private $mail;
    private $res;

    private $days = array(
    "january" => "enero",
    "february" => "febrero",
    "march" => "marzo",
    "april" => "abril",
    "may" => "Mayo",
    "june" => "junio",
    "july" => "julio",
    "august" => "agosto",
    "september" => "septiembre",
    "october" => "octubre",
    "november" => "noviembre",
    "december" => "diciembre",
    "Monday" => "Lunes",
    "Tuesday" => "Martes",
    "Wednesday" => "Miércoles",
    "Thursday" => "Jueves",
    "Friday" => "Viernes",
    "Saturday" => "Sábado",
    "Sunday" => "Domingo");


    public function __construct()
    { 
    parent::__construct();
    $this->conectdb = $this->obtenerConexion();
    $this->mail = new PHPMailer(true);
    $this->mail->isSMTP();
    $this->mail->Host = 'smtp-mail.outlook.com';
    $this->mail->SMTPAuth = true;
    $this->mail->Username = 'impuestos@harbest.net';
    $this->mail->Password = 'Juy65928';
    $this->mail->SMTPSecure = 'tls'; // tls o ssl
    $this->mail->Port = 587; // Puerto de SMTP
    $this->mail->setFrom('impuestos@harbest.net', 'LR CONSULTORIA INTEGRAL');
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isHTML(); 
    }


    private function MDFCC($idn,$cc) : void
    {
        $MDF = "CALL SP_ADD_CC(?,?)";
        $RES1 = $this->conectdb->prepare($MDF);
        $RES1->bindParam(1, $idn, PDO::PARAM_INT);
        $RES1->bindParam(2, $cc, PDO::PARAM_STR);
        $RES1->execute(); 
    }
    

    public function sendmailnotif($dat,$cc)
    {
    $query = "CALL SENDMAIL_NOTIF(?)";
    $exec = $this->conectdb->prepare($query);
    $exec->bindParam(1, $dat, PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() === 0) {return HandleError();}
    
    $value = $exec->fetch(PDO::FETCH_ASSOC);
    $exec->closeCursor();

    $Notif = ArrayFormat(json_decode($value["NONOTIF"]));

    $Impu = ArrayFormat(json_decode($value["IMPU"]));
    
    $replacements = array(
    "[Nombre del Cliente]" => $value["NOCLT"],
    "[Número de Notificación]" => $Notif,
    "[Nombre del Impuesto]" => $Impu,
    "[NOMBRE EJECUTIVO]" => GetInfo('Nombres').' '.GetInfo('Apellidos'),
    "[EMAIL EJECUTIVO]" => GetInfo('Email')
    );

    $arch = $value["SIZE"] == 1 ? file_get_contents("../Data/modelos/notifinconsis.html") : file_get_contents("../Data/modelos/notifinconsis2.html");
    
    $modelo = str_replace(array_keys($replacements), $replacements, $arch);

    $this->mail->addReplyTo(GetInfo('Email'), GetInfo('Nombres').' '.GetInfo('Apellidos'));
    $this->mail->addAddress($cc[0]);
    $this->mail->Subject = mb_convert_encoding('Notificación de Impuestos Internos - Acción Requerida', "UTF-8", "auto");
    $this->mail->Body = $modelo;

    $archivos = json_decode($value["CARTA"], true);

    foreach ($archivos as $inconsistencia) 
    {
    $archivo_temporal = tempnam(sys_get_temp_dir(), 'Archivo');
            
    file_put_contents($archivo_temporal, base64_decode($inconsistencia['CARTA']));
        
    $this->mail->addAttachment($archivo_temporal, $inconsistencia['NOMBRE']);   
    }

    if(count($cc) > 1)
    {
    $ccvalue = array_slice($cc,1);
    foreach($ccvalue as $CC) { $this->mail->addCC($CC); }
    $this->MDFCC($value["IDNotif"],json_encode($ccvalue));
    }

    if ($this->mail->send()) 
    {
    $RES = "UPDATE EMAILS_NOTIF SET Estatus = 'T' WHERE IDNotif = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindParam(1, $value["IDNotif"], PDO::PARAM_INT);
    $RES1->execute();
    $this->res['success'] = true;
    $this->res['message'] = 'EEC1';
    }
    
    else { 
    $this->res['success'] = false;
    $this->res['message'] = 'EECE';
    SUMBLOCKUSER(); 
    }

    return $this->res;
    }


    public function sendmailddc($dat){

    $query = "CALL SENDMAIL_DDC(?)";
    $exec = $this->conectdb->prepare($query);
    $exec->bindParam(1, $dat, PDO::PARAM_INT);
    $exec->execute();
    
    if ($exec->rowCount() > 0) {
    $value = $exec->fetch(PDO::FETCH_ASSOC);
    $exec->closeCursor();
    
    $modelo = file_get_contents("../Data/modelos/detallescitacion.html");

    $fecha = new DateTime($value["FECHAVenci"]);
    
    $fecha_completa = str_replace(array_keys($this->days), $this->days, ucfirst(strtolower($fecha->format('l j \d\e F \d\e Y'))));

    $array = json_decode($value["INCONSISTENCIAS"], true);

    $inconsistencias = "";

    foreach ($array as $elemento) {
    $elemento = str_replace(["\r\n\r\n", "\r\n"], "<br>", $elemento);
    $inconsistencias .= '<li>' . $elemento . '</li><br>';
    }

    $inconsistencias = substr($inconsistencias, 0, strrpos($inconsistencias, "<br>"));

    $replacements = array(
    "[NOMBRE CLIENTE]" => $value["NOMBRE_CLIENTE"],
    "[NOTIFICACION INCONSISTENCIA]" => $value["NOTIFICACION"],
    "[FECHA VENCIMIENTO]" => $fecha_completa,
    "[NOMBRE EJECUTIVO]" => GetInfo('NOMBRES').' '.GetInfo('APELLIDOS'),
    "[EMAIL EJECUTIVO]" => GetInfo('EMAIL'),
    "[DETALLES INCONSISTENCIAS]" => $inconsistencias
    );

    $modelo = str_replace(array_keys($replacements), $replacements, $modelo);

    $this->mail->addAddress($value["EMAIL_CLIENTE"], $value["NOMBRE_CLIENTE"]);
    $this->mail->Subject = mb_convert_encoding('Detalle de citación sobre inconsistencia DGII', "UTF-8", "auto");
    $this->mail->Body = $modelo;
        
    $archivos = json_decode($value["ARCHIVOS"], true);

    foreach ($archivos as $inconsistencia) 
    {
    $archivo_temporal = tempnam(sys_get_temp_dir(), 'Detalle_de_citacion');
            
    file_put_contents($archivo_temporal, base64_decode($inconsistencia['archivo']));
        
    $this->mail->addAttachment($archivo_temporal, $inconsistencia['name']);   
    }

    if ($this->mail->send()) {
    $RES = "UPDATE EMAILS_DDC SET ESTATUS = 'T' WHERE ID_DDC = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindParam(1, $value["ID_DDC"], PDO::PARAM_INT);
    $RES1->execute();
    $this->res['success'] = true;
    $this->res['message'] = 'EEC';
    }
        
    else { 
    $this->res['success'] = false;
    $this->res['message'] = 'EECE';
    SUMBLOCKUSER();
    }
    
    }     
    else { 
    $this->res['error'] = true; 
    SUMBLOCKUSER();
    }
    
    return $this->res;
    }



    }}

    else 
    {header('LOCATION: ./404');}
?>
