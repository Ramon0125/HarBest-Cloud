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
            EMAILS($NON);
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
        else { $this->response['error'] = true; SUMBLOCKUSER();}

        return $this->response;
    }


    public function vdatosnotif(string $ID, string $NOT) : array {
    
        $query = 'CALL VER_DATOS_NOTIF(?,?)';
        $res = $this->con->prepare($query);
        $res->bindParam(1,$ID,PDO::PARAM_INT);
        $res->bindParam(2,$NOT,PDO::PARAM_STR);
        $res->execute();

        if($res->rowCount() > 0)
        {   
            $resu = $res->fetch(PDO::FETCH_ASSOC);
            if (!isset($resu['MENSAJE'])) 
            {
            $this->response['success'] = true;
            $this->response['IDCliente'] = $resu['IDCliente'];
            $this->response['NOMBRE_CLIENTE'] = $resu['NOMBRE_CLIENTE'];
            $this->response['FECHANotif'] = $resu['FECHANotif'];
            $this->response['NONotificacion'] = $resu['NONotificacion'];
            $this->response['TIPONotif'] = $resu['TIPONotif'];
            $this->response['MOTIVONotif'] = $resu['MOTIVONotif'];
            $this->response['Aincumplimiento'] = $resu['Aincumplimiento'];
            }
            else {$this->response['success'] = false; $this->response['message'] = $resu['MENSAJE']; SUMBLOCKUSER();}
        }
        else { $this->response['error'] = true; SUMBLOCKUSER();}
        
    return $this->response;
        
    }

    public function EDTNotif(int $idn,string $non,int $nidcli,string $nfech,string $nnon,string $ntipno,string $nmotnot,int $naincu) : array 
    {
    try {

        $query = 'CALL SP_MODIFICAR_NOTIF(?,?,?,?,?,?,?,?)';
        $exec = $this->con->prepare($query);
        $exec->bindParam(1,$idn,pdo::PARAM_INT);
        $exec->bindParam(2,$non,pdo::PARAM_STR);
        $exec->bindParam(3,$nidcli,pdo::PARAM_INT);
        $exec->bindParam(4,$nfech,pdo::PARAM_STR);
        $exec->bindParam(5,$nnon,pdo::PARAM_STR);
        $exec->bindParam(6,$ntipno,pdo::PARAM_STR);
        $exec->bindParam(7,$nmotnot,pdo::PARAM_STR);
        $exec->bindParam(8,$naincu,pdo::PARAM_INT);
        $exec->execute();
        
        if ($exec->rowCount() > 0) 
        {
            $res = $exec->fetch(PDO::FETCH_ASSOC);

            if ($res['MENSAJE'] === 'NMC') 
            {
            $this->response['success'] = true;
            AUDITORIA(GetInfo('ID_USUARIO'),'MODIFICO UNA NOTIFICACION DE INCONSISTENCIA');
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

            if ($res['MENSAJE'] === 'NEC') 
            {
            $this->response['success'] = true;
            AUDITORIA(GetInfo('ID_USUARIO'),'ELIMINO UNA NOTIFICACION DE INCONSISTENCIA');
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
          
    }
}
else { header("LOCATION: ./404"); }