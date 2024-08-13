<?php

if (preg_match('/ControllerEmails(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailSender extends ConexionDB
{
    private $conectdb;
    private $mail;
    private $res;
    private $user;
    private $Archivos = array();


    public function __construct()
    {
    parent::__construct();
    $this->conectdb = $this->obtenerConexion();
    $this->user = array('Nombre' => (GetInfo('Nombres').' '.GetInfo('Apellidos')),'Email' => GetInfo('Email'));
    
    $this->mail = new PHPMailer(true);
   
    try 
    {
      $this->mail->isSMTP(); // Establecer el uso del protocolo SMTP para enviar correos
      $this->mail->Host = $_ENV['MAIL_HOST']; // Especificar el servidor SMTP a utilizar (almacenado en una variable de entorno)
      $this->mail->SMTPAuth = true; // Habilitar la autenticación SMTP
      $this->mail->Username = $_ENV['MAIL_USERNAME']; // Nombre de usuario para la autenticación SMTP (almacenado en una variable de entorno)
      $this->mail->Password = $_ENV['MAIL_PASSWORD']; // Contraseña para la autenticación SMTP (almacenado en una variable de entorno)
      $this->mail->SMTPSecure = 'tls'; // Habilitar la seguridad TLS (o 'ssl' si se prefiere)
      $this->mail->Port = 587; // Puerto a utilizar para la conexión SMTP (587 para TLS, 465 para SSL)
      $this->mail->setFrom($_ENV['MAIL_USERNAME'], $_ENV['COMPANY_NAME']); // Establecer la dirección de correo y nombre del remitente (almacenado en variables de entorno)
      $this->mail->CharSet = 'UTF-8'; // Establecer el juego de caracteres del correo a UTF-8
      $this->mail->isHTML(); // Habilitar el uso de HTML en el cuerpo del correo
      $this->mail->addReplyTo($this->user['Email'], $this->user['Nombre']); // Añadir una dirección de respuesta y nombre del usuario
    }

    catch(Exception) 
    { 
      error_log($this->mail->ErrorInfo);    
      $this->res['success'] = false;
      $this->res['message'] = 'EECE';
      SUMBLOCKUSER();  
      return $this->res;  
    }
    }


    private function ModificarCC(int $idn, string $cc, int $type) : void
    {
        $SPName = array(1 => 'NTF', 2 => 'DDC', 3 => 'EDD', 4 => 'RES');

        $SPCall = "CALL SP_ADD_CC(?,?,?)";
        $RES1 = $this->conectdb->prepare($SPCall);
        $RES1->bindParam(1,$idn,1);
        $RES1->bindParam(2,$SPName[$type]);
        $RES1->bindParam(3,$cc);
        $RES1->execute(); 
    }


    private function DateFormat(string $Date) : string
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
            
     if($this->mail->addAttachment($archivo_temporal, $inconsistencia['NOMBRE']))
     { array_push($this->Archivos,$archivo_temporal); }
     else{ throw new Exception("Error al añadir archivo al emai", 1); }
    }
    }


    private function AddCCToMail($cc,$IDReg,$Type)
    {
     if(count($cc) > 1)
     {
      $ccvalue = array_slice($cc,1);

      foreach((array) $ccvalue as $CC) { $this->mail->addCC($CC); }

      $this->ModificarCC($IDReg,json_encode($ccvalue),$Type);
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
    $Table = array(1 => 'EMAILS_NOTIF', 2 => 'EMAILS_DETALLE', 3 => 'EMAILS_ESCRITO', 4 => 'EMAILS_RESPUESTA');
    $Col = array(1 => 'IDNotif', 2 => 'IDDetalle', 3 => 'IDEscrito', 4 => 'IDRespuesta');

    if ($this->mail->send()) 
    {
    $RES = "UPDATE ". $Table[$Type] ." SET Estatus = 'T', HoraEnvio = ? WHERE ". $Col[$Type] . " = ?";
    $RES1 = $this->conectdb->prepare($RES);
    $RES1->bindValue(1, date('Y-m-d H:i:s'));
    $RES1->bindParam(2, $IDReg, 1);
    $RES1->execute();

    if ($this->Archivos != []) { foreach ($this->Archivos as $Key) { unlink($Key);} }

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
      try {

      // Llamada al procedimiento almacenado para obtener los datos de la notificacion
      $query = "CALL SENDMAIL_NOTIF(?)";
      $exec = $this->conectdb->prepare($query);
      $exec->bindParam(1, $dat, 1);
      $exec->execute();

      // Manejo de errores si no se encontraron resultados
      if ($exec->rowCount() === 0) {return HandleError();}
    
      $value = $exec->fetch();
      $exec->closeCursor();

      // Reemplazos en el template del correo
      $replacements = array(
      "[NO_NOTIFICACION]" => ArrayFormat(json_decode($value["NONOTIF"])),
      "[NO_IMPUESTO]" => ArrayFormat(json_decode($value["IMPU"])),
      "[FECHA_MAXIMA]" => $this->DateFormat($value["VENCIMIENTO"]),
      "[TIPO_PERSONA]" => $value["TipoCliente"] == "Fisica" ? "" : "con el <u>sello</u> de la empresa "
      );

      // Leer el template del correo
      $templatePath = APP_URL . "Data/modelos/notifinconsis" . ($value["SIZE"] == 1 ? "" : "2") . ".html";
      $template = file_get_contents($templatePath);
    
      // Construir el cuerpo del correo
      $modelo = ($this->MailHead($value['NOCLT'])) .
                (str_replace(array_keys($replacements), $replacements, $template)) .
                ($this->MailFoot());

      // Configurar destinatario, asunto y cuerpo del correo
      $this->mail->addAddress($cc[0]);
      $this->mail->Subject = mb_convert_encoding('Notificación de Impuestos Internos - '.$value["NOCLT"], "UTF-8", "auto");
      $this->mail->Body =  $modelo;

      // Añadir adjuntos y CC
      $this->AddAtachmentToMail(json_decode($value["CARTA"], true));
      $this->AddCCToMail($cc,$value["IDNotif"],1);

      // Enviar el correo
      $this->SendMail($value["IDNotif"],1);
      
      }catch( Exception $e) { error_log($e->getMessage()); return HandleError();}

    return $this->res;
    }


    public function SendMailDDC($dat,$cc)
    {
      try {

      // Llamada al procedimiento almacenado para obtener los datos del detalle de citacion      
      $query = "CALL SENDMAIL_DETALLE(?)";
      $exec = $this->conectdb->prepare($query);
      $exec->bindParam(1, $dat, 1);
      $exec->execute();

      // Manejo de errores si no se encontraron resultados
      if ($exec->rowCount() === 0){return HandleError();}
        
      $value = $exec->fetch();
      $exec->closeCursor();

      // Preparamos la manera de mostrar las inconsistencias
      $Detalles = json_decode($value["INCONSISTENCIAS"], true);
      $inconsistencias = "";
      
      foreach ($Detalles as $detalle) 
      {
          $inconsistencias .= '<li style="text-align: justify;">Inconsistencia ' . htmlspecialchars($detalle["NOTIFICACION"]) . '<br>';
          
          foreach ((array) $detalle["DETALLES"] as $detalleInner) 
          {
              $periodo = substr($detalleInner['Periodo'], 0, 4) . '-' . substr($detalleInner['Periodo'], 4);
              $valor = $detalleInner['Valor'];
              $inconsistencias .= htmlspecialchars($detalleInner['Detalle']) . ', periodo ' . htmlspecialchars($periodo) . ' por valor de RD$' . htmlspecialchars($valor) . '<br>';
          }
          
          $inconsistencias .= '</li><br>';
      }

      // Reemplazos en el template del correo   
      $replacements = array(
      "[INCONSISTENCIAS]" => ArrayFormat(array_column($Detalles,"NOTIFICACION")),
      "[DETALLES_INCONSISTENCIAS]" => $inconsistencias,
      "[FECHA_VENCIMIENTO]" => $this->DateFormat($value["FechaVenci"])
      );

      // Leer el template del correo
      $templatePath = APP_URL . "Data/modelos/detallescitacion". ($value["SIZE"] == 1 ? "" : "2") .".html";
      $template = file_get_contents($templatePath);

      // Construir el cuerpo del correo  
      $modelo = ($this->MailHead($value['NombreCliente'])) .
                (str_replace(array_keys($replacements), $replacements, $template)) .
                ($this->MailFoot());

      // Configurar destinatario, asunto y cuerpo del correo
      $this->mail->addAddress($cc[0]);
      $this->mail->Subject = mb_convert_encoding('Detalle de citación sobre inconsistencia DGII - '.$value["NombreCliente"], "UTF-8", "auto");
      $this->mail->Body = $modelo;

      // Añadir adjuntos y CC
      $this->AddAtachmentToMail(json_decode($value["ARCHIVOS"], true));
      $this->AddCCToMail($cc,$value["IDDetalle"],2);

      // Enviar el correo
      $this->SendMail($value["IDDetalle"],2);

      }catch( Exception $e) { error_log($e->getMessage()); return HandleError();}
    
    return $this->res;
    }


    function SendMailEscrito(int $IDEscrito, array $cc): array
    {
        try {

        // Llamada al procedimiento almacenado para obtener los datos del escrito de descargo
        $query = "CALL SENDMAIL_ESCRITO(?)";
        $exec = $this->conectdb->prepare($query);
        $exec->bindParam(1, $IDEscrito, 1);
        $exec->execute();
        
        // Manejo de errores si no se encontraron resultados
        if ($exec->rowCount() === 0) { return HandleError(); }

        $value = $exec->fetch();
        $exec->closeCursor();
    
        // Reemplazos en el template del correo
        $replacements = array(
        "[NOTIFICACIONES]" => ArrayFormat(json_decode($value['NONOTIF'],true)),
        "[NOCASO]" => ArrayFormat(json_decode($value['NOCASO'],true))
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

        }catch( Exception $e) { error_log($e->getMessage()); return HandleError();}
    
        return $this->res;
    }


    function SendMailRespuesta(int $IDRespuesta, array $cc): array
    {
        try {

        // Llamada al procedimiento almacenado para obtener los datos de la respuesta de la dgii
        $query = "CALL SENDMAIL_RESPUESTA(?)";
        $exec = $this->conectdb->prepare($query);
        $exec->bindParam(1, $IDRespuesta, 1);
        $exec->execute();
        
        // Manejo de errores si no se encontraron resultados
        if ($exec->rowCount() === 0) { return HandleError(); }

        $value = $exec->fetch();
        $exec->closeCursor();
    
        // Construir el cuerpo del correo
        $modelo = ($this->MailHead($value['NombreCliente'])) .
                  ("<p>".nl2br($value['Comentarios'])."</p>") .
                  ($this->MailFoot());
        
        // Configurar destinatario, asunto y cuerpo del correo
        $this->mail->addAddress($cc[0]);
        $this->mail->Subject = mb_convert_encoding($value["TipoRespuesta"].' sobre inconsistencia DGII - ' . $value["NombreCliente"], "UTF-8", "auto");
        $this->mail->Body = $modelo;
    
        // Añadir adjuntos y CC
        $this->AddAtachmentToMail(json_decode($value["ArchivoRespuesta"], true));
        $this->AddCCToMail($cc, $value["IDRespuesta"], 4);
    
        // Enviar el correo
        $this->SendMail($value["IDRespuesta"], 4);

        }catch( Exception $e) { error_log($e->getMessage()); return HandleError();}
    
        return $this->res;
    }
    
}