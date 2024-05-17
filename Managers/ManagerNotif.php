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

        if ($_POST['tipo'] == 'agrnotif' && isset($_POST['IDCLT'], $_POST['FECHANOT'], $_POST['NONOT'], $_POST['TIPNOT'], $_POST['MOTIVNOT'], $_POST['AINCUMPLI'], $_POST['COMENTS'], $_FILES['CARTA'])) 
        {
          if(validarCarta(pathinfo($_FILES['CARTA']['name'], 4)))
          {
          $CARTA = base64_encode(file_get_contents($_FILES['CARTA']["tmp_name"]));
          
          $response = $func->AGRNotif($_POST['IDCLT'], $_POST['NONOT'], $_POST['FECHANOT'], $_POST['TIPNOT'], $_POST['MOTIVNOT'], $CARTA, $_POST['AINCUMPLI'],$_POST['COMENTS'],$_FILES['CARTA']['type']);
          }
          else {$response['EANV'] = true; SUMBLOCKUSER();}  
        }

        else if ($_POST['tipo'] == 'vcarta' && isset($_POST['IDN'])) 
        {
          $response = $func->vcarta($_POST['IDN']);
        }

        else if ($_POST['tipo'] == 'vdatos' && isset($_POST['ID'],$_POST['NON']))
        {
          $response = $func->vdatosnotif($_POST['ID'],$_POST['NON']);
        }

        else if ($_POST['tipo'] == 'edtnotif' && isset($_POST['IDN'],$_POST['NON'],$_POST['NIDCLI'],$_POST['NFECH'],$_POST['NNON'],$_POST['NTIPNO'],$_POST['NMOTNOT'],$_POST['NAINCU']))
        {
          $response = $func->EDTNotif($_POST['IDN'],$_POST['NON'],$_POST['NIDCLI'],$_POST['NFECH'],$_POST['NNON'],$_POST['NTIPNO'],$_POST['NMOTNOT'],$_POST['NAINCU']);
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