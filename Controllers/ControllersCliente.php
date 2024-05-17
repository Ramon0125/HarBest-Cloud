<?php 

if (strpos($_SERVER['REQUEST_URI'], 'ControllersCliente.php') === false) { 



class ControllerCliente extends ConexionDB {
    private $CDB;
    private $response = array();


    public function __construct() 
    {
        parent::__construct();
        $this->CDB = $this->obtenerConexion();
    }


    public function InsertCliente(int $rnc, string $email, string $nombre, int $adm) : array 
    {
    try{

        $query = "CALL SP_INSERTAR_CLIENTES(?,?,?,?)";
        $ejecutar = $this->CDB->prepare($query);
        $ejecutar->bindParam(1,$rnc,PDO::PARAM_INT);
        $ejecutar->bindParam(2,$email,PDO::PARAM_STR);
        $ejecutar->bindParam(3,$nombre,PDO::PARAM_STR);
        $ejecutar->bindParam(4,$adm,PDO::PARAM_STR);
        $ejecutar->execute();

        if($ejecutar->rowCount() > 0)
        {
            $resultado = $ejecutar->fetch(PDO::FETCH_ASSOC);

            if($resultado['MENSAJE'] === 'CIC'){$this->response['success'] = true; 
            AUDITORIA(GetInfo('ID_USUARIO'),'INSERTO UN CLIENTE');}

            else{$this->response['success'] = false; SUMBLOCKUSER();}

            $this->response['message'] = $resultado['MENSAJE'];
        }

        else { $this->response['error'] = true; SUMBLOCKUSER();}

    }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}
    
    return $this->response;
    }


    public function VerDatosCLT(int $ID,string $TOKEN) : array 
    {
    try {
        $query = "CALL SP_VER_DATOS_CLIENTES(?,?)";
        $ejecutar = $this->CDB->prepare($query);
        $ejecutar->bindParam(1,$ID,PDO::PARAM_INT);
        $ejecutar->bindParam(2,$TOKEN,PDO::PARAM_STR);
        $ejecutar->execute();
    
        if($ejecutar->rowCount() > 0)
        {
        $resultado = $ejecutar->fetch(PDO::FETCH_ASSOC);

        $this->response['success'] = !isset($resultado['MENSAJE']);
    
        if(!isset($resultado['MENSAJE']))
        {
        foreach ($resultado as $column => $value) 
        { $this->response[$column] = $value; }
        }
                
        else {$this->response['message'] = $resultado['MENSAJE']; SUMBLOCKUSER();}
        }

        else { $this->response['error'] = true; SUMBLOCKUSER();}

    }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}
    
    return $this->response;
    }


    public function EditarCliente(int $id, string $nc, int $rnc, string $email, string $nombre, int $adm) : array 
    {
    try {
        $query = "CALL SP_MODIFICAR_CLIENTES(?,?,?,?,?,?)";
        $ejecutar = $this->CDB->prepare($query);
        $ejecutar->bindParam(1,$id,PDO::PARAM_INT);
        $ejecutar->bindParam(2,$nc,PDO::PARAM_STR);
        $ejecutar->bindParam(3,$rnc,PDO::PARAM_INT);
        $ejecutar->bindParam(4,$email,PDO::PARAM_STR);
        $ejecutar->bindParam(5,$nombre,PDO::PARAM_STR);
        $ejecutar->bindParam(6,$adm,PDO::PARAM_INT);
        $ejecutar->execute();
       
        if($ejecutar->rowCount() > 0)
        {
        $resultado = $ejecutar->fetch(PDO::FETCH_ASSOC);
       
        if($resultado['MENSAJE'] === 'CMC1'){$this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'MODIFICO UN CLIENTE');}
        else{$this->response['success'] = false; SUMBLOCKUSER();}

        $this->response['message'] = $resultado['MENSAJE']; 
        }
        else { $this->response['error'] = true; SUMBLOCKUSER(); }
 
    }catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
    }


    public function DeleteCliente(int $id, string $name): array
    {       
    try{
    $query = "CALL SP_ELIMINAR_CLIENTES(?,?)";
    $ejecutar = $this->CDB->prepare($query);
    $ejecutar->bindParam(1,$id,PDO::PARAM_INT);
    $ejecutar->bindParam(2,$name,PDO::PARAM_STR);
    $ejecutar->execute();
           
    if($ejecutar->rowCount() > 0)
    {
    $resultado = $ejecutar->fetch(PDO::FETCH_ASSOC);
           
    if($resultado['MENSAJE'] === 'CEC'){$this->response['success'] = true; AUDITORIA(GetInfo('ID_USUARIO'),'ELIMINO UN CLIENTE');}
    else{$this->response['success'] = false; SUMBLOCKUSER();}

    $this->response['message'] = $resultado['MENSAJE'];
    }
    else { $this->response['error'] = true; SUMBLOCKUSER();}

    }catch(Exception) { $this->response['error'] = true;}
    
    return $this->response;
    }
}
}
else { header("LOCATION: ./404"); }