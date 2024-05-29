<?php   header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'],$_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') 
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

    if ($_POST['tipo'] == 'addddc' && isset($_POST['INIDNOT'],$_POST['INNOCAS'],$_POST['INCON'],$_POST['INFECHA'],$_FILES['INDETALL'],$_POST['CORAUD'],$_POST['NOMAUD'],$_POST['TELAUD'])) 
    {
    foreach ($_FILES['INDETALL']['name'] as $key => $nombreArchivo) {
        
    $tipoArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
  
    if (!validarCarta($tipoArchivo)) { $validacionArchivos = false; break;} }

    if(!isset($validacionArchivos))
    {

    $detallesArchivos = array_map(function($tmp_name, $type, $name) {
    return array(
    'archivo' => base64_encode(file_get_contents($tmp_name)),
    'mime' => $type,
    'name' => $name
    );},$_FILES['INDETALL']['tmp_name'], $_FILES['INDETALL']['type'],$_FILES['INDETALL']['name']);
      
    $values = json_encode($detallesArchivos);

    $response = $verificar->InsertDetalle($_POST['INIDNOT'],$_POST['INNOCAS'],json_encode($_POST['INCON']),$_POST['INFECHA'],$values,$_POST['CORAUD'],$_POST['NOMAUD'],$_POST['TELAUD']);
    }
    else {$response['EANV'] = true; SUMBLOCKUSER();}  
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

    else {$response['error'] = true;}
  
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

  echo json_encode($response);
}
else { header("LOCATION: ./404"); }