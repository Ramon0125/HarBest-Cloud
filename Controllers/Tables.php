<?php 

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
require './Functions.php';
require './Conexion.php';
require './ControllersBlocks.php';

if(isset($_GET['tabla']) && Validarcadena1($_GET['tabla']) && GetInfo('IDUsuario') != 0){

$conexion = New ConexionDB();
$Ejec = $conexion->obtenerConexion();

$tabla = GetInfo('PRIVILEGIOS') === 'CASOS FISCALES' ? 

array(
'notif' => 'VW_VER_NOTIFICACIONES',
'detalles' => 'VW_VER_DDC'
) 
 : 
array(
'usrs' => 'ALL_USER',
'clts' => 'ALL_CLTS',
'adms' => 'VW_ADM',
'usrblocks' => 'ALL_USRBLOCK',
'auditoria' => 'VW_AUDITORIA',
);

$STR = $Ejec->prepare('SELECT * FROM '.$tabla[$_GET['tabla']]);
$STR->execute();
$DATOS = array();
?>

<thead>
<tr> 
<?php if ($STR->rowCount() > 0) 
{ 
 $DATOS = $STR->fetchAll(PDO::FETCH_ASSOC);
 foreach($DATOS[0] as $column_name => $value) 
 { ?><?php echo "<th scope='col'>".strtoupper($column_name)."</th>"; }
} ?>
</tr>
</thead>

<tbody>
<?php if($DATOS){foreach ($DATOS as $REG) { ?>
<tr>
<?php foreach ($REG as $column_value) { echo "<td>".$column_value."</td>"; } ?>
</tr>
<?php }} ?> 
</tbody>
<?php }
else {
header('Content-Type: application/json');  
echo json_encode(HandleError());
}

}
else { header("LOCATION: ./404"); }