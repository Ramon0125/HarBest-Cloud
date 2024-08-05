<?php 

if (preg_match('/ControllersCliente(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

class ControllerCliente extends ConexionDB {
    private $ConexionDB;
    private $Response;

    
    public function __construct() 
    {
        parent::__construct();
        $this->ConexionDB = $this->obtenerConexion();
    }


    public function InsertCliente(int $rnc, string $email, string $nombre, string $tpersona, int $adm) : array 
    {
        try
        {
            // Llamada al procedimiento almacenado para insertar el cliente
            $Query = "CALL SP_INSERTAR_CLIENTES(?,?,?,?,?)";
            $QueryExecution = $this->ConexionDB->prepare($Query);
            $QueryExecution->bindParam(1,$rnc,PDO::PARAM_INT);
            $QueryExecution->bindParam(2,$email);
            $QueryExecution->bindParam(3,$nombre);
            $QueryExecution->bindParam(4,$tpersona);
            $QueryExecution->bindParam(5,$adm,PDO::PARAM_INT);
            $QueryExecution->execute();

            // Si la consulta no trae datos dispara error
            if($QueryExecution->rowCount() === 0) {return HandleError();}
    
            $Data = $QueryExecution->fetch();

            $this->Response['message'] = $Data['MENSAJE'];
            $this->Response['success'] = $this->Response['message'] === 'CIC';
            $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UN CLIENTE') : SUMBLOCKUSER();
        
        }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

        return $this->Response;
    }


    public function VerDatosCLT(int $ID,string $TOKEN) : array 
    {
        try 
        {
            // Llamada al procedimiento almacenado para ver los datos del cliente
            $Query = "CALL SP_VER_DATOS_CLIENTES(?,?)";
            $QueryExecution = $this->ConexionDB->prepare($Query);
            $QueryExecution->bindParam(1,$ID,PDO::PARAM_INT);
            $QueryExecution->bindParam(2,$TOKEN);
            $QueryExecution->execute();
    
            // Si la consulta no trae datos dispara error
            if($QueryExecution->rowCount() === 0){ return HandleError();}
        
            $Data = $QueryExecution->fetch();

            $this->Response['success'] = !isset($Data['MENSAJE']);
    
            if($this->Response['success'])
            { foreach ($Data as $column => $value) { $this->Response[$column] = $value; } }

            else {$this->Response['message'] = $Data['MENSAJE']; SUMBLOCKUSER();}
        
        }catch(Exception $e) { error_log($e->getMessage());  return HandleError();}
    
        return $this->Response;
    }


    public function EditarCliente(int $id, string $nc, int $rnc, string $email, string $nombre,string $Tpersona, int $adm)
    {
        try 
        {
            // Llamada al procedimiento almacenado para modificar el cliente
            $Query = "CALL SP_MODIFICAR_CLIENTES(?,?,?,?,?,?,?)";
            $QueryExecution = $this->ConexionDB->prepare($Query);
            $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
            $QueryExecution->bindParam(2,$nc);
            $QueryExecution->bindParam(3,$rnc);
            $QueryExecution->bindParam(4,$email);
            $QueryExecution->bindParam(5,$nombre);
            $QueryExecution->bindParam(6,$Tpersona);
            $QueryExecution->bindParam(7,$adm,PDO::PARAM_INT);
            $QueryExecution->execute();

            // Si la consulta no trae datos dispara error
            if($QueryExecution->rowCount() === 0){ return HandleError(); }
        
            $Data = $QueryExecution->fetch();
        
            $this->Response['message'] = $Data['MENSAJE']; 
            $this->Response['success'] = $this->Response['message'] === 'CMC1';
            $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'MODIFICO UN CLIENTE') : SUMBLOCKUSER();
           
        }catch(Exception $e) { error_log($e->getMessage());  return HandleError();}

    return $this->Response;
    }


    public function DeleteCliente(int $id, string $name): array
    {       
        try
        {
            // Llamada al procedimiento almacenado para eliminar el cliente
            $Query = "CALL SP_ELIMINAR_CLIENTES(?,?)";
            $QueryExecution = $this->ConexionDB->prepare($Query);
            $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
            $QueryExecution->bindParam(2,$name);
            $QueryExecution->execute();
           
            // Si la consulta no trae datos dispara error
            if($QueryExecution->rowCount() === 0){ return HandleError();}
    
            $Data = $QueryExecution->fetch();

            $this->Response['message'] = $Data['MENSAJE'];
            $this->Response['success'] = $this->Response['message'] === 'CEC';
            $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'ELIMINO UN CLIENTE') : SUMBLOCKUSER();

        }catch(Exception $e) { error_log($e->getMessage());  return HandleError();}

    return $this->Response;
    }


    public function GetCCCliente(int $id, int $type): array
    {
        try
        {
            //Array de nombres de procedimientos
            $SPName = array(1 => 'NTF', 2 => 'DDC', 3 => 'EDD');

            // Llamada al procedimiento almacenado para obtener los CC del cliente
            $Query = "CALL SP_GET_CC_".$SPName[$type]."(?)";
            $QueryExecution = $this->ConexionDB->prepare($Query);
            $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
            $QueryExecution->execute();
           
            // Si la consulta no trae datos dispara error
            if($QueryExecution->rowCount() === 0) { return HandleError(); }

            $this->Response['success'] = true;
            $this->Response['message'] = $QueryExecution->fetch();

        }catch(Exception $e) { error_log($e->getMessage());  return HandleError(); }

    return $this->Response;
    }
}
