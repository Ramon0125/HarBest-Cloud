<?php   function Validarcadena1(...$strings) 
  {
    var_dump($strings,'<br>');

      $pattern = '/(;\s*|\'.*?\'|--.*?$|\/\*.*?\*\/|\bxp_\w+\b|[\$%<>~=])/m';
  
      foreach ($strings as $value) 
      {
         
          if (is_array($value)) 
          {
              foreach ($value as $Clave => $Valor) 
              {
                  if (preg_match($pattern, $Clave)) { return false; }
                  
                  if (!Validarcadena1($Valor)) { return false; }
              }
          } 
  
          else 
          {
              if (preg_match($pattern, $value)) { return false; }
          }
      }
  
      return true;
  }

$data = array(
    "IDCLT" => "3",
    "FECHANOT" => "2024-07-25",
    "tipo" => "agrnotif",
    "NONOTIF" => array("ALTERNA 243"),
    "TIPNOTIF" => array("FISCALIZACION"),
    "IMPUNOTIF" => array("IR2/2022")
);

echo Validarcadena1($data) ? "Valido" : "No valido";