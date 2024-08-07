<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['FUNC'],$_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') 
{ header("LOCATION: ./404"); }

require '../Controllers/Conexion.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllersEscrito.php';

if(VALIDARBLOCK() === 'T')
{

if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0)
{

if (Validarcadena1($_POST))
{
$CA = new ControllersEscrito();

if ($_POST['FUNC'] === 'agredd' && isset($_POST['CodNot'],$_POST['Fecha'],$_FILES['Archivo'])) 
{ $data = $CA->agredd($_POST['CodNot'],$_POST['Fecha'],$_FILES['Archivo']); }

elseif ($_POST['FUNC'] === 'dltedd' && isset($_POST['CodEsc'],$_POST['CodNot'])) 
{ $data = $CA->dltedd($_POST['CodEsc'],$_POST['CodNot']); }

elseif ($_POST['FUNC'] == 'vescrito' && isset($_POST['IDD'])) 
{
  $data = $CA->varchivos($_POST['IDD']);
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
