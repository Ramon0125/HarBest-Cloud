<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC'])  && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
require '../Controllers/Conexion.php';
require '../Controllers/ControllersCliente.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';


if(VALIDARBLOCK() === 'T'){

if (!is_null(USERDATA::GetInfo('ID_USUARIO')) && Validarcadena1($_COOKIE['IDENTITY']) )
{
 

if (Validarcadena1($_POST)){

$CC = new ControllerCliente();


if($_POST['FUNC'] == 'agrclt' && isset($_POST['rnc']) && isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['adm'])) 
{ $data = $CC->InsertCliente($_POST['rnc'],$_POST['email'],$_POST['nombre'],$_POST['adm']); }
 

elseif($_POST['FUNC'] == 'vdclt' && isset($_POST['ID']) && isset($_POST['TOKEN'])) 
{ $data = $CC->VerDatosCLT($_POST['ID'],$_POST['TOKEN']); }


elseif($_POST['FUNC'] == 'edtclt' && isset($_POST['id']) && isset($_POST['nc']) && isset($_POST['rnc']) && isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['adm'])) 
{ $data = $CC->EditarCliente($_POST['id'],$_POST['nc'],$_POST['rnc'],$_POST['email'],$_POST['nombre'],$_POST['adm']); } 


elseif($_POST['FUNC'] == 'dltclt' && isset($_POST['id']) && isset($_POST['name'])) 
{ $data = $CC->DeleteCliente($_POST['id'], $_POST['name']); }


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