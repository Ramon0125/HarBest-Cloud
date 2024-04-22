<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC'])  && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

require '../Controllers/Conexion.php';
require '../Controllers/ControllersAdm.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';

if(VALIDARBLOCK() === 'T')
{

if (!is_null(USERDATA::GetInfo('ID_USUARIO')) && Validarcadena1($_COOKIE['IDENTITY']) )
{

if (Validarcadena1($_POST)){

$CA = new ControllersAdm();

if ($_POST['FUNC'] === 'agradm' && isset($_POST['Name'])) 
{ $data = $CA->agradm($_POST['Name']); }

else if ($_POST['FUNC'] === 'edtadm' && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['nname'])) 
{ $data = $CA->edtadm($_POST['id'], $_POST['name'], $_POST['nname']); }

else {$response['error'] = true;}

}
  
else {$response['CNV'] = true;}}

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