<?php 

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
require './Functions.php';

if(isset($_GET['tabla']) && Validarcadena1($_GET['tabla'])){

require './Conexion.php';

$conexion = New ConexionDB();
$Ejec = $conexion->obtenerConexion();

$tabla = array(
'usrs' => 'ALL_USER',
'clts' => 'ALL_CLTS',
'adms' => 'ADM',
'usrblocks' => 'ALL_USRBLOCK',
'auditoria' => 'VW_AUDITORIA',
'notif' => 'VW_VER_NOTIFICACIONES',
'email_notif' => 'READ_EMAIL_NOTIF',
'detalles' => 'VW_VER_DDC',
'email_ddc' => 'READ_EMAIL_DDC'
);

$STR = $Ejec->prepare('SELECT * FROM '.$tabla[$_GET['tabla']]);
$STR->execute();
$DATOS = array();
?>

<thead>
<tr> <?php if ($STR->rowCount() > 0) 
{ $DATOS = $STR->fetchAll(PDO::FETCH_ASSOC);
foreach($DATOS[0] as $column_name => $value) { ?><th scope="col"><?php echo $column_name."</th>"; }
} ?></tr>
</thead>
<tbody><?php if($DATOS){foreach ($DATOS as $REG) { ?>
<tr><?php foreach ($REG as $column_value) 
{ ?><td><?php echo $column_value."</td>"; } ?></tr><?php }} ?>                         
</tbody>
<?php 
}
else {
header('Content-Type: application/json');  
echo json_encode(array('error' => true));}
}

else { header("LOCATION: ./404"); }