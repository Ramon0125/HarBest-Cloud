<?php
if (strpos($_SERVER['REQUEST_URI'], 'ControllersBlocks.php') === false) { 

$IP = $_SERVER['REMOTE_ADDR'];
$CONDB1 = NEW ConexionDB();
$CONDB = $CONDB1->obtenerConexion();


if (!isset($_COOKIE['identificador']))
{
    $identificador = $IP.session_id(); 
    setcookie('identificador', md5($identificador),0,'/', '', true, true);
}
else {$identificador = $_COOKIE['identificador'];}


function SUMBLOCKUSER()
{
    global $identificador;
    if( isset($_COOKIE['ERRORS']) && $_COOKIE['ERRORS'] > 2) 
    {BLOCKUSER($identificador);}
    
    elseif(!isset($_COOKIE['ERRORS'])) 
    { setcookie('ERRORS', 1,0,'/', '', true, true);}
    
    else
    {   $VAL = $_COOKIE['ERRORS'] + 1;
        setcookie('ERRORS',$VAL,0,'/', '', true, true);  
    }
}



function BLOCKUSER($COOKIE)
{
   global $IP;
   global $CONDB;

   $MYSQL = "CALL BLOQUEAR_USER('" . $COOKIE . "','" . $IP . "')";
   $EJECUTAR = $CONDB->prepare($MYSQL);
   $EJECUTAR->execute();
   setcookie('ERRORS','',time() - 3600,'/', '', true, true);
}



function VALIDARBLOCK() : string
{
    global $IP;
    global $identificador;
    global $CONDB;
 
    $MYSQL = "CALL VALIDAR_USER('" . $identificador . "','" . $IP . "')";
    $EJECUTAR = $CONDB->prepare($MYSQL);
    $EJECUTAR->execute();

    $EJECUTAR1 = $EJECUTAR->fetch(PDO::FETCH_ASSOC);

    return $EJECUTAR1['MENSAJE'];
}



function AUDITORIA(string $ID, string $MOVIMIENTO) : void
{ global $CONDB;
$query = "CALL SP_MOVIMIENTOS(?,?)";
$res = $CONDB->prepare($query);
$res->bindParam(1,$ID,PDO::PARAM_INT);
$res->bindParam(2,$MOVIMIENTO,PDO::PARAM_STR);
$res->execute();
}

class USERDATA
{

public static function GetInfo($COLUMNA)
{
    if(isset($_COOKIE['IDENTITY'])){
    $CONDB1 = NEW ConexionDB();
    $CONDB = $CONDB1->obtenerConexion();
    $query = "SELECT ". $COLUMNA . " FROM USUARIOS WHERE TOKEN = '". $_COOKIE['IDENTITY'] . "'"  ;
    $RES = $CONDB->prepare($query);
    $RES->execute();
    $RES1 = $RES->fetch(PDO::FETCH_ASSOC);
    
    $RES2 = $RES1 == false ? 0 : reset($RES1);
    return $RES2;}
}


}
}
else {header('LOCATION: ./404');}