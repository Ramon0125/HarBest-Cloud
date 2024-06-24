<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
  require '../Controllers/Conexion.php';
  require '../Controllers/ControllersBlocks.php';
  require '../Controllers/Functions.php';
  require '../Controllers/ControllersUser.php';

  if (VALIDARBLOCK() === 'T') 
  {

   if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0 && Validarcadena1($_COOKIE['IDENTITY']))
   {
  
    if (Validarcadena1($_POST))
    {
    
    $verificar2 = new ControllerUser();

    if ($_POST['tipo'] === "addusr" && isset($_POST['Privi'],$_POST['Email'],$_POST['Name'],$_POST['Lastn']))
    { $response = $verificar2->InsertUser($_POST['Privi'],$_POST['Email'],$_POST['Name'],$_POST['Lastn']); }

    else if ($_POST['tipo'] === "vdusr" && isset($_POST['ID'],$_POST['TOKEN']))
    { $response = $verificar2->VerDatos($_POST['ID'],$_POST['TOKEN']); }

    else if ($_POST['tipo'] === "edtusr" && isset($_POST['id'],$_POST['name'],$_POST['email'],$_POST['nname'],$_POST['lastn'],$_POST['pass']))
    { $response = $verificar2->ModifyUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['nname'], $_POST['lastn'], $_POST['pass']);}

    else if ($_POST['tipo'] === "dltusr" && isset($_POST['id'],$_POST['name']))
    { $response = $verificar2->DeleteUser($_POST['id'], $_POST['name']);}

    else if ($_POST['tipo'] === "desusr" && isset($_POST['id']))
    {$response = $verificar2->DesblockUser($_POST['id']);}

    else {$response = HandleError();}
  
    }
  
  else {$response['CNV'] = true; SUMBLOCKUSER();}
  }

  else {
  SUMBLOCKUSER();
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