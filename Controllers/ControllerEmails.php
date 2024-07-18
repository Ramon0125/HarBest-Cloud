<?php
use PHPMailer\PHPMailer\PHPMailer;

if (strpos($_SERVER['REQUEST_URI'], 'ControllerEmails.php') === false) { 

class EmailSender extends ConexionDB
{
    private $conectdb;
    private $mail;
    private $res;

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
        $MDF = "CALL SP_ADD_CC".($type === 1 ? "" : "_DDC")."(?,?)";
        $RES1 = $this->conectdb->prepare($MDF);
        $RES1->bindParam(1, $idn, PDO::PARAM_INT);
        $RES1->bindParam(2, $cc, PDO::PARAM_STR);
        $RES1->execute(); 
    }


    private function DateFormat($Date)
    {
     $days = array(
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
     "Friday" => "Viernes");

     $ConvertToDateTime = new DateTime($Date);
     $DateWithDays = str_replace(array_keys($days), $days, ucfirst(strtolower($ConvertToDateTime->format('l j \d\e F \d\e Y'))));

     return $DateWithDays;
    }
    
    private function AddAtachmentToMail($Archivos)
    {
    foreach ($Archivos as $inconsistencia) 
    {
     $archivo_temporal = tempnam(sys_get_temp_dir(), 'Archivo');
                
     file_put_contents($archivo_temporal, base64_decode($inconsistencia['CARTA']));
            
     $this->mail->addAttachment($archivo_temporal, $inconsistencia['NOMBRE']);   
    }
    }


    private function AddCCToMail($cc,$IDReg,$Type)
    {
     if(count($cc) > 1)
     {
      $ccvalue = array_slice($cc,1);
      foreach($ccvalue as $CC) { $this->mail->addCC($CC); }
      $this->MDFCC($IDReg,json_encode($ccvalue),$Type);
     }
    }


    private function SendMail(int $IDReg, int $Type)
    {
    $Table = array(1 => 'EMAILS_NOTIF', 2 => 'EMAILS_DETALLE');
    $Col = array(1 => 'IDNotif', 2 => 'IDDetalle');

    if ($this->mail->send()) 
    {
    $RES = "UPDATE ". $Table[$Type] ." SET Estatus = 'T' WHERE ". $Col[$Type] . " = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindParam(1, $IDReg, PDO::PARAM_INT);
    $RES1->execute();
    $this->res['success'] = true;
    $this->res['message'] = 'EEC1';
    }
    
    else 
    { 
    $this->res['success'] = false;
    $this->res['message'] = 'EECE';
    SUMBLOCKUSER(); 
    }
    }


    public function SendMailNotif($dat,$cc)
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

    $fecha_completa = $this->DateFormat($value["VENCIMIENTO"]);;
    
    $replacements = array(
    "[Nombre del Cliente]" => $value["NOCLT"],
    "[Número de Notificación]" => $Notif,
    "[Nombre del Impuesto]" => $Impu,
    "[NOMBRE EJECUTIVO]" => GetInfo('Nombres').' '.GetInfo('Apellidos'),
    "[EMAIL EJECUTIVO]" => GetInfo('Email'),
    "[FECHAMAXIMA]" => $fecha_completa,
    "[TipoPersona]" => $value["TipoCliente"] == "Fisica" ? "" : "con el <u>sello</u> de la empresa "
    );

    $arch = file_get_contents("../Data/modelos/notifinconsis". ($value["SIZE"] == 1 ? "" : "2") .".html");
    
    $modelo = str_replace(array_keys($replacements), $replacements, $arch);

    $this->mail->addReplyTo(GetInfo('Email'), GetInfo('Nombres').' '.GetInfo('Apellidos'));

    $this->mail->addAddress($cc[0]);

    $this->mail->Subject = mb_convert_encoding('Notificación de Impuestos Internos - '.$value["NOCLT"], "UTF-8", "auto");

    $this->mail->Body = $modelo;

    $this->AddAtachmentToMail(json_decode($value["CARTA"], true));

    $this->AddCCToMail($cc,$value["IDNotif"],1);

    $this->SendMail($value["IDNotif"],1);

    return $this->res;
    }


    public function SendMailDDC($dat,$cc)
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

        foreach ($Detalles as $values) 
        {
          $inconsistencias .= '<li style="text-align: justify;">Inconsistencia '.$values["NOTIFICACION"].'<br>';
          
          foreach ($values["DETALLES"] as $values2) 
          { $inconsistencias .= ($values2['Detalle'].', periodo '.substr($values2['Periodo'],0,4).'-'.substr($values2['Periodo'],4).' por valor de RD$'.$values2['Valor'].'<br>'); }
          
          $inconsistencias .= '</li><br>';
        }
  
        $fecha_completa = $this->DateFormat($value["FechaVenci"]); 
        
        $replacements = array(
        "[NOMBRE CLIENTE]" => $value["NombreCliente"],
        "[NOTIFICACION INCONSISTENCIA]" => ArrayFormat(array_column($Detalles,"NOTIFICACION")),
        "[DETALLES INCONSISTENCIAS]" => $inconsistencias,
        "[NOMBRE EJECUTIVO]" => GetInfo('Nombres').' '.GetInfo('Apellidos'),
        "[EMAIL EJECUTIVO]" => GetInfo('Email'),
        "[FECHA VENCIMIENTO]" => $fecha_completa
        );
    
        $arch = file_get_contents("../Data/modelos/detallescitacion". ($value["SIZE"] == 1 ? "" : "2") .".html");
        
        $modelo = str_replace(array_keys($replacements), $replacements, $arch);
    
        $this->mail->addReplyTo(GetInfo('Email'), GetInfo('Nombres').' '.GetInfo('Apellidos'));

        $this->mail->addAddress($cc[0]);

        $this->mail->Subject = mb_convert_encoding('Detalle de citación sobre inconsistencia DGII - '.$value["NombreCliente"], "UTF-8", "auto");
        
        $this->mail->Body = $modelo;

        $this->AddAtachmentToMail(json_decode($value["ARCHIVOS"], true));
    
        $this->AddCCToMail($cc,$value["IDDetalle"],2);

        $this->SendMail($value["IDDetalle"],2);
    
    return $this->res;
    }
}
} else {header('LOCATION: ./404');}
?>
