<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersUser.php') === false) {

class ControllerUser extends ConexionDB
{
  private $Response = array();
  private $ConexionDB;

  public function __construct() 
  {
  parent::__construct();
  $this->ConexionDB = $this->obtenerConexion();
  }

  
  public function InsertUser(string $Privi,string $Email, string $Nombres, string $Apellidos): array
  { 

  try { $id = uniqid();
      $Query = "CALL SP_INSERTAR_USUARIOS (?,?,?,?,?)";
      $QueryExecution = $this->ConexionDB->prepare($Query);
      $QueryExecution->bindParam(1,$Email,PDO::PARAM_STR);
      $QueryExecution->bindParam(2,$Nombres,PDO::PARAM_STR);
      $QueryExecution->bindParam(3,$Apellidos,PDO::PARAM_STR);
      $QueryExecution->bindParam(4,$Privi,PDO::PARAM_STR);
      $QueryExecution->bindParam(5,$id,PDO::PARAM_STR);
      $QueryExecution->execute();

      if ($QueryExecution->rowCount() === 0) { return HandleError();}
      
        $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);
        
        $this->Response['message'] = $Data['MENSAJE'];
        $this->Response['success'] = $this->Response['message'] === 'UIC';
        $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN USUARIO') : SUMBLOCKUSER();

    }catch(Exception) { return HandleError();}

    return $this->Response;
}


public function VerDatos($id, $token): array
{
  try {
    $Query = "CALL SP_VER_DATOS (?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $id, PDO::PARAM_STR);
    $QueryExecution->bindParam(2, $token, PDO::PARAM_STR);
    $QueryExecution->execute();

    if ($QueryExecution->rowCount() === 0){ return HandleError();}
      
    $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

    $this->Response['success'] = !isset($Data['MENSAJE']);

    if (!$this->Response['success']) 
    {
    $this->Response['message'] = $Data['MENSAJE'];
    SUMBLOCKUSER();
    }
      
    else 
    {foreach($Data as $Row => $Value){$this->Response[$Row] = $Value;}}

  }catch(Exception) { return HandleError();}

  return $this->Response;
}


public function ModifyUser(int $id, string $name, string $email, string $nname, string $lastn, string $pass): array
{
  try{
    $Query = "CALL SP_MODIFICAR_USUARIOS (?,?,?,?,?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->bindParam(2,$name,PDO::PARAM_STR);
    $QueryExecution->bindParam(3,$email,PDO::PARAM_STR);
    $QueryExecution->bindParam(4,$nname,PDO::PARAM_STR);
    $QueryExecution->bindParam(5,$lastn,PDO::PARAM_STR);
    $QueryExecution->bindParam(6,$pass,PDO::PARAM_STR);
    $QueryExecution->execute();

    if ($QueryExecution->rowCount() === 0){ return HandleError();}
    
      $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

      $this->Response['message'] = $Data['MENSAJE'];

      $this->Response['success'] = $this->Response['message'] === 'UMC';

      $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'MODIFICO UN USUARIO') : SUMBLOCKUSER(); 
    
  }catch(Exception) { return HandleError(); }

  return $this->Response;
}


public function DeleteUser(int $id, string $name): array
{
  try {
    $Query = "CALL SP_ELIMINAR_USUARIO(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->bindParam(2,$name,PDO::PARAM_STR);
    $QueryExecution->execute();

    if ($QueryExecution->rowCount() === 0){ return HandleError();}
    
      $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

      $this->Response['message'] = $Data['MENSAJE'];

      $this->Response['success'] = $this->Response['message'] === 'UEC';

      $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UN USUARIO') : SUMBLOCKUSER();

  }catch(Exception) { return HandleError();}

    return $this->Response;
}


public function DesblockUser(int $id): array
{
  try {  
    $Query = "CALL DESBLOQUEAR_USER(?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->execute();

    if ($QueryExecution->rowCount() === 0) { return HandleError();}

    $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

    $this->Response['message'] = $Data['MENSAJE'];

    $this->Response['success'] = $this->Response['message'] === 'UDC';

    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'DESBLOQUEO UN USUARIO') : SUMBLOCKUSER();

    }catch(Exception) { return HandleError();}

    return $this->Response;
}

}

}

else { header("LOCATION: ./404"); }