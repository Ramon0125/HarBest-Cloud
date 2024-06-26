<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersAdm.php') === false) { 

CLASS ControllersAdm extends ConexionDB
{
private $ConexionDB;
private $Response;

public function __construct()
{
parent::__construct();
$this->ConexionDB = $this->obtenerConexion();
}

public function agradm(string $name,string $direc): array
{
  try 
  {   
    $Query = "CALL SP_INSERTAR_ADM(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $name,PDO::PARAM_STR);
    $QueryExecution->bindParam(2, $direc,PDO::PARAM_STR);
    $QueryExecution->execute();
    
    if($QueryExecution->rowCount() == 0) { return HandleError();}
    
    $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

    $this->Response['success'] = $Data['MENSAJE'] === 'AIC';
    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UNA ADMINISTRACION') : SUMBLOCKUSER();

  }
  catch (Exception) { return HandleError(); }

return $this->Response;
}


public function edtadm(int $id, string $name, string $nname, string $ndirecc) : array 
{
try {
 $Query = "CALL SP_MODIFICAR_ADM(?,?,?,?)";
 $QueryExecution = $this->ConexionDB->prepare($Query);
 $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
 $QueryExecution->bindParam(2,$name,PDO::PARAM_STR);
 $QueryExecution->bindParam(3,$nname,PDO::PARAM_STR);
 $QueryExecution->bindParam(4,$ndirecc,PDO::PARAM_STR);
 $QueryExecution->execute();

 if($QueryExecution->rowCount() == 0) { return HandleError(); }
 
  $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

  $this->Response['success'] = $Data['MENSAJE'] === 'AMC';
  $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'MODIFICO UNA ADMINISTRACION') : SUMBLOCKUSER();
  $this->Response['message'] = $Data['MENSAJE'];
}
catch (Exception) { { return HandleError(); } }

return $this->Response;
}

}
}
else {header('LOCATION: ./404');}