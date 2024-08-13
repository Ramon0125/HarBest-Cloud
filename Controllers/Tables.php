<?php 

// Verificar si la solicitud no es AJAX y si accede a Tables.php
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !preg_match('/Tables(?:\.php)?/', $_SERVER['REQUEST_URI']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(404);
    die(header('Location: ./404'));
}

// Incluir archivos necesarios
require './Conexion.php';
require './ControllersBlocks.php';
require './Functions.php';

// Verificar si la tabla está establecida, la cadena es válida y el usuario está autenticado
if (isset($_GET['tabla']) && Validarcadena1($_GET['tabla']) && GetInfo('IDUsuario') != 0) {

    $conexion = new ConexionDB();
    $Ejec = $conexion->obtenerConexion();

    // Asignar tabla según los privilegios del usuario
    $tabla = (GetInfo('PRIVILEGIOS') === 'CASOS FISCALES') 
        ? ['casos' => 'VW_CASOS'] 
        : [
            'usrs' => 'ALL_USER',
            'clts' => 'ALL_CLTS',
            'adms' => 'VW_ADM',
            'usrblocks' => 'ALL_USRBLOCK',
            'auditoria' => 'VW_AUDITORIA',
        ];

    // Preparar y ejecutar la consulta
    if (isset($tabla[$_GET['tabla']])) {
        $STR = $Ejec->prepare('SELECT * FROM ' . $tabla[$_GET['tabla']]);
        $STR->execute();

        // Inicializar array de datos
        $DATOS = array();

        // Generar la cabecera de la tabla si hay resultados
        if ($STR->rowCount() > 0) 
        {
            $DATOS = $STR->fetchAll();
            
            echo "<thead><tr>";

            foreach ($DATOS[0] as $column_name => $value) 
            { echo "<th scope='col'>" . strtoupper($column_name) . "</th>"; }

            echo "</tr></thead>";
        }

        // Generar el cuerpo de la tabla
        echo "<tbody>";
        foreach ($DATOS as $REG) {
            echo "<tr>";
            foreach ($REG as $column_value) {
                $VAL = json_decode($column_value, true);
                echo "<td>" . (is_array($VAL) ? ArrayFormat($VAL) : htmlspecialchars($column_value)) . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
    } else {
        echo json_encode(HandleError());
    }
} else {
    header('Content-Type: application/json');  
    echo json_encode(HandleError());
}
