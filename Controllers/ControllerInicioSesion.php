<?php

if (strpos($_SERVER['REQUEST_URI'], 'ControllerInicioSesion.php') === false) { 

class ControllerInicioSesion extends ConexionDB 
{
    private $response = array();
    private $exec;
 
   public function __construct()
   {
    parent::__construct();
    $this->exec = $this->obtenerConexion();
   }
   
   public function ValidarLogin(string $Email, string $Password) : array 
   {
    try
    {
    $sql = "CALL SP_VALIDAR_LOGIN(?,?)";
    $ejecucion = $this->exec->prepare($sql);
    $ejecucion->bindParam(1,$Email,PDO::PARAM_STR);
    $ejecucion->bindParam(2,$Password,PDO::PARAM_STR);
    $ejecucion->execute(); 
       
    if ($ejecucion->rowCount() > 0) 
    { $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC); 
     
      if (isset($resultado['CCLAVE'])) 
      {
        setcookie('IDENTITY', $resultado['TOKEN'], 0, '/', '', true, true);
        $this->response['success'] = true;

        if($resultado['CCLAVE'] === 1){$this->response['message'] = 'a';}
        else{$this->response['message'] = 'b'; $_SESSION['LOG'] = true;  setcookie('PASS', $Password, 0, '/', '', true, true); }
      }
     
      else {$this->response['message'] = $resultado['MENSAJE'];  SUMBLOCKUSER(); }
    }
    else {$this->response['error'] = true; SUMBLOCKUSER();} 

    } catch(Exception){ $this->response['error'] = true; SUMBLOCKUSER(); } 

    return $this->response; 
    }


    public function ModificarPassword(string $passwordn1) : array 
    {
      
    try 
    {  $val = GetInfo('EMAIL');
    $sql = "CALL SP_MODIFICAR_CLAVES_USUARIOS (?, ?, ?)";
    $ejecucion = $this->exec->prepare($sql);
    $ejecucion->bindParam(1, $val, PDO::PARAM_STR);
    $ejecucion->bindParam(2, $_COOKIE['PASS'], PDO::PARAM_STR);
    $ejecucion->bindParam(3, $passwordn1, PDO::PARAM_STR);
    $ejecucion->execute();

    if ($ejecucion->rowCount() > 0) 
    {
    $resultado = $ejecucion->fetch(PDO::FETCH_ASSOC);
    if($resultado['MENSAJE'] === 'CMC')
    {
    $this->response['success'] = true;
    AUDITORIA(GetInfo('ID_USUARIO'),'MODIFICO SU CONTRASEÑA'); 
    unset($_SESSION['LOG']); 
    setcookie('PASS', '', time() - 3600, '/', '', false, true);}
    else {$this->response['success'] = false; SUMBLOCKUSER();}
    
    $this->response['message'] = $resultado['MENSAJE'];
    }

    else {$this->response['error'] = true; SUMBLOCKUSER();}

    } catch(Exception) { $this->response['error'] = true; SUMBLOCKUSER();}

    return $this->response;
    }

}}

else 
{header('LOCATION: ./404');} 