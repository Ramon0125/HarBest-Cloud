<?php require './Controllers/Conexion.php'; ?>
<!DOCTYPE html>
<head>
<title><?php echo APP_NAME ?></title>

<!--- Meta -------------->
<meta name="robots" content="index, follow">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="keywords" content="<?php echo APP_NAME ?>, Contable,APP CONTABLE">
<meta name="description" content="<?php echo APP_NAME ?> es una app web creada para automatizar servicios contables y procesos financieros, permitiendo gestionar las finanzas de manera efectiva.">
<meta name="author" content="RAMON E. LEBRON">
<!--- Fin Meta -------------->

<!--- Links -------------->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo APP_URL ?>Data/favicon.ico"/>
<link rel="icon" href="<?php echo APP_URL?>Data/favicon.ico" type="image/x-icon"/>
<?php
if (isset($_GET['hcerrar']) || isset($_GET['hcerrar1']) ) 
{
CerrarSesion();
echo isset($_GET['hcerrar']) ? "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function () {res('Sesión cerrada correctamente','success',1200);});</script>" : "";
}

require './Controllers/ControllersBlocks.php';

if (!is_null(USERDATA::GetInfo('ID_USUARIO')) && !isset($_GET['hcerrar']) && !isset($_SESSION['LOG'])) 
{Header("Location:".APP_URL."Views/");}

if (VALIDARBLOCK() === 'T') { ?>
<link rel="stylesheet" href="<?php echo APP_URL ?>Styles/styles.css" type="text/css">
<!--- Fin Links -------------->


<!--- Scripts -------------->
<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript"></script>
<script defer src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script defer src="<?php echo APP_URL ?>Scripts/globalfuncs.js" type="text/javascript"></script>
<script defer src="<?php echo APP_URL ?>Scripts/login.js" type="text/javascript"></script>
<!--- Fin scripts -------------->
</head>

<body>

<div id="carga" class="hide" style="z-index: 99999;">
<div class="spin"></div>
</div>

<div id="formWrapper" class="shadow-lg">
 <form id="form">
 
 <div class="logo">
  <img src="<?php echo APP_URL ?>Data/logo.ico" id="im">
 </div>

 <div class="form-item fi1">
  <p class="formLabel">Usuario</p>
  <input type="email" name="email" id="email" class="form-style" maxlength="50" autocomplete="email" readonly>
 </div>
		
 <div class="form-item">
  <p class="formLabel">Contraseña</p>
  <input type="password" name="password" id="password" class="form-style" maxlength="15" autocomplete="current-password" readonly>        
  <input type="checkbox" name="mc" id="mc" onclick="visor(document.getElementById('password'))">
  <label for="mc" class="rup-pass">Mostrar Contraseña</label>
 </div>

 <div class="form-item">
  <input type="button" class="login pull-right" value="Iniciar Sesion" onclick="InicioSesion(document.getElementById('email').value,document.getElementById('password').value)">    
 </div> 

 </form>
</div>

<div class="modal" id="modalpass">
 <form id="form1" class="mdfpass">

  <p class="txtheading">La organizacion solicita cambiar la contraseña</p>
  
  <div class="form-item fi1">
   <p class="formLabel">Nueva contraseña</p>
   <input type="password" name="npass" id="npass" class="form-style" maxlength="15" autocomplete="new-password" readonly>
  </div>
		
  <div class="form-item">
   <p class="formLabel">Confirmar contraseña</p>
   <input type="password" name="cpass" id="cpass" class="form-style" maxlength="15" autocomplete="new-password" readonly>        
   <input type="checkbox" class="mc" name="mc1" id="mc1" onclick="visor(document.getElementById('cpass'))">
   <label for="mc1" class="rup-pass">Mostrar Contraseña</label>
  </div>

  <div class="form-item">
   <input type="button" class="login pull-right" value="Confirmar cambio" onclick="MdfPass(document.getElementById('npass').value,document.getElementById('cpass').value)">    
  </div>  

 </form>
</div>
</body>
</html>
<?php }

else 
{
$url = APP_URL.'Error/index.php?Error=001';
$html = file_get_contents($url);
echo $html;
} 