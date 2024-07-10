<?php

if (strpos($_SERVER['REQUEST_URI'], 'Functions.php') === false) { 

  function validarCarta($string) : bool 
  {
  $permitidos = ['pdf', 'jpg', 'png', 'docx', 'doc'];
  //Estas son las extensiones permitidas
        
  if (is_array($string)) { return empty(array_diff(array_map('strtolower', $string), $permitidos));}
  //1: array_map volvera todos los elementos del array en minusculas
  //2: array_diff retornara un array con los elementos que no estan en la variable $permitidos
  //3: empty evaluara si el array retornado tiene contenido o no
        
  else { return in_array(strtolower($string), $permitidos); }
  //in_array evaluara si el contenido se encuentra entre las extensiones permitidas
  }
    
    
  function Validarcadena1(...$strings) : bool 
  {
    foreach ($strings as $string) 
    {
      if (is_array($string)) 
      {// Si el valor es un array, llamamos recursivamente a Validarcadena1
        if (!Validarcadena1(...$string)) { return false; }
      } 
          
      else 
      { // Si el valor no es un array, aplicamos la validación normalmente
      if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ#()[\]@$.,{}_\/\s\-…:\"\"]+$/", $string)) { return false; }
      }
    }
    return true;
  }


  function ArrayFormat ($array) 
  {
    if (count($array) === 1) { return $array[0]; }
    //Si el array solo cuenta con un elemento retorna ese elemento
    
    return implode(', ', array_slice($array, 0, -1)) . (str_starts_with(end($array),'I') ? ' e ' : ' y ') . end($array);
    //Retorna los arrays separados por comas y el ultimo separado por "y"
  }


  function HandleError() 
  {
    SUMBLOCKUSER();
    return array('error' => true);
  }


  function HandleWarning()
  {
    SUMBLOCKUSER();
    $url = APP_URL."Error/?Error=002";
    $html = file_get_contents($url);
    echo $html;
  }


  function EMAILS(string $ID,INT $V)
  {
    $ConexionDB = NEW ConexionDB();
    $InstanciacionDB = $ConexionDB->obtenerConexion();
    switch ($V) 
    {
    case 1:
    $QueryStatement = "CALL SP_INSERT_EMAIL_NOTIF(?)";
    break;
       
    case 2:
    $QueryStatement = "CALL SP_INSERT_EMAIL_DDC(?)";
    break;
    }
    $QueryExecution = $InstanciacionDB->prepare($QueryStatement);
    $QueryExecution->bindParam(1,$ID,PDO::PARAM_STR);
    $QueryExecution->execute();
  } 
  
}
else { header("LOCATION: ./404"); }