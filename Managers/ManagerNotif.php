<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    require '../Controllers/Conexion.php';
    require '../Controllers/ControllersBlocks.php';
    require '../Controllers/ControllersNotif.php';
    require '../Controllers/Functions.php';
  
  if (VALIDARBLOCK() === 'T') 
  {
    if(Validarcadena1($_POST))
    {
        $func = NEW ControllersNotif();

        if ($_POST['tipo'] == 'agrnotif' && isset($_POST['IDCLT'], $_POST['FECHANOT'], $_POST['NONOT'], $_POST['TIPNOT'], $_POST['MOTIVNOT'], $_POST['AINCUMPLI'], $_POST['COMENTS']) && isset($_FILES['CARTA'])) 
        {

            if(validarCarta(pathinfo($_FILES['CARTA']['name'], PATHINFO_EXTENSION)))
            {
              $archivoTemp = $_FILES['CARTA']["tmp_name"];
              $data = file_get_contents($archivoTemp);
              $CARTA = base64_encode($data);
              
              $mimeType = obtenertipo($archivoTemp);

              $response = $func->AGRNotif($_POST['IDCLT'], $_POST['NONOT'], $_POST['FECHANOT'], $_POST['TIPNOT'], $_POST['MOTIVNOT'], $CARTA, $_POST['AINCUMPLI'],$_POST['COMENTS'],$mimeType);
            }
            else {$response['EANV'] = true; SUMBLOCKUSER();}  
        }

        else if ($_POST['tipo'] == 'vcarta' && isset($_POST['IDN'])) 
        {$response = $func->vcarta($_POST['IDN']);}

        else {$response['error'] = true; SUMBLOCKUSER();}

    }
    else {$response['CNV'] = true; SUMBLOCKUSER();}
  }
        
  else { $response['block'] = true; }
      
  header('Content-Type: application/json');
  echo json_encode($response);
}

else { header("LOCATION: ./404"); }