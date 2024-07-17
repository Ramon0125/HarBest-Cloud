<?php

if (strpos($_SERVER['REQUEST_URI'], 'ControllerInicioSesion.php') !== false) { header('LOCATION: ./404');} 

else {

class ControllerInicioSesion extends ConexionDB 
{
    private $response = array();
    private $ConexionDB;
 
  public function __construct()
   {
    parent::__construct(); //Llamada al constructor de la clase padre en este caso conexion
    $this->ConexionDB = $this->obtenerConexion(); // Asignar la conexión a la base de datos a la propiedad ConexionDB
   }
   
  public function ValidarLogin(string $Email, string $Password) : array 
  {
    try
    {
    $Query = "CALL SP_VALIDAR_LOGIN(?,?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1,$Email,2);
    $QueryExecution->bindParam(2,$Password,2);
    $QueryExecution->execute();
       
    if ($QueryExecution->rowCount() === 0){return HandleError();} //Si la consulta no trae datos dispara error

      $UserData = $QueryExecution->fetch(2); //Se obtienen los resultados de la consulta en forma de un array asociativo
     
      $this->response['success'] = !isset($UserData['MENSAJE']); //Evalua si existe el mensaje de error

      if (!$this->response['success']) {$this->response['message'] = $UserData['MENSAJE'];  SUMBLOCKUSER();} //Si existe el mensaje de error cancela la operacion
     
      else 
      {   
        setcookie('IDENTITY', $UserData['Token'], 0, '/', '', true, true); //Asigna la cookie que determina la identidad del usuario
        
        $this->response['CCLAVE'] = $UserData['CClave'];
        
        if($this->response['CCLAVE'] === 'F') //Aciones si es el primer login del usuario
        {
          $_SESSION['LOG'] = true;  
          setcookie('PASS', $Password, 0, '/', '', true, true); 
        }
      }

    } catch(Exception){return HandleError();} 

    return $this->response; 
  }


  public function ModificarPassword(string $passwordn1) : array 
  {     
    try 
    {  
    $val = GetInfo('Email');
    $Query = "CALL SP_MODIFICAR_CLAVES_USUARIOS (?, ?, ?)";
    $QueryExecution = $this->ConexionDB->prepare($Query);
    $QueryExecution->bindParam(1, $val, PDO::PARAM_STR);
    $QueryExecution->bindParam(2, $_COOKIE['PASS'], PDO::PARAM_STR);
    $QueryExecution->bindParam(3, $passwordn1, PDO::PARAM_STR);
    $QueryExecution->execute();

    if ($QueryExecution->rowCount() === 0) {return HandleError();}
  
    $UserData = $QueryExecution->fetch(PDO::FETCH_ASSOC);
    $this->response['message'] = $UserData['MENSAJE'];
    $this->response['success'] = $this->response['message'] === 'CMC';

    if(!$this->response['success']){SUMBLOCKUSER();}
    
    else     
    {
      AUDITORIA(GetInfo('IDUsuario'),'MODIFICO SU CONTRASEÑA'); 
      unset($_SESSION['LOG']); 
      setcookie('PASS', '', time() - 3600, '/', '', false, true);
    }
    }
    catch(Exception) {return HandleError();}

    return $this->response;
  }

}

}