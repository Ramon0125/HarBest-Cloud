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


    private function MDFCC($idn,$cc,$type) : void
    {
        $MDF = $type === 1 ? "CALL SP_ADD_CC(?,?)" : "CALL SP_ADD_CC_DDC(?,?)";
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

    $fecha = new DateTime($value["VENCIMIENTO"]);
    
    $fecha_completa = str_replace(array_keys($this->days), $this->days, ucfirst(strtolower($fecha->format('l j \d\e F \d\e Y'))));
    
    $replacements = array(
    "[Nombre del Cliente]" => $value["NOCLT"],
    "[Número de Notificación]" => $Notif,
    "[Nombre del Impuesto]" => $Impu,
    "[NOMBRE EJECUTIVO]" => GetInfo('Nombres').' '.GetInfo('Apellidos'),
    "[EMAIL EJECUTIVO]" => GetInfo('Email'),
    "[FECHAMAXIMA]" => $fecha_completa
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
    $this->MDFCC($value["IDNotif"],json_encode($ccvalue),1);
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


    public function sendmailddc($dat,$cc)
    {

        $query = "CALL SENDMAIL_DETALLE(?)";
        $exec = $this->conectdb->prepare($query);
        $exec->bindParam(1, $dat, PDO::PARAM_INT);
        $exec->execute();
    
        if ($exec->rowCount() === 0){return HandleError();}
        
        $value = $exec->fetch(PDO::FETCH_ASSOC);
        $exec->closeCursor();
    
        $Detalles = json_decode($value["INCONSISTENCIAS"], true);

        $inconsistencias = "";

        foreach ($Detalles as $DataIncon) 
        {
          $inconsistencias .= '<li>Inconsistencia '.$DataIncon["NOTIFICACION"].'<br>';
          
          foreach ($DataIncon["DETALLES"] as $DataDetalles) 
          { $inconsistencias .= $DataDetalles.'<br>'; }
          
          $inconsistencias .= '<br></li>';
        }
 
        $fecha = new DateTime($value["FECHAVenci"]);
        
        $fecha_completa = str_replace(array_keys($this->days), $this->days, ucfirst(strtolower($fecha->format('l j \d\e F \d\e Y'))));
        

        $replacements = array(
        "[NOMBRE CLIENTE]" => $value["NombreCliente"],
        "[NOTIFICACION INCONSISTENCIA]" => ArrayFormat(json_decode($value["NOTIFICACION"])),
        "[DETALLES INCONSISTENCIAS]" => $inconsistencias,
        "[NOMBRE EJECUTIVO]" => GetInfo('Nombres').' '.GetInfo('Apellidos'),
        "[EMAIL EJECUTIVO]" => GetInfo('Email'),
        "[FECHA VENCIMIENTO]" => $fecha_completa
        );
    
        $arch = file_get_contents("../Data/modelos/detallescitacion.html");
        
        $modelo = str_replace(array_keys($replacements), $replacements, $arch);
    
        $this->mail->addReplyTo(GetInfo('Email'), GetInfo('Nombres').' '.GetInfo('Apellidos'));
        $this->mail->addAddress($cc[0]);
        $this->mail->Subject = mb_convert_encoding('Detalle de citación sobre inconsistencia DGII', "UTF-8", "auto");
        $this->mail->Body = $modelo;
    
        $archivos = json_decode($value["ARCHIVOS"], true);
    
        foreach ($archivos as $documentos) 
        {
        $archivo_temporal = tempnam(sys_get_temp_dir(), 'Archivo');
                
        file_put_contents($archivo_temporal, base64_decode($documentos['CARTA']));
            
        $this->mail->addAttachment($archivo_temporal, $documentos['NOMBRE']);   
        }
    
        if(count($cc) > 1)
        {
        $ccvalue = array_slice($cc,1);
        foreach($ccvalue as $CC) { $this->mail->addCC($CC); }
        $this->MDFCC($value["IDDetalle"],json_encode($ccvalue),2);
        }
    
        if ($this->mail->send()) 
        {
        $RES = "UPDATE EMAILS_DETALLE SET Estatus = 'T' WHERE IDDetalle = ?";
        $RES1 = $this->conectdb->prepare($RES);
        $RES1->bindParam(1, $value["IDDetalle"], PDO::PARAM_INT);
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



    }}

    else 
    {header('LOCATION: ./404');}
?>
