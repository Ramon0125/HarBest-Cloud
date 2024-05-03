<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' || strpos($_SERVER['REQUEST_URI'], 'datos.php') === false) {

if (!class_exists('ConexionDB')) { require __DIR__.'/Conexion.php'; }


$conexionDB = new ConexionDB();
$conexion = $conexionDB->obtenerConexion(); 
    
function Users(): array {
    global $conexion;
    $sql1 = "SELECT * FROM VW_USERS";
    $ejecucion1 = $conexion->prepare($sql1);
    $ejecucion1->execute();
    $usr = $ejecucion1->fetchAll(PDO::FETCH_ASSOC);
    return $usr ? $usr : [];

    }

function ADM(): array {
    global $conexion; 
    $sql1 = "SELECT * FROM ADM";
    $ejecucion11 = $conexion->prepare($sql1);
    $ejecucion11->execute();
    $adm = $ejecucion11->fetchAll(PDO::FETCH_ASSOC);
    return $adm ? $adm : [];

    }

function CLT(): array {
    global $conexion;
    $sql1 = "SELECT * FROM VW_CLIENTES";
    $ejecucion111 = $conexion->prepare($sql1);
    $ejecucion111->execute();
    $clt = $ejecucion111->fetchAll(PDO::FETCH_ASSOC);
    return $clt ? $clt : [];
    }

    function NTF(): array{
    global $conexion;
    $sql1 = "SELECT * FROM ALL_NOTIF";
    $ejecucion1111 = $conexion->prepare($sql1);
    $ejecucion1111->execute();
    $not = $ejecucion1111->fetchAll(PDO::FETCH_ASSOC);
    return $not ? $not : [];
    }

if(isset($_POST['tipo']))
{ 
    
    switch($_POST['tipo'])
    {
        case 1: $func = Users(); break;
        case 2: $func = CLT(); break;
        case 3: $func = ADM(); break;
        case 4: $func = NTF(); break;
    }

    echo json_encode($func);
}
}

else { header("LOCATION: ./404"); }