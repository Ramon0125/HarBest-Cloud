<?php

if (strpos($_SERVER['REQUEST_URI'], 'Functions.php') === false) { 

  function validarCarta($string) : bool 
  {$permitidos = ['pdf', 'jpg', 'png','docx'];
  return in_array(strtolower($string), $permitidos);
  }///FUNCION QUE VERIFICA EL TIPO DE ARCHIVO


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
              if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ#()@._\/\s\-]+$/", $string)) { return false; }
          }
      }
      return true;
  }

  function obtenertipo($archivoTemp) {

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $archivoTemp);

    finfo_close($finfo);

    return $mimeType;
  }


  function EMAILS(string $IDN){
    $CONDB1 = NEW ConexionDB();
    $CONDB = $CONDB1->obtenerConexion();
    $query = "CALL SP_INSERT_EMAIL_NOTIF(?)";
    $val = $CONDB->prepare($query);
    $val->bindParam(1,$IDN,PDO::PARAM_STR);
    $val->execute();
  }


  
}
else { header("LOCATION: ./404"); }