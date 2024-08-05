<?php

if (preg_match('/ControllerEmails(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

use PHPMailer\PHPMailer\PHPMailer;

class EmailSender extends ConexionDB
{
    private $conectdb;
    private $mail;
    private $res;
    private $user;

    public function __construct()
    { 
    parent::__construct();
    $this->conectdb = $this->obtenerConexion();
    $this->mail = new PHPMailer(true);
    $this->mail->isSMTP();
    $this->mail->Host = $_ENV['MAIL_HOST'];
    $this->mail->SMTPAuth = true;
    $this->mail->Username = $_ENV['MAIL_USERNAME'];
    $this->mail->Password = $_ENV['MAIL_PASSWORD'];
    $this->mail->SMTPSecure = 'tls'; // tls o ssl
    $this->mail->Port = 587; // Puerto de SMTP
    $this->mail->setFrom($_ENV['MAIL_USERNAME'],$_ENV['COMPANY_NAME']);
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isHTML(); 
    $this->user = array(
    'Nombre' => (GetInfo('Nombres').' '.GetInfo('Apellidos')),
    'Email' => GetInfo('Email'));
    $this->mail->addReplyTo($this->user['Email'], $this->user['Nombre']);
    }


    private function MDFCC($idn,$cc,$type) : void
    {
        $SPName = array(1 => 'NTF', 2 => 'DDC', 3 => 'EDD');

        $SPCall = "CALL SP_ADD_CC_".$SPName[$type]."(?,?)";
        $RES1 = $this->conectdb->prepare($SPCall);
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
    foreach ((array) $Archivos as $inconsistencia) 
    {
     $archivo_temporal = tempnam(sys_get_temp_dir(), $inconsistencia['NOMBRE']);
                
     file_put_contents($archivo_temporal, base64_decode($inconsistencia['CARTA']));
            
     $this->mail->addAttachment($archivo_temporal, $inconsistencia['NOMBRE']);  
    }
    }


    private function AddCCToMail($cc,$IDReg,$Type)
    {
     if(count($cc) > 1)
     {
      $ccvalue = array_slice($cc,1);

      foreach((array) $ccvalue as $CC) { $this->mail->addCC($CC); }

      $this->MDFCC($IDReg,json_encode($ccvalue),$Type);
     }
    }

    private function MailHead(string $NombreCliente) : string
    {
      return str_replace('[NOMBRE_CLIENTE]',$NombreCliente,file_get_contents(APP_URL.'Data/modelos/HeadEmail.html'));
    }

    private function MailFoot()
    {
      $Replacement = array('[NOMBRE_EJECUTIVO]' => $this->user['Nombre'],'[EMAIL_EJECUTIVO]' => $this->user['Email']);
      return str_replace(array_keys($Replacement),$Replacement,file_get_contents(APP_URL.'Data/modelos/FootEmail.html'));
    }


    private function SendMail(int $IDReg, int $Type)
    {
    $Table = array(1 => 'EMAILS_NOTIF', 2 => 'EMAILS_DETALLE', 3 => 'EMAILS_ESCRITO');
    $Col = array(1 => 'IDNotif', 2 => 'IDDetalle', 3 => 'IDEscrito');

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
    
    $replacements = array(
    "[Nombre del Cliente]" => $value["NOCLT"],
    "[Número de Notificación]" => ArrayFormat(json_decode($value["NONOTIF"])),
    "[Nombre del Impuesto]" => ArrayFormat(json_decode($value["IMPU"])),
    "[NOMBRE EJECUTIVO]" => $this->user['Nombre'],
    "[EMAIL EJECUTIVO]" => $this->user['Email'],
    "[FECHAMAXIMA]" => $this->DateFormat($value["VENCIMIENTO"]),
    "[TipoPersona]" => $value["TipoCliente"] == "Fisica" ? "" : "con el <u>sello</u> de la empresa "
    );

    $arch = file_get_contents("../Data/modelos/notifinconsis". ($value["SIZE"] == 1 ? "" : "2") .".html");
    
    $modelo = str_replace(array_keys($replacements), $replacements, $arch);

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
        
    $value = $exec->fetch();
    $exec->closeCursor();
    
    $Detalles = json_decode($value["INCONSISTENCIAS"], true);

    $inconsistencias = "";

    foreach ((array) $Detalles as $values) 
    {
      $inconsistencias .= '<li style="text-align: justify;">Inconsistencia '.$values["NOTIFICACION"].'<br>';
          
      foreach ((array) $values["DETALLES"] as $values2) 
      { 
        $inconsistencias .= ($values2['Detalle'].', periodo '.substr($values2['Periodo'],0,4).'-'.substr($values2['Periodo'],4).' por valor de RD$'.$values2['Valor'].'<br>'); 
      }
          
      $inconsistencias .= '</li><br>';
    }
    
    $replacements = array(
    "[NOMBRE CLIENTE]" => $value["NombreCliente"],
    "[NOTIFICACION INCONSISTENCIA]" => ArrayFormat(array_column($Detalles,"NOTIFICACION")),
    "[DETALLES INCONSISTENCIAS]" => $inconsistencias,
    "[NOMBRE EJECUTIVO]" => $this->user['Nombre'],
    "[EMAIL EJECUTIVO]" => $this->user['Email'],
    "[FECHA VENCIMIENTO]" => $this->DateFormat($value["FechaVenci"])
    );
    
    $Template = file_get_contents("../Data/modelos/detallescitacion". ($value["SIZE"] == 1 ? "" : "2") .".html");
        
    $modelo = str_replace(array_keys($replacements), $replacements, $Template);
    
    $this->mail->addAddress($cc[0]);

    $this->mail->Subject = mb_convert_encoding('Detalle de citación sobre inconsistencia DGII - '.$value["NombreCliente"], "UTF-8", "auto");
        
    $this->mail->Body = $modelo;

    $this->AddAtachmentToMail(json_decode($value["ARCHIVOS"], true));
    
    $this->AddCCToMail($cc,$value["IDDetalle"],2);

    $this->SendMail($value["IDDetalle"],2);
    
    return $this->res;
    }


    function SendMailEscrito(int $IDEscrito, array $cc): array
    {
        // Llamada al procedimiento almacenado para obtener los datos del escrito
        $query = "CALL SENDMAIL_ESCRITO(?)";
        $exec = $this->conectdb->prepare($query);
        $exec->bindParam(1, $IDEscrito, PDO::PARAM_INT);
        $exec->execute();
        
        // Manejo de errores si no se encontraron resultados
        if ($exec->rowCount() === 0) { return HandleError(); }

        $value = $exec->fetch();
        $exec->closeCursor();
    
        // Reemplazos en el template del correo
        $replacements = array(
        "[NOTIFICACIONES]" => ArrayFormat(json_decode($value['NONOTIF'],true)),
        "[FECHANOTIF]" => $this->DateFormat($value["FechaNotif"])
        );
        
        // Leer el template del correo
        $templatePath = APP_URL . "Data/modelos/escritodescargo" . ($value["SIZE"] == 1 ? "" : "2") . ".html";
        $template = file_get_contents($templatePath);
        
        // Construir el cuerpo del correo
        $modelo = ($this->MailHead($value['NombreCliente'])) .
                  (str_replace(array_keys($replacements), $replacements, $template)) .
                  ($this->MailFoot());
        
        // Configurar destinatario, asunto y cuerpo del correo
        $this->mail->addAddress($cc[0]);
        $this->mail->Subject = mb_convert_encoding('Escrito de descargo sobre inconsistencia DGII - ' . $value["NombreCliente"], "UTF-8", "auto");
        $this->mail->Body = $modelo;
    
        // Añadir adjuntos y CC
        $this->AddAtachmentToMail(json_decode($value["ArchivoEscrito"], true));
        $this->AddCCToMail($cc, $value["IDEscrito"], 3);
    
        // Enviar el correo
        $this->SendMail($value["IDEscrito"], 3);
    
        return $this->res;
    }
    
}
?>
