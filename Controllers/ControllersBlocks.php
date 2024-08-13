<?php

if (preg_match('/ControllersBlocks(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }


$IP = $_SERVER['REMOTE_ADDR'];

if (!isset($_COOKIE['identificador']))
{
    $identificador = $IP.session_id(); 
    setcookie('identificador', md5($identificador),0,'/', '', false, true);
}
else {$identificador = $_COOKIE['identificador'];}


$CONDB1 = NEW ConexionDB();
$CONDB = $CONDB1->obtenerConexion();

function SUMBLOCKUSER() : void
{
    global $identificador;
    if( isset($_COOKIE['ERRORS']) && $_COOKIE['ERRORS'] >= 10) 
    {BLOCKUSER($identificador);}
    
    elseif(!isset($_COOKIE['ERRORS'])) 
    { setcookie('ERRORS', 1,0,'/', '', false, true);}
    
    else
    {   $VAL = $_COOKIE['ERRORS'] + 1;
        setcookie('ERRORS',$VAL,0,'/', '', false, true);  
    }
}


function BLOCKUSER($COOKIE) : void
{
   global $IP;
   global $CONDB;

   $MYSQL = "CALL BLOQUEAR_USER(?,?)";
   $EJECUTAR = $CONDB->prepare($MYSQL);
   $EJECUTAR->bindParam(1, $COOKIE);
   $EJECUTAR->bindParam(2, $IP);
   $EJECUTAR->execute();
   setcookie('ERRORS','',time() - 3600,'/', '', false, true);
}



function VALIDARBLOCK() : string
{
    global $IP;
    global $identificador;
    global $CONDB;
 
    $MYSQL = "CALL VALIDAR_USER(?,?)";
    $EJECUTAR = $CONDB->prepare($MYSQL);
    $EJECUTAR->bindParam(1, $identificador);
    $EJECUTAR->bindParam(2, $IP);
    $EJECUTAR->execute();

    $EJECUTAR1 = $EJECUTAR->fetch();

    return $EJECUTAR1['MENSAJE'] ?? 'false';
}


function AUDITORIA(string $ID, string $MOVIMIENTO) : void
{ 
    global $CONDB;
    
    $query = "CALL SP_MOVIMIENTOS(?,?)";
    $res = $CONDB->prepare($query);
    $res->bindParam(1,$ID,PDO::PARAM_INT);
    $res->bindParam(2,$MOVIMIENTO);
    $res->execute();
}


function GetInfo($COLUMNA)
{
    if (isset($_COOKIE['IDENTITY'])) 
    {
        global $CONDB;

        try {
            // Cargar clave de cifrado desde variable de entorno
            $encryption_key = base64_decode($_ENV['ENCRYPTION_KEY']);

            $cookie_parts = explode('::', base64_decode($_COOKIE['IDENTITY']));
            if (count($cookie_parts) !== 2) { SUMBLOCKUSER(); return null; }

            // Desencriptar la identidad
            $encrypted_identity = $cookie_parts[0];
            $iv = base64_decode($cookie_parts[1]);

            if ($encrypted_identity === false || $iv === false || strlen($iv) !== 16) { SUMBLOCKUSER(); return null; }
            
            $identity = openssl_decrypt($encrypted_identity, 'AES-256-CBC', $encryption_key, 0, $iv);
            
            if ($identity === false) { SUMBLOCKUSER(); return null; }

            // Preparar y ejecutar la consulta
            $query = "SELECT $COLUMNA FROM USUARIOS WHERE TOKEN = ?";
            $RES = $CONDB->prepare($query);
            $RES->bindParam(1, $identity);
            $RES->execute();
            $RES1 = $RES->fetch();
            
            $RES2 = $RES1 == false ? 0 : reset($RES1);
            return $RES2;

        } catch (Exception $e) { error_log($e->getMessage()); SUMBLOCKUSER(); return null; }
    }
    else { SUMBLOCKUSER(); return null; }
}