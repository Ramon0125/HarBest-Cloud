<?php

if (preg_match('/ControllersDetalle(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

class ControllerDettalles extends ConexionDB
{

private $response;
private $OC;


public function __construct() 
{ 
  parent::__construct(); 
  $this->OC = $this->obtenerConexion(); 
}


public function InsertDetalle(string $INCODNOT,$ININCON, STRING $INFECHA, $ARCHIVOS, STRING $CORAUD, STRING $NOMAUD, STRING $TELAUD)
{ 
  try
  {
    //Preparar la insercion de la carta
    $CARTAS = json_encode(array_map(function($MimeType,$FileName,$File) 
    {
     return array(
      'MIME' => $MimeType,
      'NOMBRE' => $FileName,
      'CARTA' => base64_encode(file_get_contents($File))); 
    },$ARCHIVOS['type'],$ARCHIVOS['name'],$ARCHIVOS['tmp_name']));


    //Preparar la insercion de los detalles de citacion
    $DETALLES = json_encode(array_map(function($Array)
    {   
     $values = json_decode($Array,true);

     return array(
      'DETALLES' => $values['DETALLES'],
      'NOTIFICACION' => $values['INCONSISTENCIA']); 
    }, $ININCON ));


    // Llamada al procedimiento almacenado para insertar el detalle de citacion
    $sql = "CALL SP_INSERTAR_DETALLE(?,?,?,?,?,?,?)";
    $ejecucion = $this->OC->prepare($sql);
    $ejecucion->bindParam(1,$INCODNOT);
    $ejecucion->bindParam(2,$INFECHA);
    $ejecucion->bindParam(3,$DETALLES);
    $ejecucion->bindParam(4,$CARTAS,3);
    $ejecucion->bindParam(5,$CORAUD);
    $ejecucion->bindParam(6,$NOMAUD);
    $ejecucion->bindParam(7,$TELAUD,1);
    $ejecucion->execute();

    // Si la consulta no trae datos dispara error
    if ($ejecucion->rowCount() === 0) {return HandleError();}
      
    $resultado = $ejecucion->fetch();

    $this->response['message'] = $resultado['MENSAJE'];  
    $this->response['success'] = $this->response['message'] === 'DIC';
             
    
    if($this->response['success']) {
    AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN DETALLE DE CITACION');
    EMAILS($INCODNOT,2);
    }
    else {SUMBLOCKUSER();}

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}
  
  return $this->response;
}


public function DeleteDetalle(int $IDD, string $NOC): array
{
    try 
    {
      // Llamada al procedimiento almacenado para eliminar el detalle de citacion
      $sql = "CALL SP_DELETE_DETALLE(?,?)";
      $ejecucion = $this->OC->prepare($sql);
      $ejecucion->bindParam(1,$IDD);
      $ejecucion->bindParam(2,$NOC);
      $ejecucion->execute();

      // Si la consulta no trae datos dispara error
      if ($ejecucion->rowCount() === 0){return HandleError();}
      
      $resultado = $ejecucion->fetch();
      $this->response['message'] = $resultado['MENSAJE'];
      $this->response['success'] = $this->response['message'] === 'DEC';
      $this->response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UN DETALLE DE CITACION') : SUMBLOCKUSER();
      
    }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

    return $this->response;
}


public function varchivos(int $IDD) : array 
{
  try
  {
    // Obtener las cartas de detalle de citacion
    $query = 'SELECT CartasDetalles FROM DETALLE_CITACION WHERE IDDetalle = ?';
    $exec = $this->OC->prepare($query);
    $exec->bindParam(1,$IDD,PDO::PARAM_INT);
    $exec->execute();

    // Si la consulta no trae datos dispara error
    if ($exec->rowCount() === 0) {return HandleError();}
    
    $res = $exec->fetch();
    $this->response['success'] = true;
    $this->response['CARTAS'] = $res['CartasDetalles'];

  }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

  return $this->response;
}

}