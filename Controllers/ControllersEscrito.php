<?php

if (preg_match('/ControllersEscrito(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

class ControllersDescargo extends ConexionDB
{
private $ConexionDB;
private $Response;


public function __construct()
{
parent::__construct();
$this->ConexionDB = $this->obtenerConexion();
}


public function agredd(string $cod,string $Fecha, array $archivo): array
{
  try 
  {  
    //Preparar el escrito de descargo
    $ArchivoDetalle = json_encode(array_map(function($c,$m,$n)
    {
    return array(
    'CARTA' => base64_encode(file_get_contents($c)),
    'MIME' => $m,
    'NOMBRE' => $n);
    },$archivo["tmp_name"],$archivo["type"],$archivo["name"]));


    // Llamada al procedimiento almacenado para insertar el edd
    $Query = "CALL SP_INSERT_EDD(?,?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $cod);
    $QueryExecution->bindParam(2, $Fecha);
    $QueryExecution->bindValue(3, $ArchivoDetalle, PDO::PARAM_LOB);
    $QueryExecution->execute();
    
    // Si la consulta no trae datos dispara error
    if($QueryExecution->rowCount() === 0) { return HandleError(); }
    
    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'EDDIC';

    if ($this->Response['success']) 
    {
      EMAILS($cod,3);
      AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN ESCRITO DE DESCARGO');
    }
    else {SUMBLOCKUSER();}

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

return $this->Response;
}


public function dltedd(int $CodEsc, string $CodNot): array
{
  try 
  {  
    // Llamada al procedimiento almacenado para eliminar el edd
    $Query = "CALL SP_DELETE_EDD(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $CodEsc,1);
    $QueryExecution->bindParam(2, $CodNot);
    $QueryExecution->execute();
    
    // Si la consulta no trae datos dispara error
    if($QueryExecution->rowCount() === 0) { return HandleError(); }

    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'EDDEC';

    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN ESCRITO DE DESCARGO') : SUMBLOCKUSER();
  
  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

return $this->Response;
}


public function varchivos(int $IDD) : array 
{
  try
  {
    // Obtener los archivos de escrito de descargo
    $query = 'SELECT ArchivoEscrito FROM ESCRITO_DESCARGO WHERE IDEscrito = ?';
    $exec = $this->ConexionDB->prepare($query);
    $exec->bindParam(1,$IDD,PDO::PARAM_INT);
    $exec->execute();

    // Si la consulta no trae datos dispara error
    if ($exec->rowCount() === 0) {return HandleError();}
    
    $res = $exec->fetch();
    $this->Response['success'] = true;
    $this->Response['CARTAS'] = $res['ArchivoEscrito'];

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

  return $this->Response;
}

}