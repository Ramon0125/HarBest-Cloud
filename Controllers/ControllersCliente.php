<?php 

if (strpos($_SERVER['REQUEST_URI'], 'ControllersCliente.php') === false) { 



class ControllerCliente extends ConexionDB {
    private $ConexionDB;
    private $Response = array();


    public function __construct() 
    {
        parent::__construct();
        $this->ConexionDB = $this->obtenerConexion();
    }


    public function InsertCliente(int $rnc, string $email, string $nombre, int $adm) : array 
    {

    try{
        $Query = "CALL SP_INSERTAR_CLIENTES(?,?,?,?)";
        $QueryExecution = $this->ConexionDB->prepare($Query);
        $QueryExecution->bindParam(1,$rnc,PDO::PARAM_INT);
        $QueryExecution->bindParam(2,$email,PDO::PARAM_STR);
        $QueryExecution->bindParam(3,$nombre,PDO::PARAM_STR);
        $QueryExecution->bindParam(4,$adm,PDO::PARAM_STR);
        $QueryExecution->execute();

        if($QueryExecution->rowCount() == 0) {return HandleError();}
    
            $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

            $this->Response['success'] = $Data['MENSAJE'] === 'CIC';
            $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN CLIENTE') : SUMBLOCKUSER();
            $this->Response['message'] = $Data['MENSAJE'];
    }
    catch(Exception) {return HandleError();}

    return $this->Response;
    }


    public function VerDatosCLT(int $ID,string $TOKEN) : array 
    {
    try {
        $Query = "CALL SP_VER_DATOS_CLIENTES(?,?)";
        $QueryExecution = $this->ConexionDB->prepare($Query);
        $QueryExecution->bindParam(1,$ID,PDO::PARAM_INT);
        $QueryExecution->bindParam(2,$TOKEN,PDO::PARAM_STR);
        $QueryExecution->execute();
    
        if($QueryExecution->rowCount() == 0){ return HandleError();}
        
        $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

        $this->Response['success'] = !isset($Data['MENSAJE']);
    
        if($this->Response['success'])
        {
        foreach ($Data as $column => $value) 
        { $this->Response[$column] = $value; }
        }

        else {$this->Response['message'] = $Data['MENSAJE']; SUMBLOCKUSER();}
        
    }catch(Exception) { return HandleError();}
    
    return $this->Response;
    }


    public function EditarCliente(int $id, string $nc, int $rnc, string $email, string $nombre, int $adm) : array 
    {
    try {
        $Query = "CALL SP_MODIFICAR_CLIENTES(?,?,?,?,?,?)";
        $QueryExecution = $this->ConexionDB->prepare($Query);
        $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
        $QueryExecution->bindParam(2,$nc,PDO::PARAM_STR);
        $QueryExecution->bindParam(3,$rnc,PDO::PARAM_INT);
        $QueryExecution->bindParam(4,$email,PDO::PARAM_STR);
        $QueryExecution->bindParam(5,$nombre,PDO::PARAM_STR);
        $QueryExecution->bindParam(6,$adm,PDO::PARAM_INT);
        $QueryExecution->execute();
       
        if($QueryExecution->rowCount() == 0){ return HandleError(); }
        
        $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);
        
        $this->Response['success'] = $Data['MENSAJE'] === 'CMC1';
        $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'MODIFICO UN CLIENTE') : SUMBLOCKUSER();
        $this->Response['message'] = $Data['MENSAJE']; 
         
    }catch(Exception) { return HandleError();}

    return $this->Response;
    }


    public function DeleteCliente(int $id, string $name): array
    {       
    try{
    $Query = "CALL SP_ELIMINAR_CLIENTES(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->bindParam(2,$name,PDO::PARAM_STR);
    $QueryExecution->execute();
           
    if($QueryExecution->rowCount() == 0){ return HandleError();}
    
    $Data = $QueryExecution->fetch(PDO::FETCH_ASSOC);

    $this->Response['success'] = $Data['MENSAJE'] === 'CEC';
    $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UN CLIENTE') : SUMBLOCKUSER();
    $this->Response['message'] = $Data['MENSAJE'];

    }catch(Exception) { return HandleError();}

    return $this->Response;
    }


    public function GetCCCliente(int $id, int $type): array
    {
    try{
    $Query = $type === 1 ? "CALL SP_GET_CC(?)" : "CALL SP_GET_CC_DDC(?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
    $QueryExecution->execute();
           
    if($QueryExecution->rowCount() > 0)
    {
    $this->Response['success'] = true;
    $this->Response['message'] = $QueryExecution->fetch(PDO::FETCH_ASSOC);
    }
    }catch(Exception) { return HandleError();}

    return $this->Response;
    }
}
}
else { header("LOCATION: ./404"); }