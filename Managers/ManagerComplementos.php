<?php   

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'],$_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') 
{
  require '../Controllers/Conexion.php';
  require '../Controllers/ControllersBlocks.php';
  require '../Controllers/ControllersComplementos.php';
  require '../Controllers/Functions.php';

  if (VALIDARBLOCK() !== 'T') { $response['block'] = true; }
      
  else 
      {  
        if (!is_null(GetInfo('IDUsuario')) && GetInfo('IDUsuario') > 0)
        {
  
          if (Validarcadena1($_POST))
          {
  
            $verificar = new ControllersComplementos();
  
            if ($_POST['tipo'] == 'addprg' && isset($_POST['INCODNOT'],$_POST['INFECHA'],$_POST['INCOMENTS'],$_FILES['INARCHIVOS'])) 
            {
              foreach ($_FILES['INARCHIVOS']['name'] as $filename) 
              {
                $Extension = pathinfo($filename, PATHINFO_EXTENSION);
  
                if (!validarCarta($Extension)) 
                { 
                  SUMBLOCKUSER(); 
                  $response['EANV'] = true; 
                  break;
                }
              }
  
              if(!isset($response['EANV']))
              {  
                $response = $verificar->agrprg($_POST['INCODNOT'],$_POST['INFECHA'],$_POST['INCOMENTS'],$_FILES['INARCHIVOS']);
              }
            }
  
            else { $response = HandleError(); }
          }

          else { $response['CNV'] = true; SUMBLOCKUSER(); }
        }
  
        else { echo HandleWarning(); }
      }
  
  header('Content-Type: application/json');
  echo json_encode($response);
}

else { header("LOCATION: ./404"); }