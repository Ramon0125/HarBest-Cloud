<?php   

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['tipo'],$_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') 
{ http_response_code(404);   die(header('Location: ./404')); } 

else {
  require '../Controllers/Conexion.php';
  require '../Controllers/ControllersBlocks.php';
  require '../Controllers/ControllersComplementos.php';
  require '../Controllers/Functions.php';

  if (VALIDARBLOCK() === 'T') 
  {  
    if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0)
    {
      if (Validarcadena1($_POST))
      {
        $verificar = new ControllersComplementos();

        if ($_POST['tipo'] === 'addprg' && isset($_POST['CodNot'],$_POST['Fecha'],$_POST['Comentarios'],$_FILES['Archivo'])) 
        {
          foreach ($_FILES['Archivo']['name'] as $filename) 
          {
            $Extension = pathinfo($filename, PATHINFO_EXTENSION);

            if (!validarCarta($Extension)) 
            { SUMBLOCKUSER(); $response['EANV'] = true; break;}
          }

          if (empty($response))
          { $response = $verificar->agrprg($_POST['CodNot'], $_POST['Fecha'], $_POST['Comentarios'], $_FILES['Archivo']);}
        }
        else { $response = HandleError(); }
      }
      else { $response['CNV'] = true; SUMBLOCKUSER(); }
    }
    else { $response = HandleWarning(); }
  }
  else { $response['block'] = true;}

  header('Content-Type: application/json');
  echo json_encode($response);
}