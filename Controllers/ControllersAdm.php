<?php

if (preg_match('/ControllersAdm(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

class ControllersAdm extends ConexionDB
{
    private $ConexionDB;
    private $Response;


    public function __construct()
    {
      parent::__construct();
      $this->ConexionDB = $this->obtenerConexion();
    }


    public function agradm(string $name,string $direc): array
    {
      try 
      {
        // Llamada al procedimiento almacenado para insertar la administracion
        $Query = "CALL SP_INSERTAR_ADM(?,?)";
        $QueryExecution = $this->ConexionDB->prepare($Query);
        $QueryExecution->bindParam(1, $name);
        $QueryExecution->bindParam(2, $direc);
        $QueryExecution->execute();
    
        // Si la consulta no trae datos dispara error
        if($QueryExecution->rowCount() === 0) { return HandleError();}
    
        $Data = $QueryExecution->fetch();

        $this->Response['success'] = $Data['MENSAJE'] === 'AIC';
        $this->Response['message'] = $Data['MENSAJE'];
        $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'INSERTO UNA ADMINISTRACION') : SUMBLOCKUSER();
      
      }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

      return $this->Response;
    }


    public function edtadm(int $id, string $name, string $nname, string $ndirecc) : array 
    {
      try 
      {
        // Llamada al procedimiento almacenado para modificar la administracion
        $Query = "CALL SP_MODIFICAR_ADM(?,?,?,?)";
        $QueryExecution = $this->ConexionDB->prepare($Query);
        $QueryExecution->bindParam(1,$id,PDO::PARAM_INT);
        $QueryExecution->bindParam(2,$name);
        $QueryExecution->bindParam(3,$nname);
        $QueryExecution->bindParam(4,$ndirecc);
        $QueryExecution->execute();

        // Si la consulta no trae datos dispara error
        if($QueryExecution->rowCount() == 0) { return HandleError(); }
 
        $Data = $QueryExecution->fetch();

        $this->Response['message'] = $Data['MENSAJE'];
        $this->Response['success'] = $this->Response['message'] === 'AMC';
        $this->Response['success'] ? AUDITORIA(GetInfo('IDUsuario'),'MODIFICO UNA ADMINISTRACION') : SUMBLOCKUSER();
      
      }catch(Exception $e) {error_log($e->getMessage());  return HandleError();}

      return $this->Response;
    }

}
