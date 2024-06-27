<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC'])  && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

require '../Controllers/Conexion.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllersAdm.php';

if(VALIDARBLOCK() === 'T')
{

if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0 && Validarcadena1($_COOKIE['IDENTITY']) )
{

if (Validarcadena1($_POST))
{
$CA = new ControllersAdm();

if ($_POST['FUNC'] === 'agradm' && isset($_POST['Name'],$_POST['Dire'])) 
{ $data = $CA->agradm($_POST['Name'],$_POST['Dire']); }

else if ($_POST['FUNC'] === 'edtadm' && isset($_POST['id'],$_POST['name'],$_POST['nname'],$_POST['ndirec'])) 
{ $data = $CA->edtadm($_POST['id'], $_POST['name'], $_POST['nname'],$_POST['ndirec']); }

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