<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC']) && isset($_POST['ENTITY']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

require "../Controllers/Conexion.php";
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllerEmails.php';


if(VALIDARBLOCK() === 'T'){

if (!is_null(GetInfo('ID_USUARIO')) && Validarcadena1($_COOKIE['IDENTITY']) )
{

if (Validarcadena1($_POST)){

require '../vendor/autoload.php';

$SENDMAIL = new EmailSender();

if($_POST['FUNC'] == 'NOTIF.' && isset($_POST['ENTITY']))
{
 $data = $SENDMAIL->sendmailnotif($_POST['ENTITY']);
}
elseif($_POST['FUNC'] == 'DDC' && isset($_POST['ENTITY']))
{
 $data = $SENDMAIL->sendmailddc($_POST['ENTITY']);
}
else {$data['error'] = true;}

}

else {$data['CNV'] = true;}
}

else {
$url = "../Error/?Error=002";
$html = file_get_contents($url);
echo $html;
}

}

else 
{
  $data['block'] = true;
}

header('Content-Type: application/json');
echo json_encode($data);
}
else { header("LOCATION: ./404"); }