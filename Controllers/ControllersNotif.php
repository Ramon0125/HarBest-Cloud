<?php 

if (strpos($_SERVER['REQUEST_URI'], 'ControllersNotif.php') === false) 
{ 
    class ControllersNotif extends ConexionDB
    {
    private $con;
    private $response;


    public function __construct() 
    {
     parent::__construct();
     $this->con = $this->obtenerConexion();
    }

    
    public function AGRNotif(int $IDC,string $FEN,array $NOT,array $TIP,array $IMPU, $CARTA) : array 
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
        $_FILES['CARTA']["tmp_name"],$_FILES['CARTA']["type"],$_FILES['CARTA']["name"]));
        

        $query = 'CALL SP_INSERTAR_NOTIF(?,?,?,?,?)';
        $exec = $this->con->prepare($query);
        $IDE = GetInfo('ID_USUARIO');
        $exec->bindParam(1,$IDE,1);
        $exec->bindParam(2,$IDC,1);
        $exec->bindParam(3,$FEN,2);
        $exec->bindParam(4,$NOTIF,2);
        $exec->bindValue(5,$CARTANOTIF,3);
        $exec->execute();
        
        if ($exec->rowCount() > 0) 
        {
            $res = $exec->fetch(PDO::FETCH_ASSOC);

            if ($res['MENSAJE'] === 'NIC') 
            {
            $this->response['success'] = true;
            AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UNA NOTIFICACION DE INCONSISTENCIA');
            EMAILS(json_encode($NOT),1);
            }

            else 
            {
             $this->response['success'] = false;
             SUMBLOCKUSER();
            }

            $this->response['message'] = $res['MENSAJE'];
        }
        else { $this->response['error'] = true; SUMBLOCKUSER();}
        
    }catch (Exception) { $this->response['error'] = true;}
    
    return $this->response;
    }

    public function vcarta(int $IDN) : array 
    {
        $query = 'CALL SP_VER_CARTA(?)';
        $exec = $this->con->prepare($query);
        $exec->bindParam(1,$IDN,PDO::PARAM_INT);
        $exec->execute();

        if ($exec->rowCount() > 0) 
        {
            $res = $exec->fetch(PDO::FETCH_ASSOC);
            $this->response['success'] = true;
            $this->response['CARTA'] = $res['CARTA'];
        }
        else { $this->response['error'] = true; SUMBLOCKUSER();}

        return $this->response;
    }


    public function DLTNotif(int $idn,string $non) : array 
    {
    try {

        $query = 'CALL SP_ELIMINAR_NOTIF(?,?)';
        $exec = $this->con->prepare($query);
        $exec->bindParam(1,$idn,pdo::PARAM_INT);
        $exec->bindParam(2,$non,pdo::PARAM_STR);

        $exec->execute();
        
        if ($exec->rowCount() > 0) 
        {
            $res = $exec->fetch(PDO::FETCH_ASSOC);
            $this->response['success'] = $res['MENSAJE'] === 'NEC';
            $this->response['message'] = $res['MENSAJE'];

            if ($this->response['success']) 
            {AUDITORIA(GetInfo('ID_USUARIO'),'ELIMINO UNA NOTIFICACION DE INCONSISTENCIA');}

            else 
            {SUMBLOCKUSER();}

        }
        else { $this->response['error'] = true; SUMBLOCKUSER();}
        
    }catch (Exception) { $this->response['error'] = true; SUMBLOCKUSER(); }
    
    return $this->response;
    }
          
    }
}
else { header("LOCATION: ./404"); }