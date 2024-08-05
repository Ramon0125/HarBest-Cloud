<?php

require './Controllers/Conexion.php';
require './Controllers/ControllersBlocks.php';


    if (isset($_COOKIE['IDENTITY'])) 
    {
        global $CONDB;

        try {
        // Cargar clave de cifrado desde variable de entorno
        $encryption_key = base64_decode($_ENV['ENCRYPTION_KEY']);

        $cookie_parts = explode('::', $_COOKIE['IDENTITY']);
        if (count($cookie_parts) !== 2) { SUMBLOCKUSER(); return null; }

        // Desencriptar la identidad
        $encrypted_identity = base64_decode($cookie_parts[0]);
        $iv = base64_decode($cookie_parts[1]);

        if ($encrypted_identity === false || $iv === false) { SUMBLOCKUSER(); return null; }
        
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

        } catch (Exception $e) { error_log($e->getMessage()); SUMBLOCKUSER(); return null;}
    }
    else { SUMBLOCKUSER(); return null;}
