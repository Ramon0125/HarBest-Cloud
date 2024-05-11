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

    /* else if ($_POST['tipo'] === "vdusr" && isset($_POST['ID']) && isset($_POST['TOKEN']))
    {
    $response = $verificar2->VerDatos($_POST['ID'],$_POST['TOKEN']);
    }

    else if ($_POST['tipo'] === "edtusr" && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['nname']) && isset($_POST['lastn'])  && isset($_POST['pass']))
    {
      $response = $verificar2->ModifyUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['nname'], $_POST['lastn'], $_POST['pass']);
    }

    else if ($_POST['tipo'] === "dltusr" && isset($_POST['id']) && isset($_POST['name']))
    {
      $response = $verificar2->DeleteUser($_POST['id'], $_POST['name']);
    }

    else if ($_POST['tipo'] === "desusr" && isset($_POST['id']))
    {
      $response = $verificar2->DesblockUser($_POST['id']);
    } */

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