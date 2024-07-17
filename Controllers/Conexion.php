<?php 

const APP_NAME = 'HarBest Cloud';
///VARIABLE GLOBAL DEL NOMBRE DE LA APLICACION

const APP_URL = "http://127.0.0.1/PROGRAMAS/HarBest-Cloud/";
///VARIABLE GLOBAL DE LA URL DE LA APLICACION

const APP_HOST = '127.0.0.1';


const APP_DBNAME = 'DEMO_FIDUCIAL';


const APP_DBUSER = 'root';


const APP_DBPASS = '1234';


if (strpos($_SERVER['REQUEST_URI'], 'Conexion.php') === false) 
{ 

class ConexionDB 
{
    private $conexion;

    public function __construct() 
    {
        try { 
        $dsn = 'mysql:host='.APP_HOST.';dbname='.APP_DBNAME;
        $usuario = APP_DBUSER;
        $clave = APP_DBPASS;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ);
        
        $this->conexion = new PDO($dsn, $usuario, $clave, $options); } 
        catch (PDOException $e) {die("Error de conexión: " . $e->getMessage());}
    }

    public function obtenerConexion() { return $this->conexion; }
}

function CerrarSesion() : void 
{
 foreach ($_COOKIE as $nombre => $valor) 
 {if($nombre !== 'PHPSESSID'){setcookie($nombre, '', time() - 3600, '/', '', false, true); }}   
}

}
else {header('LOCATION: ./404');}
