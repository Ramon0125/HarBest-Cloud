<?php require '../Settings/app.php'?>
<!DOCTYPE html><html lang="en">
<head>
<link rel="icon" id="favicon" href="<?php echo APP_URL?>Data/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo APP_URL ?>Styles/error.css">
<title>

<?php

if (isset($_GET['Error']))
{	
switch ($_GET['Error']) 
{
case '001': echo 'Usuario Bloqueado'; break;
case '002': echo 'Error en el sistema'; break;
default: echo 'Pagina No Encontrada'; break;
}
}

else 
{ echo 'Pagina No Encontrada'; }
?>
</title>
</head>

<body>
<div class="container">
<div class="error">
<h1>
<?php 
if (isset($_GET['Error'])){			
switch ($_GET['Error']) 
{
	case '001': echo '001</h1>';
	echo '<h2>Usuario bloqueado</h2>'; 
	echo '<p>hemos detectado actividades inusuales asociadas con tu cuenta. Como medida de seguridad, hemos bloqueado temporalmente
	el acceso a tu cuenta. <br><br> Agradecemos tu comprensión y colaboración en este asunto. Estamos aquí para ayudarte y estamos comprometidos a garantizar la seguridad
	y la integridad de tu cuenta y de nuestra plataforma.</p>';
	break;

    case '002': echo '002</h1>';
    echo '<h2>Hay un problema en nuestro sistema.</h2>';
    echo '<p>Nuestros ingenieros estelares están trabajando arduamente para resolver este problema intergaláctico. Por favor, inténtalo de nuevo más tarde.';
    echo ' <a href="'.APP_URL.'?hcerrar1">Volver a inicio</a></p>';
    break;

    default: echo '404</h1>';
    echo '<h2>¡Oops! Parece que te has perdido en el ciberespacio.</h2>';
	echo '<p>La página que estás buscando no se encuentra en nuestra galaxia digital.
    Puede que se haya desplazado a una dimensión desconocida o simplemente haya sido absorbida por un agujero negro digital. 
    <a href="'.APP_URL.'">Volver a inicio</a></p>';
    break;	
}}

else 
{
    echo '404</h1>';
    echo '<h2>¡Oops! Parece que te has perdido en el ciberespacio.</h2>';
	echo '<p>La página que estás buscando no se encuentra en nuestra galaxia digital.
    Puede que se haya desplazado a una dimensión desconocida o simplemente haya sido absorbida por un agujero negro digital. 
    <a href="'.APP_URL.'">Volver a inicio</a></p>';
}

?>
</div></div>
</body>
</html>