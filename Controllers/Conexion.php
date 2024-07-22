<?php

if (strpos($_SERVER['REQUEST_URI'], 'Conexion.php') !== false) { header('LOCATION: ./404'); }

require (file_exists('../vendor/autoload.php') ? '..' : '.').'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('APP_NAME',$_ENV['PAGE_NAME']);
///VARIABLE GLOBAL DEL NOMBRE DE LA APLICACION

define('APP_URL',$_ENV['PAGE_URL']);
///VARIABLE GLOBAL DE LA URL DE LA APLICACION


function CerrarSesion() : void 
{
    // Eliminar todas las cookies
    foreach ($_COOKIE as $nombre => $valor) 
    {
        setcookie($nombre, '', time() - 3600, '/', '', isset($_SERVER["HTTPS"]), true);
    }
    
    // Destruir la sesión
    session_start();
    session_unset();
    session_destroy();
    
    // Asegurarse de que la cookie de sesión esté eliminada
    if (ini_get("session.use_cookies")) 
    {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
}


class ConexionDB 
{
    private $conexion;

    public function __construct() 
    {
      try { 

      $dsn = 'mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'];
      $usuario = $_ENV['DB_USER'];
      $clave = $_ENV['DB_PASS'];
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
      
      $this->conexion = new PDO($dsn, $usuario, $clave, $options); 

      } catch (Exception) { die(header('LOCATION: ../Error/?Error=002')); }
    }

    public function obtenerConexion() { return $this->conexion; }
}