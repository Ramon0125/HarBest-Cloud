<?php

if (preg_match('/ControllersUser(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

class ControllerUser extends ConexionDB
{
  private $Response;
  private $ConexionDB;


  public function __construct() 
  {
  parent::__construct();
  $this->ConexionDB = $this->obtenerConexion();
  }


  public function InsertUser(string $Privi,string $Email, string $Nombres, string $Apellidos): array
  { 
    try 
    { 
      // Llamada al procedimiento almacenado para insertar el uusuario
      $Query = "CALL SP_INSERTAR_USUARIOS (?,?,?,?,?)";
      $QueryExecution = $this->ConexionDB->prepare($Query);
      $QueryExecution->bindParam(1,$Email);
      $QueryExecution->bindParam(2,$Nombres);
      $QueryExecution->bindParam(3,$Apellidos);
      $QueryExecution->bindParam(4,$Privi);
      $QueryExecution->bindValue(5,uniqid());
      $QueryExecution->execute();

      // Si la consulta no trae datos dispara error
      if ($QueryExecution->rowCount() === 0) { return HandleError();}
      
      $Data = $QueryExecution->fetch();
        
      $this->Response['message'] = $Data['MENSAJE'];
      $this->Response['success'] = $this->Response['message'] === 'UIC';
      $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN USUARIO') : SUMBLOCKUSER();

    }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

    return $this->Response;
}


public function VerDatos($id, $token): array
{
  try 
  {
    // Llamada al procedimiento almacenado para ver datos del usario
    $Query = "CALL SP_VER_DATOS (?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $id);
    $QueryExecution->bindParam(2, $token);
    $QueryExecution->execute();

    // Si la consulta no trae datos dispara error
    if ($QueryExecution->rowCount() === 0){ return HandleError();}
      
    $Data = $QueryExecution->fetch();

    $this->Response['success'] = !isset($Data['MENSAJE']);

    if (!$this->Response['success']) 
    {
    $this->Response['message'] = $Data['MENSAJE'];
    SUMBLOCKUSER();
    }
      
    else {foreach($Data as $Row => $Value){$this->Response[$Row] = $Value;}}

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

  return $this->Response;
}


public function ModifyUser(int $id, string $name, string $email, string $nname, string $lastn, string $pass): array
{
  try
  {
    // Llamada al procedimiento almacenado para modificar el usuario
    $Query = "CALL SP_MODIFICAR_USUARIOS (?,?,?,?,?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->bindParam(2,$name);
    $QueryExecution->bindParam(3,$email);
    $QueryExecution->bindParam(4,$nname);
    $QueryExecution->bindParam(5,$lastn);
    $QueryExecution->bindParam(6,$pass);
    $QueryExecution->execute();

    // Si la consulta no trae datos dispara error
    if ($QueryExecution->rowCount() === 0){ return HandleError();}
    

    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'UMC';
    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'MODIFICO UN USUARIO') : SUMBLOCKUSER(); 
    
  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

  return $this->Response;
}


public function DeleteUser(int $id, string $name): array
{
  try 
  {
    // Llamada al procedimiento almacenado para eliminar el usuario
    $Query = "CALL SP_ELIMINAR_USUARIO(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->bindParam(2,$name);
    $QueryExecution->execute();

    // Si la consulta no trae datos dispara error
    if ($QueryExecution->rowCount() === 0){ return HandleError();}
    
    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'UEC';
    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UN USUARIO') : SUMBLOCKUSER();

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

  return $this->Response;
}


public function DesblockUser(int $id): array
{
  try 
  {  
    // Llamada al procedimiento almacenado para desbloquear el usuario
    $Query = "CALL DESBLOQUEAR_USER(?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->execute();

    // Si la consulta no trae datos dispara error
    if ($QueryExecution->rowCount() === 0) { return HandleError();}

    $Data = $QueryExecution->fetch();

    $this->Response['message'] = $Data['MENSAJE'];
    $this->Response['success'] = $this->Response['message'] === 'UDC';
    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'DESBLOQUEO UN USUARIO') : SUMBLOCKUSER();

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

  return $this->Response;
}

}