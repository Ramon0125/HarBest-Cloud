<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['FUNC'],$_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') 
{ http_response_code(404); die(header("LOCATION: ./404")); }

require '../Controllers/Conexion.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllersRespuestas.php';

if(VALIDARBLOCK() === 'T')
{

if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0)
{

if (Validarcadena1($_POST))
{
$CR = new ControllersRespuestas();

if ($_POST['FUNC'] === 'agrres' && isset($_POST['CodNot'],$_POST['Fecha'],$_POST['Tipo'],$_FILES['Archivo'])) 
{ $data = $CR->agrres($_POST['CodNot'],$_POST['Fecha'],$_POST['Tipo'],$_FILES['Archivo']); }

elseif ($_POST['FUNC'] === 'dltres' && isset($_POST['CodRes'],$_POST['CodNot'])) 
{ $data = $CR->dltres($_POST['CodRes'],$_POST['CodNot']); }

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
