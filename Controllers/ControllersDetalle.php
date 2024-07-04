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

public function InsertDetalle(INT $INIDNOT, INT $INNOCAS, $ININCON, STRING $INFECHA, $ARCHIVOS, STRING $CORAUD, STRING $NOMAUD, STRING $TELAUD)
{ 
  try{
    $CARTAS = json_encode(array_map(
    function($MimeType,$FileName,$File) {
     return array(
      'MIME' => $MimeType,
      'NOMBRE' => $FileName,
      'CARTA' => base64_encode(file_get_contents($File))
     ); },
     $ARCHIVOS['type'],$ARCHIVOS['name'],$ARCHIVOS['tmp_name']));


     $DETALLES = json_encode(array_map(
      function($Array)
      {
      $values = json_decode($Array,true);

      return array(
      'DETALLES' => $values['DETALLES'],
      'NOTIFICACION' => $values['INCONSISTENCIA']); 
      }, $ININCON ));


      $sql = "CALL SP_INSERTAR_DETALLE (?,?,?,?,?,?,?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindValue(1,$INIDNOT,1);
      $ejecucion->bindValue(2,$INNOCAS,1);
      $ejecucion->bindValue(3,$INFECHA,2);
      $ejecucion->bindValue(4,$DETALLES,2);
      $ejecucion->bindValue(5,$CARTAS,3);
      $ejecucion->bindValue(6,$CORAUD,2);
      $ejecucion->bindValue(7,$NOMAUD,2);
      $ejecucion->bindValue(8,$TELAUD,1);
      $ejecucion->execute();
      
      if ($ejecucion->rowCount() === 0) {return HandleError();}
      
      $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);

      $this->response['message'] = $resultado['MENSAJE'];  
      $this->response['success'] = $this->response['message'] === 'DIC';
             
    
      if($this->response['success']) {
      AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN DETALLE DE CITACION');
      EMAILS($INNOCAS,2);
      }
      else {SUMBLOCKUSER();}

  }catch(Exception) {return HandleError();}
  
  return $this->response;
}


public function vinconsistencias(int $IDD) : array 
{
    $query = 'SELECT DetallesCitacion FROM DETALLE_CITACION WHERE IDDetalle = ?';
    $exec = $this->OC->prepare($query);
    $exec->bindParam(1,$IDD,PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() === 0) {return HandleError();}
    
        $res = $exec->fetch(PDO::FETCH_ASSOC);

        $Detalles = json_decode($res["DetallesCitacion"], true);

        $inconsistencias = "";

        foreach ($Detalles as $values) {

          $inconsistencias .= '<li style="text-align: justify;">Inconsistencia '.
          $values["NOTIFICACION"].'<br>';
          
          foreach ($values["DETALLES"] as $value) {
          $inconsistencias .= $value.'<br>';}
          
          $inconsistencias .= '</li><br>';
        }

        $this->response['success'] = true;
        $this->response['INCON'] = $inconsistencias;

    return $this->response;
}

public function DeleteDetalle(int $IDD, string $NOC): array
{
    try {
      $sql = "CALL SP_DELETE_DETALLE(?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$IDD,PDO::PARAM_STR);
      $ejecucion->bindParam(2,$NOC,PDO::PARAM_STR);
      $ejecucion->execute();

      if ($ejecucion->rowCount() === 0){return HandleError();}
      
        $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
        $this->response['message'] = $resultado['MENSAJE'];
        $this->response['success'] = $this->response['message'] === 'DEC';
        $this->response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UN DETALLE DE CITACION') : SUMBLOCKUSER();
      
      }catch(Exception){return HandleError();}

    return $this->response;
}

public function varchivos(int $IDD) : array 
{
  try{
    $query = 'SELECT CartasDetalles FROM DETALLE_CITACION WHERE IDDetalle = ?';
    $exec = $this->OC->prepare($query);
    $exec->bindParam(1,$IDD,PDO::PARAM_INT);
    $exec->execute();

    if ($exec->rowCount() === 0) {return HandleError();}
    
      $res = $exec->fetch(PDO::FETCH_ASSOC);
      $this->response['success'] = true;
      $this->response['CARTAS'] = $res['CartasDetalles'];
  }catch(Exception) {return HandleError();}

  return $this->response;
}


 
}

}

else { header("LOCATION: ./404"); }