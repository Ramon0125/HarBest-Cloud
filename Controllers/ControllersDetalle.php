<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersDetalle.php') === false) {

class ControllerDettalles extends ConexionDB
{
  private $response = array();
  private $OC;


  public function __construct() 
  {
  parent::__construct();
  $this->OC = $this->obtenerConexion();
  }


  public function InsertDetalle(INT $INIDNOT, INT $INNOCAS, string $ININCON, string $INPERIO, string $INVALOR, STRING $INFECHA, ARRAY $INDETALL): array
  { 

  try{

    $detallesArchivos = array_map(function($tmp_name, $type) {
      return array(
          'archivo' => base64_encode(file_get_contents($tmp_name)),
          'mime' => $type
      );},$INDETALL['tmp_name'], $INDETALL['type']);
    
      $values = json_encode($detallesArchivos);

      $sql = "CALL SP_INSERTAR_DETALLE (?,?,?,?,?,?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$INIDNOT,PDO::PARAM_INT);
      $ejecucion->bindParam(2,$INNOCAS,PDO::PARAM_INT);
      $ejecucion->bindParam(3,$ININCON,PDO::PARAM_STR);
      $ejecucion->bindParam(4,$INPERIO,PDO::PARAM_STR);
      $ejecucion->bindParam(5,$INVALOR,PDO::PARAM_STR);
      $ejecucion->bindParam(6,$INFECHA,PDO::PARAM_STR);
      $ejecucion->bindValue(7,$values,PDO::PARAM_LOB);
      $ejecucion->execute();

      if ($ejecucion->rowCount() > 0) 
      {
        $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        
        if($resultado['MENSAJE'] === 'DIC') {$this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UN DETALLE DE CITACION');} 
        else { $this->response['success'] = false; SUMBLOCKUSER();}

        $this->response['message'] = $resultado['MENSAJE'];         
      }
      else { $this->response['error1'] = true; SUMBLOCKUSER();}

    }catch(Exception $E) { $this->response['error1'] = $E; SUMBLOCKUSER();}
    
    return $this->response;
}
/* 

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
  finally {unset($sqlv,$ejecucion,$resultado);}

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
  finally {unset($sql,$ejecucion,$resultado);}

  return $this->response;
}



public function DeleteUser(int $id, string $name): array
{
    try {
      $sql = "CALL SP_ELIMINAR_USUARIO(?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$id,PDO::PARAM_STR);
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
    finally {unset($sql,$ejecucion,$resultado);}

    return $this->response;
}
 */}

}

else { header("LOCATION: ./404"); }