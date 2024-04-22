<?php 

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_GET['tabla'])) {

require './Conexion.php';

$conexion = New ConexionDB();
$Ejec = $conexion->obtenerConexion();

switch ($_GET['tabla']) 
{
case 'usrs':
$Query = 'SELECT * FROM ALL_USER';
break;

case 'clts':
$Query = 'SELECT * FROM ALL_CLTS';
break;

case 'adms':
$Query = 'SELECT * FROM ADM';
break;

case 'usrblocks':
$Query = 'SELECT * FROM ALL_USRBLOCK';
break;

case 'auditoria':
$Query = 'SELECT * FROM VW_AUDITORIA';
break;

case 'notif':
$Query = 'CALL SP_VER_NOTIFICACIONES()';
break;


}

$STR = $Ejec->prepare($Query);
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
<?php }

else { header("LOCATION: ./404"); }