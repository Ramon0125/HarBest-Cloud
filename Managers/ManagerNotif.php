<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    require '../Controllers/Conexion.php';
    require '../Controllers/ControllersBlocks.php';
    require '../Controllers/Functions.php';
    require '../Controllers/ControllersNotif.php';
  
  if (VALIDARBLOCK() === 'T') 
  {

    if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0 && Validarcadena1($_COOKIE['IDENTITY']))
    {

    if(Validarcadena1($_POST))
    {
      $func = NEW ControllersNotif();

      if ($_POST["tipo"] === "agrnotif" && isset($_POST['IDCLT'], $_POST['FECHANOT'], $_POST['NONOTIF'], $_POST['TIPNOTIF'], $_POST['IMPUNOTIF'], $_FILES['CARTA'])) 
      {
      foreach ($_FILES['CARTA']['name'] as $filename) 
      {
        $Extension = pathinfo($filename, PATHINFO_EXTENSION);

      if (!validarCarta($Extension)) { SUMBLOCKUSER(); $response['EANV'] = true; break;} 
      }
        
      if(!isset($response['EANV']))
      {
      $response = $func->AGRNotif($_POST['IDCLT'], $_POST['FECHANOT'], $_POST['NONOTIF'], $_POST['TIPNOTIF'],$_POST['IMPUNOTIF'], $_FILES['CARTA']);
      }
      }

      else if ($_POST['tipo'] == 'vcarta' && isset($_POST['IDN'])) 
      {$response = $func->vcarta($_POST['IDN']);}

      else if ($_POST['tipo'] == 'dltnotif' && isset($_POST['IDN'],$_POST['COD']))
      { $response = $func->DLTNotif($_POST['IDN'],$_POST['COD']); }

      else if ($_POST['tipo'] === 'vdnot' && isset($_POST['Codigo']))
      {$response = $func->SearchNotif($_POST['Codigo']);}

      else {$response = HandleError();}
    }
    else {$response['CNV'] = true; SUMBLOCKUSER();}}  

    else { echo HandleWarning();}
  }
        
  else { $response['block'] = true; }
      
  header('Content-Type: application/json');
  echo json_encode($response);
}

else { header("LOCATION: ./404"); }