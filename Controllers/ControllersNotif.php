<?php 

if (strpos($_SERVER['REQUEST_URI'], 'ControllersNotif.php') === false) 
{ 
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
    try {

     $NOTIF = json_encode(array_map(function($N,$T,$I)
     {return array(
     'NOTIFICACION' => $N,
     'TIPO' => $T,
     'IMPUESTO' => $I);},
     $NOT,$TIP,$IMPU));


     $CARTANOTIF = json_encode(array_map(function($c,$m,$n)
     {
     return array(
     'CARTA' => base64_encode(file_get_contents($c)),
     'MIME' => $m,
     'NOMBRE' => $n);
     },
     $CARTA["tmp_name"],$CARTA["type"],$CARTA["name"]));
        

     $query = 'CALL SP_INSERTAR_NOTIF(?,?,?,?,?)';
     $exec = $this->ConexionDB->prepare($query);
     $IDE = GetInfo('IDUsuario');
     $exec->bindParam(1,$IDE,1);
     $exec->bindParam(2,$IDC,1);
     $exec->bindParam(3,$FEN,2);
     $exec->bindParam(4,$NOTIF,2);
     $exec->bindValue(5,$CARTANOTIF,3);
     $exec->execute();
        
     if ($exec->rowCount() === 0){ return HandleError();} 

     $res = $exec->fetch(PDO::FETCH_ASSOC);

     $this->Response['message'] = $res['MENSAJE'];

     $this->Response['success'] = $this->Response['message'] === 'NIC';

     if($this->Response['success'])
     {
     EMAILS(json_encode($NOT),1);
     AUDITORIA(GetInfo('IDUsuario'),'INSERTO UNA NOTIFICACION DE INCONSISTENCIA');
     }
     else {SUMBLOCKUSER();}
     
    }catch (Exception $E) {return $E; HandleError();}
    
    return $this->Response;
    }

    public function vcarta(int $IDN) : array 
    {
        $query = 'CALL SP_VER_CARTA(?)';
        $exec = $this->ConexionDB->prepare($query);
        $exec->bindParam(1,$IDN,PDO::PARAM_INT);
        $exec->execute();

        if ($exec->rowCount() === 0){return HandleError();}
        
            $res = $exec->fetch(PDO::FETCH_ASSOC);
            $this->Response['success'] = true;
            $this->Response['CARTA'] = $res['CARTA'];

        return $this->Response;
    }


    public function DLTNotif(int $idn,string $non) : array 
    {
    try {

        $query = 'CALL SP_ELIMINAR_NOTIF(?,?)';
        $exec = $this->ConexionDB->prepare($query);
        $exec->bindParam(1,$idn,pdo::PARAM_INT);
        $exec->bindParam(2,$non,pdo::PARAM_STR);
        $exec->execute();
        
        if ($exec->rowCount() === 0){return HandleError();}
        
            $res = $exec->fetch(PDO::FETCH_ASSOC);

            $this->Response['message'] = $res['MENSAJE'];
            $this->Response['success'] = $this->Response['message'] === 'NEC';
            $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UNA NOTIFICACION DE INCONSISTENCIA') : SUMBLOCKUSER();
        
    }catch (Exception) {return HandleError();}
    
    return $this->Response;
    }
          

    public function SearchNotif(string $Cod) : array 
    {
    try {

        $query = 'CALL SP_SEARCH_NOTIF(?)';
        $exec = $this->ConexionDB->prepare($query);
        $exec->bindParam(1,$Cod,pdo::PARAM_STR);
        $exec->execute();
        
        if ($exec->rowCount() === 0){return HandleError();}
        
            $res = $exec->fetch(PDO::FETCH_ASSOC);

            $this->Response['message'] = $res['MENSAJE'];
            $this->Response['success'] = $this->Response['message'] !== 'EELS';

            if (!$this->Response['success']) {SUMBLOCKUSER();}
        
    }catch (Exception) {return HandleError();}
    
    return $this->Response;
    }


    public function DetallesCaso(string $Cod) : array 
    {
    try {

        $query = 'CALL SP_DETALLES_CASOS(?)';
        $exec = $this->ConexionDB->prepare($query);
        $exec->bindParam(1,$Cod,pdo::PARAM_STR);
        $exec->execute();
        
        if ($exec->rowCount() === 0){return HandleError();}
        
            $res = $exec->fetch(PDO::FETCH_ASSOC);
            
            $this->Response['success'] = !isset($res['MENSAJE']);

            if (!$this->Response['success']) { $this->Response['message'] = $res['MENSAJE']; SUMBLOCKUSER();}
            else 
            {        
              foreach ($res as $column => $value) 
              { $this->Response[$column] = $value; }
            }
        
    }catch (Exception) {return HandleError();}
    
    return $this->Response;
    }

    }
}
else { header("LOCATION: ./404"); }