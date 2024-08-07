<?php

if (preg_match('/ControllersRespuestas(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

class ControllersRespuestas extends ConexionDB
{
private $ConexionDB;
private $Response;


public function __construct()
{
parent::__construct();
$this->ConexionDB = $this->obtenerConexion();
}


public function agrres(string $cod,string $Fecha,string $Tipo, array $archivo): array
{
  try 
  {
    //Preparar el escrito de descargo
    $ArchivoRespuesta = json_encode(array_map(function($c,$m,$n)
    {
    return array(
    'CARTA' => base64_encode(file_get_contents($c)),
    'MIME' => $m,
    'NOMBRE' => $n);
    },$archivo["tmp_name"],$archivo["type"],$archivo["name"]));


    // Llamada al procedimiento almacenado para insertar el edd
    $Query = "CALL SP_INSERT_RES(?,?,?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $cod);
    $QueryExecution->bindParam(2, $Fecha);
    $QueryExecution->bindParam(3, $Tipo);
    $QueryExecution->bindValue(4, $ArchivoRespuesta, PDO::PARAM_LOB);
    $QueryExecution->execute();
    
    // Si la consulta no trae datos dispara error
    if($QueryExecution->rowCount() === 0) { return HandleError(); }
    
    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'RIC';

    if ($this->Response['success']) 
    {
      /* EMAILS($cod,3); */
      AUDITORIA(GetInfo('IDUsuario'),'INSERTO UNA RESPUESTA DE LA DGII');
    }
    else {SUMBLOCKUSER();}

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

return $this->Response;
}


public function dltres(int $CodRes, string $CodNot): array
{
  try 
  {  
    // Llamada al procedimiento almacenado para eliminar el edd
    $Query = "CALL SP_DELETE_RES(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $CodRes,1);
    $QueryExecution->bindParam(2, $CodNot);
    $QueryExecution->execute();
    
    // Si la consulta no trae datos dispara error
    if($QueryExecution->rowCount() === 0) { return HandleError(); }

    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'REL';

    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UNA RESPUESTA DE LA DGII') : SUMBLOCKUSER();
  
  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

return $this->Response;
}

}