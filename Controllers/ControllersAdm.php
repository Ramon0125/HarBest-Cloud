<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersAdm.php') === false) { 

CLASS ControllersAdm extends ConexionDB
{
private $Oconect;
private $response;


public function __construct()
{
parent::__construct();
$this->Oconect = $this->obtenerConexion();
}

public function agradm(string $name): array
{
  try 
  {   
    $var = "CALL SP_INSERTAR_ADM(?)";
    $query = $this->Oconect->prepare($var);
    $query->bindParam(1, $name,PDO::PARAM_STR);
    $query->execute();
    
    if($query->rowCount() > 0)
    {
    $res = $query->fetch(PDO::FETCH_ASSOC);

    if($res['MENSAJE'] === 'AIC')
    {
      $this->response['success'] = true; 
      AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UNA ADMINISTRACION');
    }
    else{$this->response['success'] = false; SUMBLOCKUSER();}

    $this->response['message'] = $res['MENSAJE'];
    }
    else { $this->response['error'] = true; SUMBLOCKUSER(); }
  }
  catch (Exception) { $this->response['error'] = true; SUMBLOCKUSER(); }
  finally {unset($var,$query,$res);}  

return $this->response;
}


public function edtadm(int $id, string $name, string $nname) : array 
{

try {
$query = "CALL SP_MODIFICAR_ADM(?,?,?)";
$consulta = $this->Oconect->prepare($query);
$consulta->bindParam(1,$id,PDO::PARAM_INT);
$consulta->bindParam(2,$name,PDO::PARAM_STR);
$consulta->bindParam(3,$nname,PDO::PARAM_STR);
$consulta->execute();

if($consulta->rowCount() > 0)
{
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

if($resultado['MENSAJE'] === 'AMC'){$this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'MODIFICO UNA ADMINISTRACION');}
else{$this->response['success'] = false; SUMBLOCKUSER();}

$this->response['message'] = $resultado['MENSAJE'];
}
else {  $this->response['error'] = true; SUMBLOCKUSER();}
}catch (Exception) { $this->response['error'] = true; SUMBLOCKUSER(); }
finally {unset($consulta); unset($query); unset($resultado);}  

return $this->response;
}

}
}

else {header('LOCATION: ./404');}