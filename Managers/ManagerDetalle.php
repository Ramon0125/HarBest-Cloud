<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
  require '../Controllers/Conexion.php';
  require '../Controllers/ControllersBlocks.php';
  require '../Controllers/ControllersDetalle.php';
  require '../Controllers/Functions.php';

  if (VALIDARBLOCK() === 'T') 
  {

   if (!is_null(GetInfo('ID_USUARIO')) && Validarcadena1($_COOKIE['IDENTITY']) )
   {
  
    if (Validarcadena1($_POST))
    {
    
    $verificar = new ControllerDettalles();

    if ($_POST['tipo'] === 'addddc' && isset($_POST['INIDNOT'],$_POST['INNOCAS'],$_POST['INCON'],$_POST['PERIODO'],$_POST['VALOR'],$_POST['INFECHA'],$_FILES['INDETALL'])) 
    {
    $response = $verificar->InsertDetalle($_POST['INIDNOT'],$_POST['INNOCAS'],json_encode($_POST['INCON']),json_encode($_POST['PERIODO']),json_encode($_POST['VALOR']),$_POST['INFECHA'],$_FILES['INDETALL']);
    }

    else {$response['error'] = true; SUMBLOCKUSER();}
  
    }
  
  else {$response['CNV'] = true; SUMBLOCKUSER();}
  }

  else {
  $url = APP_URL."Error/?Error=002";
  $html = file_get_contents($url);
  echo $html;
  }

  }

  else 
  {
    $response['block'] = true;
  }

  header('Content-Type: application/json');
  echo json_encode($response);
}
else { header("LOCATION: ./404"); }