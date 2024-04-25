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

    public function AGRNotif(int $IDC,string $NON,string $FEN,string $TIN,string $MON, string $CARTA, string $AIN, string $COM, string $MIME) : array 
    {
    try {

        $query = 'CALL SP_INSERTAR_NOTIF(?,?,?,?,?,?,?,?,?,?)';
        $exec = $this->con->prepare($query);
        $IDE = GetInfo('ID_USUARIO');
        $exec->bindParam(1,$IDE,pdo::PARAM_INT);
        $exec->bindParam(2,$IDC,pdo::PARAM_INT);
        $exec->bindParam(3,$NON,pdo::PARAM_STR);
        $exec->bindParam(4,$FEN,pdo::PARAM_STR);
        $exec->bindParam(5,$TIN,pdo::PARAM_STR);
        $exec->bindParam(6,$MON,pdo::PARAM_STR);
        $exec->bindParam(7,$CARTA,pdo::PARAM_STR);
        $exec->bindParam(8,$AIN,pdo::PARAM_STR);
        $exec->bindParam(9,$COM,pdo::PARAM_STR);
        $exec->bindParam(10,$MIME,pdo::PARAM_STR);
        $exec->execute();
        
        if ($exec->rowCount() > 0) 
        {
            $res = $exec->fetch(PDO::FETCH_ASSOC);

            if ($res['MENSAJE'] === 'NIC') 
            {
            $this->response['success'] = true;
            AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UNA NOTIFICACION DE INCONSISTENCIA');
            EMAILS($NON,'NOTIF.');
            }

            else 
            {
             $this->response['success'] = false;
             SUMBLOCKUSER();
            }

            $this->response['message'] = $res['MENSAJE'];
        }
        else { $this->response['error'] = true; SUMBLOCKUSER();}
        
    }catch (Exception) { $this->response['error'] = true; SUMBLOCKUSER(); }
    finally{unset($query,$exec,$res);}
    
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
            $this->response['TIPO'] = $res['MIME'];
        }
        else { $this->response['error1'] = true; SUMBLOCKUSER();}

        return $this->response;
    }
          
    }
}
else { header("LOCATION: ./404"); }