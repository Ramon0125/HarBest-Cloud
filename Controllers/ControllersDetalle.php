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

public function InsertDetalle(INT $INIDNOT, INT $INNOCAS, string $ININCON, STRING $INFECHA, ARRAY $INDETALL): array
{ 
  try{

      $detallesArchivos = array_map(function($tmp_name, $type, $name) {
      return array(
      'archivo' => base64_encode(file_get_contents($tmp_name)),
      'mime' => $type,
      'name' => $name
      );},$INDETALL['tmp_name'], $INDETALL['type'],$INDETALL['name']);
    
      $values = json_encode($detallesArchivos);

      $sql = "CALL SP_INSERTAR_DETALLE (?,?,?,?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$INIDNOT,PDO::PARAM_INT);
      $ejecucion->bindParam(2,$INNOCAS,PDO::PARAM_INT);
      $ejecucion->bindParam(3,$ININCON,PDO::PARAM_STR);
      $ejecucion->bindParam(4,$INFECHA,PDO::PARAM_STR);
      $ejecucion->bindValue(5,$values,PDO::PARAM_LOB);
      $ejecucion->execute();

      if ($ejecucion->rowCount() > 0) 
      {
      $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        
      if($resultado['MENSAJE'] === 'DIC') {
      $this->response['success'] = true; 
      AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UN DETALLE DE CITACION');
      EMAILS($INNOCAS,2);
      } 
      else { $this->response['success'] = false; SUMBLOCKUSER();}

      $this->response['message'] = $resultado['MENSAJE'];         
      }
      else { $this->response['error'] = true; SUMBLOCKUSER();}  

  }catch(Exception) {$this->response['error'] = true; SUMBLOCKUSER();}
    
  return $this->response;
}

public function DeleteDetalle(int $IDD, string $NOC): array
{
    try {
      $sql = "CALL SP_DELETE_DDC(?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$IDD,PDO::PARAM_STR);
      $ejecucion->bindParam(2,$NOC,PDO::PARAM_STR);
      $ejecucion->execute();

      if ($ejecucion->rowCount() > 0) 
      {
        $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        $ejecucion->closeCursor();

        if($resultado['MENSAJE'] === 'DEC'){ $this->response['success'] = true; 
        AUDITORIA(GetInfo('ID_USUARIO'),'ELIMINO UN DETALLE DE CITACION');}
        
        else {$this->response['success'] = false; SUMBLOCKUSER();}

        $this->response['message'] = $resultado['MENSAJE'];}


        else { $this->response['error'] = true; SUMBLOCKUSER();}
      }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
}

public function varchivos(int $IDD) : array 
{
    $query = 'SELECT DETALLES_CITACION FROM DETALLE_CITACION WHERE ID_DETALLE = ?';
    $exec = $this->OC->prepare($query);
    $exec->bindParam(1,$IDD,PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() > 0) 
    {
        $res = $exec->fetch(PDO::FETCH_ASSOC);
        $this->response['success'] = true;
        $this->response['CARTAS'] = $res['DETALLES_CITACION'];
    }
    else { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
}

public function vinconsistencias(int $IDD) : array 
{
    $query = 'SELECT INCONSISTENCIA FROM DETALLE_CITACION WHERE ID_DETALLE = ?';
    $exec = $this->OC->prepare($query);
    $exec->bindParam(1,$IDD,PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() > 0) 
    {
        $res = $exec->fetch(PDO::FETCH_ASSOC);

        $array = json_decode($res["INCONSISTENCIA"], true);

        $inconsistencias = "";
    
        foreach ($array as $elemento) {
            $elemento = str_replace(["\r\n\r\n", "\r\n"], "<br>", $elemento);
            $inconsistencias .= '<li style="text-align: justify;">' . $elemento . '</li><br>';
        }
    
        $posicion = strrpos($inconsistencias, "<br>");
    
        $inconsistencias = substr($inconsistencias, 0, $posicion) . substr($inconsistencias, $posicion + 4);;

        $this->response['success'] = true;
        $this->response['INCON'] = $inconsistencias;
    }
    else { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
}
 
}

}

else { header("LOCATION: ./404"); }