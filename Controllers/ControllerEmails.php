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
    { parent::__construct();
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
    //$this->mail->addCC('juanlebron@harbest.net', 'JUAN LEBRON');
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isHTML(); }

    public function sendmailnotif($dat)
    {
    $query = "CALL SENDMAIL_NOTIF(?)";
    $exec = $this->conectdb->prepare($query);
    $exec->bindParam(1, $dat, PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() > 0) {
    $value = $exec->fetch(PDO::FETCH_ASSOC);
    $exec->closeCursor();

    $replacements = array(
    "[Nombre del Cliente]" => $value["NOCLT"],
    "[Número de Notificación]" => $value["NONOTIF"],
    "[Nombre del Impuesto]" => $value["NOIMPU"],
    "[Año]" => $value["AIMPU"],
    "[NOMBRE EJECUTIVO]" => GetInfo('NOMBRES').' '.GetInfo('APELLIDOS'),
    "[EMAIL EJECUTIVO]" => GetInfo('EMAIL')
    );

    $modelo = str_replace(array_keys($replacements), $replacements, file_get_contents("../Data/modelos/notifinconsis.html"));

    $this->mail->addAddress($value["EMCLT"], $value["NOCLT"]);
    $this->mail->Subject = mb_convert_encoding('Notificación de Impuestos Internos - Acción Requerida', "UTF-8", "auto");
    $this->mail->Body = $modelo;
    
    $filename = 'Carta de notificación de inconsistencia.' . explode('/', $value["MIME"])[1];

    $archivo_temporal = tempnam(sys_get_temp_dir(), 'Carta_de_notificación_de_inconsistencia');
    file_put_contents($archivo_temporal, base64_decode($value["CARTA"]));

    $this->mail->addAttachment($archivo_temporal,$filename);

    if ($this->mail->send()) {
    $RES = "UPDATE EMAILS_NOTIF SET ESTATUS = 'T' WHERE ID_NOTIF = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindParam(1, $value["ID_NOTIF"], PDO::PARAM_INT);
    $RES1->execute();
    $this->res['success'] = true;
    $this->res['message'] = 'EEC';}
    
    else { $this->res['success'] = false;
    $this->res['message'] = 'EECE';
    SUMBLOCKUSER(); }

    }
    else { $this->res['error'] = true; SUMBLOCKUSER();}

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
