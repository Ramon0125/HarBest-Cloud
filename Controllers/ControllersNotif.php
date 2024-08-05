<?php 

if (preg_match('/ControllersNotif(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }


    class ControllersNotif extends ConexionDB
    {
    private $ConexionDB;
    private $Response;


    public function __construct() 
    {
     parent::__construct();
     $this->ConexionDB = $this->obtenerConexion();
    }

    
    public function AGRNotif(int $IDC,string $FEN,array $NOT,array $TIP,array $IMPU,array $CARTA) : array
    {
     try 
     {
        //Preparar la notificacion para su insercion
        $NOTIF = json_encode(array_map(function($N,$T,$I)
        {
         return array(
         'NOTIFICACION' => $N,
         'TIPO' => $T,
         'IMPUESTO' => $I);
        },$NOT,$TIP,$IMPU));

        //Preparar la insercion de la carta
        $CARTANOTIF = json_encode(array_map(function($c,$m,$n)
        {
         return array(
         'CARTA' => base64_encode(file_get_contents($c)),
         'MIME' => $m,
         'NOMBRE' => $n);
        },$CARTA["tmp_name"],$CARTA["type"],$CARTA["name"]));
        
        // Llamada al procedimiento almacenado para insertar la notificacion
        $query = 'CALL SP_INSERTAR_NOTIF(?,?,?,?,?)';
        $exec = $this->ConexionDB->prepare($query);
        $IDE = GetInfo('IDUsuario');
        $exec->bindParam(1,$IDE,1);
        $exec->bindParam(2,$IDC,1);
        $exec->bindParam(3,$FEN);
        $exec->bindParam(4,$NOTIF);
        $exec->bindValue(5,$CARTANOTIF,3);
        $exec->execute();
        
        // Si la consulta no trae datos dispara error
        if ($exec->rowCount() === 0){ return HandleError();} 

        $res = $exec->fetch();

        $this->Response['message'] = $res['MENSAJE'];

        $this->Response['success'] = $this->Response['message'] === 'NIC';

        if($this->Response['success'])
        {
         EMAILS(json_encode($NOT),1);
         AUDITORIA(GetInfo('IDUsuario'),'INSERTO UNA NOTIFICACION DE INCONSISTENCIA');
        }
        else {SUMBLOCKUSER();}
     
     }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}
    
     return $this->Response;
    }


    public function vcarta(int $IDN) : array 
    {
     try
     {
        // Obtener las cartas de notificacion
       $query = 'CALL SP_VER_CARTA(?)';
       $exec = $this->ConexionDB->prepare($query);
       $exec->bindParam(1,$IDN,PDO::PARAM_INT);
       $exec->execute();

       // Si la consulta no trae datos dispara error
       if ($exec->rowCount() === 0){return HandleError();}
        
       $res = $exec->fetch();
       $this->Response['success'] = true;
       $this->Response['CARTA'] = $res['CARTA'];

     }catch(Exception $e) {error_log($e->getMessage()); return HandleError();}

     return $this->Response;
    }


    public function DLTNotif(int $idn,string $non) : array 
    {
      try
      {
        // Llamada al procedimiento almacenado para eliminar la notificacion
        $query = 'CALL SP_ELIMINAR_NOTIF(?,?)';
        $exec = $this->ConexionDB->prepare($query);
        $exec->bindParam(1,$idn,pdo::PARAM_INT);
        $exec->bindParam(2,$non);
        $exec->execute();
        
        // Si la consulta no trae datos dispara error
        if ($exec->rowCount() === 0){return HandleError();}
        
        $res = $exec->fetch();

        $this->Response['message'] = $res['MENSAJE'];
        $this->Response['success'] = $this->Response['message'] === 'NEC';
        $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UNA NOTIFICACION DE INCONSISTENCIA') : SUMBLOCKUSER();
        
      }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}
    
      return $this->Response;
    }
          

    public function SearchNotif(string $Cod) : array 
    {
        try 
        {
         // Llamada al procedimiento almacenado para buscar datos de una notificacion
         $query = 'CALL SP_SEARCH_NOTIF(?)';
         $exec = $this->ConexionDB->prepare($query);
         $exec->bindParam(1,$Cod);
         $exec->execute();

         // Si la consulta no trae datos dispara error
         if ($exec->rowCount() === 0){return HandleError();}
        
         $res = $exec->fetch();

         $this->Response['message'] = $res['MENSAJE'];
         $this->Response['success'] = $this->Response['message'] !== 'EELS';

         if (!$this->Response['success']) {SUMBLOCKUSER();}
        
        }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}
    
        return $this->Response;
    }


    public function DetallesCaso(string $Cod) : array 
    {
      try 
      {
        // Llamada al procedimiento almacenado para buscar los casos de notificaciones  
        $query = 'CALL SP_DETALLES_CASOS(?)';
        $exec = $this->ConexionDB->prepare($query);
        $exec->bindParam(1,$Cod);
        $exec->execute();
        
        // Si la consulta no trae datos dispara error
        if ($exec->rowCount() === 0){return HandleError();}
        
        $res = $exec->fetch();
            
        $this->Response['success'] = !isset($res['MENSAJE']);

        if (!$this->Response['success']) { $this->Response['message'] = $res['MENSAJE']; SUMBLOCKUSER();}
        else { foreach ($res as $column => $value) { $this->Response[$column] = $value; } }
        
      }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}
    
      return $this->Response;
    }

}