<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

require '../Controllers/Conexion.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllerEmails.php';


if(VALIDARBLOCK() === 'T'){

if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0 && isset($_POST['ENTITY'],$_POST['CC']))
{

if (Validarcadena1($_POST))
{

$SENDMAIL = new EmailSender();

switch ($_POST['FUNC']) {

  case 'NOTIF':
    $data = $SENDMAIL->SendMailNotif($_POST['ENTITY'],$_POST['CC']);
  break;

  case 'DDC':
    $data = $SENDMAIL->SendMailDDC($_POST['ENTITY'],$_POST['CC']);
  break;

  case 'EDD':
    $data = $SENDMAIL->SendMailEscrito($_POST['ENTITY'],$_POST['CC']);
  break;

  case 'RDGII':
    $data = $SENDMAIL->SendMailRespuesta($_POST['ENTITY'],$_POST['CC']);
  break;

  case 'PRG':
    $data = $SENDMAIL->SendMailProrroga($_POST['ENTITY'],$_POST['CC']);
  break;
  
  default:
  $data = HandleError();
  break;

}

}

else { $data['CNV'] = true; SUMBLOCKUSER(); }
}

else { echo HandleWarning();}

}

else 
{
  $data['block'] = true;
}

header('Content-Type: application/json');
echo json_encode($data);
}
else { header("LOCATION: ./404"); }