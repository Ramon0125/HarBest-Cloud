<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersUser.php') === false) {

class ControllerUser extends ConexionDB
{
  private $response = array();
  private $OC;


  public function __construct() 
  {
  parent::__construct();
  $this->OC = $this->obtenerConexion();
  }


  public function InsertUser(string $Email, string $Nombres, string $Apellidos): array
  { 

  try { $id = uniqid();
      $sql = "CALL SP_INSERTAR_USUARIOS (?,?,?,'EJECUTIVO',?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$Email,PDO::PARAM_STR);
      $ejecucion->bindParam(2,$Nombres,PDO::PARAM_STR);
      $ejecucion->bindParam(3,$Apellidos,PDO::PARAM_STR);
      $ejecucion->bindParam(4,$id,PDO::PARAM_STR);
      $ejecucion->execute();

      if ($ejecucion->rowCount() > 0) 
      {
        $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        
        if($resultado['MENSAJE'] === 'UIC') {$this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UN USUARIO');} 
        else { $this->response['success'] = false; SUMBLOCKUSER();}

        $this->response['message'] = $resultado['MENSAJE'];         
      }
      else { $this->response['error'] = true; SUMBLOCKUSER();}

    }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
}


public function VerDatos($id, $token): array
{
  try {

      $sqlv = "CALL SP_VER_DATOS (?,?)";
      $ejecucion = $this->OC->prepare($sqlv);
      $ejecucion->bindParam(1, $id, PDO::PARAM_STR);
      $ejecucion->bindParam(2, $token, PDO::PARAM_STR);
      $ejecucion->execute();

      if ($ejecucion->rowCount() > 0){
      $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
      $ejecucion->closeCursor();

      $this->response['success'] = !isset($resultado['MENSAJE']);

      if (isset($resultado['MENSAJE'])) 
      {
        $this->response['message'] = $resultado['MENSAJE'];
        SUMBLOCKUSER();
      } 
      
      else 
      {
        $this->response['EMAIL'] = $resultado['EMAIL'];
        $this->response['NOMBRE'] = $resultado['NOMBRES'];
        $this->response['APELLIDOS'] = $resultado['APELLIDOS'];
        $this->response['CLAVE'] = $resultado['CLAVE'];
      }}

      else { $this->response['error'] = true; SUMBLOCKUSER();}

  }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

  return $this->response;
}


public function ModifyUser(int $id, string $name, string $email, string $nname, string $lastn, string $pass): array
{
  try{
     $sql = "CALL SP_MODIFICAR_USUARIOS (?,?,?,?,?,?)";
     $ejecucion = $this->OC->prepare($sql);
     $ejecucion->bindParam(1,$id,PDO::PARAM_INT);
     $ejecucion->bindParam(2,$name,PDO::PARAM_STR);
     $ejecucion->bindParam(3,$email,PDO::PARAM_STR);
     $ejecucion->bindParam(4,$nname,PDO::PARAM_STR);
     $ejecucion->bindParam(5,$lastn,PDO::PARAM_STR);
     $ejecucion->bindParam(6,$pass,PDO::PARAM_STR);
     $ejecucion->execute();

    if ($ejecucion->rowCount() > 0) 
    {
      $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
      $ejecucion->closeCursor();

      if($resultado['MENSAJE'] === 'UMC')
      {$this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'MODIFICO UN USUARIO');}
      
      else{SUMBLOCKUSER(); $this->response['success'] = false;}

      $this->response['message'] = $resultado['MENSAJE'];
      
    }
    else { $this->response['error'] = true; SUMBLOCKUSER();}

  }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

  return $this->response;
}



public function DeleteUser(int $id, string $name): array
{
    try {
      $sql = "CALL SP_ELIMINAR_USUARIO(?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$id,PDO::PARAM_INT);
      $ejecucion->bindParam(2,$name,PDO::PARAM_STR);
      $ejecucion->execute();

      if ($ejecucion->rowCount() > 0) 
      {
        $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        $ejecucion->closeCursor();

        if($resultado['MENSAJE'] === 'UEC'){ $this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'ELIMINO UN USUARIO');}
        else {$this->response['success'] = false; SUMBLOCKUSER();}

        $this->response['message'] = $resultado['MENSAJE'];}


      else { $this->response['error'] = true; SUMBLOCKUSER();}
      }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
}


public function DesblockUser(int $id): array
{
    try {
      
    $sql = "CALL DESBLOQUEAR_USER(?)";
    $ejecucion = $this->OC->prepare($sql);
    $ejecucion->bindParam(1,$id,PDO::PARAM_INT);
    $ejecucion->execute();

      if ($ejecucion->rowCount() > 0) 
      {
        $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        $ejecucion->closeCursor();

        if($resultado['MENSAJE'] === 'UDC'){ $this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'DESBLOQUEO UN USUARIO');}
        else {$this->response['success'] = false; SUMBLOCKUSER();}

        $this->response['message'] = $resultado['MENSAJE'];}

      else { $this->response['error'] = true; SUMBLOCKUSER();}

    }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
}

}

}

else { header("LOCATION: ./404"); }