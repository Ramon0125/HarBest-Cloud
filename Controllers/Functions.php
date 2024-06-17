<?php

if (strpos($_SERVER['REQUEST_URI'], 'Functions.php') === false) { 

    function validarCarta($string) : bool {
        $permitidos = ['pdf', 'jpg', 'png', 'docx'];
        
        if (is_array($string)) {
            return empty(array_diff(array_map('strtolower', $string), $permitidos));
        } else {
            return in_array(strtolower($string), $permitidos);
        }
    }
    


  function Validarcadena1(...$strings) : bool 
  {
      foreach ($strings as $string) 
      {
          if (is_array($string)) {
              // Si el valor es un array, llamamos recursivamente a Validarcadena1
              if (!Validarcadena1(...$string)) {
                  return false;
              }
          } 
          
          else { // Si el valor no es un array, aplicamos la validación normalmente
              if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ#()[\]@$.,{}_\/\s\-]+$/", $string)) { return false; }
          }
      }
      return true;
  }

  function EMAILS(string $ID,INT $V){
    $CONDB1 = NEW ConexionDB();
    $CONDB = $CONDB1->obtenerConexion();
    switch ($V) {
    case 1:
    $query = "CALL SP_INSERT_EMAIL_NOTIF(?)";
    break;
       
    case 2:
    $query = "CALL SP_INSERT_EMAIL_DDC(?)";
    break;
    }
    $val = $CONDB->prepare($query);
    $val->bindParam(1,$ID,PDO::PARAM_STR);
    $val->execute();
  }

  function ArrayFormat ($array) {
    if (count($array) > 1) {
      return implode(', ', array_slice($array, 0, -1)) . ' y ' . end($array);
    } else {
      return $array[0];
    }
  }


  
}
else { header("LOCATION: ./404"); }