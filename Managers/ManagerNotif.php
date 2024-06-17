<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    require '../Controllers/Conexion.php';
    require '../Controllers/ControllersBlocks.php';
    require '../Controllers/ControllersNotif.php';
    require '../Controllers/Functions.php';
  
  if (VALIDARBLOCK() === 'T') 
  {

    if (!is_null(GetInfo('ID_USUARIO')) && Validarcadena1($_COOKIE['IDENTITY']) )
    {

    if(Validarcadena1($_POST))
    {
        $func = NEW ControllersNotif();

        if ($_POST["tipo"] === "agrnotif" && isset($_POST['IDCLT'], $_POST['FECHANOT'], $_POST['NONOTIF'], $_POST['TIPNOTIF'], $_POST['IMPUNOTIF'], $_FILES['CARTA'])) 
        {
          foreach ($_FILES['CARTA']['name'] as $key => $nombreArchivo) {
        
            $tipoArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
          
            if (!validarCarta($tipoArchivo)) { $validacionArchivos = false; break;} }
        
            if(!isset($validacionArchivos))
            {
            $response = $func->AGRNotif($_POST['IDCLT'], $_POST['FECHANOT'], $_POST['NONOTIF'], $_POST['TIPNOTIF'],$_POST['IMPUNOTIF'], $_FILES['CARTA']);
            }

            else {$response['EANV'] = true; SUMBLOCKUSER();}  
        }

        else if ($_POST['tipo'] == 'vcarta' && isset($_POST['IDN'])) 
        {
          $response = $func->vcarta($_POST['IDN']);
        }

        else if ($_POST['tipo'] == 'dltnotif' && isset($_POST['IDN'],$_POST['NON']))
        { 
          $response = $func->DLTNotif($_POST['IDN'],$_POST['NON']);
        }

        else {$response['error'] = true; SUMBLOCKUSER();}

    }
    else {$response['CNV'] = true; SUMBLOCKUSER();}}

    else {
    $url = "../Error/?Error=002";
    $html = file_get_contents($url);
    echo $html;
    }
  }
        
  else { $response['block'] = true; }
      
  header('Content-Type: application/json');
  echo json_encode($response);
}

else { header("LOCATION: ./404"); }