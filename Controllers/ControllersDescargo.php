<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersDescargo.php') !== false) { header('LOCATION: ./404');}


class ControllersDescargo extends ConexionDB
{
private $ConexionDB;
private $Response;

public function __construct()
{
parent::__construct();
$this->ConexionDB = $this->obtenerConexion();
}

public function agredd(string $cod,array $archivo): array
{
  try 
  {  
    $ArchivoDetalle = json_encode(array_map(function($c,$m,$n)
    {
    return array(
    'CARTA' => base64_encode(file_get_contents($c)),
    'MIME' => $m,
    'NOMBRE' => $n);
    },
    $archivo["tmp_name"],$archivo["type"],$archivo["name"]));


    $Query = "CALL SP_INSERT_EDD(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $cod,PDO::PARAM_STR);
    $QueryExecution->bindValue(2, $ArchivoDetalle,PDO::PARAM_LOB);
    $QueryExecution->execute();
    
    if($QueryExecution->rowCount() === 0) { return HandleError(); }
    
    $Data = $QueryExecution->fetch();

    $this->Response['success'] = $Data['MENSAJE'] === 'EDDIC';
    $this->Response['message'] = $Data['MENSAJE'];

    if ($this->Response['success']) {
      EMAILS($cod,3);
      AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN ESCRITO DE DESCARGO');
    }
    else {SUMBLOCKUSER();}

  }
  catch (Exception) { return HandleError(); }

return $this->Response;
}


public function dltedd(int $CodEsc, string $CodNot): array
{
  try 
  {  
    $Query = "CALL SP_DELETE_EDD(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $CodEsc,1);
    $QueryExecution->bindValue(2, $CodNot);
    $QueryExecution->execute();
    
    if($QueryExecution->rowCount() === 0) { return HandleError(); }

    $Data = $QueryExecution->fetch();

    $this->Response['success'] = $Data['MENSAJE'] === 'EDDEC';
    $this->Response['message'] = $Data['MENSAJE'];

    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN ESCRITO DE DESCARGO') : SUMBLOCKUSER();
  }
  catch (Exception) { return HandleError(); }

return $this->Response;
}


}
