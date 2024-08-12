<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && preg_match('/datos(?:\.php)?/', $_SERVER['REQUEST_URI']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') 
{ http_response_code(404); die(header('Location: ./404')); }

if (!class_exists('ConexionDB')) { require __DIR__.'/Conexion.php'; }
if (!function_exists('Validarcadena1')) { require __DIR__.'/Functions.php'; }

function Datos(int $op): array 
{
    $conexionDB = new ConexionDB();
    $conexion = $conexionDB->obtenerConexion(); 

    $select = array( 1 => "VW_USERS", 2 => "VW_CLIENTES", 3 => "ADM", 4 => "ALL_NOTIF", 5 => "ALL_NOTIF_FOR_DETALLE",
    6 => "ALL_DETALLES", 7 => "ALL_NOTIF_FOR_ESCRITO", 8 => "ALL_ESCRITO", 9 => "ALL_NOTIF_FOR_RESPUESTA",
    10 => "ALL_RESPUESTA");

    $ejecucion = $conexion->prepare("SELECT * FROM ".$select[$op]);
    $ejecucion->execute();
    $rest = $ejecucion->fetchAll();
    return $rest ? $rest : [];
}

if (isset($_POST['tipo'])) {
echo json_encode(Validarcadena1($_POST['tipo']) == true ? Datos($_POST['tipo']) : HandleError());
}