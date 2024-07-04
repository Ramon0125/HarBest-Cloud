<?php   

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'],$_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') 
{
  require '../Controllers/Conexion.php';
  require '../Controllers/ControllersBlocks.php';
  require '../Controllers/ControllersDetalle.php';
  require '../Controllers/Functions.php';

  if (VALIDARBLOCK() === 'T') 
  {

    if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0 && Validarcadena1($_COOKIE['IDENTITY']))
    {

    if (Validarcadena1($_POST))
    {
      
    $verificar = new ControllerDettalles();

    if ($_POST['tipo'] == 'addddc' && isset($_POST['INIDNOT'],$_POST['INNOCAS'],$_POST['INCON'],$_POST['INFECHA'],$_FILES['ARCHIVOS'],$_POST['CORAUD'],$_POST['NOMAUD'],$_POST['TELAUD'])) 
    {
      foreach ($_FILES['ARCHIVOS']['name'] as $filename) 
      {
        $Extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!validarCarta($Extension)) { SUMBLOCKUSER(); $response['EANV'] = true; break;} 
      }

      if(!isset($response['EANV']))
      {  
        $response = $verificar->InsertDetalle(
        $_POST['INIDNOT'],
        $_POST['INNOCAS'],
        $_POST['INCON'],
        $_POST['INFECHA'],
        $_FILES['ARCHIVOS'],
        $_POST['CORAUD'],
        $_POST['NOMAUD'],
        $_POST['TELAUD']);
      }
    }
      
    elseif ($_POST['tipo'] == 'dltddc' && isset($_POST['IDD'],$_POST['NOC'])) 
    {
    $response = $verificar->DeleteDetalle($_POST['IDD'],$_POST['NOC']);
    }

    elseif ($_POST['tipo'] == 'vddc' && isset($_POST['IDD'])) 
    {
    $response = $verificar->varchivos($_POST['IDD']);
    }

    elseif ($_POST['tipo'] == 'viddc' && isset($_POST['IDD'])) 
    {
    $response = $verificar->vinconsistencias($_POST['IDD']);
    }

    else {$response = HandleError();}
    }
    else {$response['CNV'] = true; SUMBLOCKUSER();}}

  else { echo HandleWarning();} }
      
else { $response['block'] = true; }
  
  header('Content-Type: application/json');
  echo json_encode($response);
}

else { header("LOCATION: ./404"); }