<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['FUNC'])  && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
require '../Controllers/Conexion.php';
require '../Controllers/ControllersBlocks.php';
require '../Controllers/Functions.php';
require '../Controllers/ControllersCliente.php';

if(VALIDARBLOCK() === 'T'){

if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0)
{
if (Validarcadena1($_POST)){

$CC = new ControllerCliente();


if($_POST['FUNC'] == 'agrclt' && isset($_POST['rnc'],$_POST['email'],$_POST['nombre'],$_POST['tipopersona'],$_POST['adm'])) 
{ $data = $CC->InsertCliente($_POST['rnc'],$_POST['email'],$_POST['nombre'],$_POST['tipopersona'],$_POST['adm']); }
 

elseif($_POST['FUNC'] == 'vdclt' && isset($_POST['ID'],$_POST['TOKEN'])) 
{ $data = $CC->VerDatosCLT($_POST['ID'],$_POST['TOKEN']); }


elseif($_POST['FUNC'] == 'edtclt' && isset($_POST['id'],$_POST['nc'],$_POST['rnc'],$_POST['email'],$_POST['nombre'],$_POST['tipopersona'],$_POST['adm'])) 
{ $data = $CC->EditarCliente($_POST['id'],$_POST['nc'],$_POST['rnc'],$_POST['email'],$_POST['nombre'],$_POST['tipopersona'],$_POST['adm']); } 


elseif($_POST['FUNC'] == 'dltclt' && isset($_POST['id'],$_POST['name'])) 
{ $data = $CC->DeleteCliente($_POST['id'], $_POST['name']); }


elseif($_POST['FUNC'] == 'getccclt' && isset($_POST['id'],$_POST['type'])) 
{ $data = $CC->GetCCCliente($_POST['id'],$_POST['type']); }


else {$data = 'hola'; HandleError();}
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