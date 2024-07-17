<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC']) && isset($_POST['ENTITY']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

require "../Controllers/Conexion.php";
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllerEmails.php';


if(VALIDARBLOCK() === 'T'){

if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0 && Validarcadena1($_COOKIE['IDENTITY']))
{

if (Validarcadena1($_POST))
{

require '../vendor/autoload.php';

$SENDMAIL = new EmailSender();

if($_POST['FUNC'] == 'NOTIF.' && isset($_POST['ENTITY'],$_POST['CC']))
{
 $data = $SENDMAIL->SendMailNotif($_POST['ENTITY'],$_POST['CC']);
}
elseif($_POST['FUNC'] == 'DDC' && isset($_POST['ENTITY'],$_POST['CC']))
{
 $data = $SENDMAIL->SendMailDDC($_POST['ENTITY'],$_POST['CC']);
}
else {$data = HandleError();}

}

else {$data['CNV'] = true; SUMBLOCKUSER();}
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