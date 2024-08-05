<?php require './Controllers/Conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
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
<link rel="stylesheet" href="<?php echo APP_URL ?>Styles/styles.css" type="text/css">
<!--- Fin Links -------------->

<?php

require './Controllers/ControllersBlocks.php';

if (!is_null(GetInfo('IDUsuario')) && !isset($_SESSION['LOG']) && !isset($_COOKIE['PASS']) && !isset($_GET['hcerrar']) && !isset($_GET['hcerrar1'])) 
{Header("Location:".APP_URL."Views/");}

elseif (VALIDARBLOCK() !== 'T') { die(file_get_contents(APP_URL.'Error/index.php?Error=001')); }

?>
<!--- Scripts -------------->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="<?php echo APP_URL ?>Scripts/globalfuncs.js" type="text/javascript"></script>
<script src="<?php echo APP_URL ?>Scripts/login.js" type="text/javascript"></script>
<!--- Fin scripts -------------->
</head>

<body>

<div id="carga" class="hide" style="z-index: 99999;">
 <div class="spin"></div>
</div>

<div id="formWrapper" class="shadow-lg">
 <form id="form">
 
 <div class="logo">
  <img src="<?php echo APP_URL ?>Data/logo.png" id="im"  width="60%" height="60%" hei alt="<?php echo APP_NAME ?>">
 </div>

 <div class="form-item fi1">
  <label for="email" class="formLabel">Usuario</label>
  <input type="email" name="email" id="email" class="form-style" maxlength="50" autocomplete="email" readonly>
 </div>
		
 <div class="form-item">
  <label for="password" class="formLabel">Contraseña</label>
  <input type="password" name="password" id="password" class="form-style" autocomplete="password" readonly>
 </div>

 <div class="form-check">
    <input class="form-check-input" type="checkbox" id="gridCheck2" style="margin-left: 0%;" onclick="visor(document.getElementById('password'))" >
      <label class="form-check-label cp" style="position: absolute;   margin-top: 3px;" for="gridCheck2">
        Mostrar contraseña
      </label>
  </div>

 
 <div class="form-item">
  <input type="submit" class="login pull-right" value="Iniciar Sesión" onclick="InicioSesion(event,document.getElementById('email').value,document.getElementById('password').value)">    
 </div> 

 </form>
</div>

<div class="modal" id="modalpass">
 <form id="form1" class="mdfpass">

  <p class="txtheading">La organización solicita cambiar la contraseña</p>
  
  <div class="form-item fi1">
   <p class="formLabel">Nueva contraseña</p>
   <input type="password" name="npass" id="npass" class="form-style" maxlength="15" autocomplete="new-password" readonly>
  </div>
		
  <div class="form-item">
   <p class="formLabel">Confirmar contraseña</p>
   <input type="password" name="cpass" id="cpass" class="form-style" maxlength="15" autocomplete="new-password" readonly>        
  </div>

  <div class="form-check">
    <input class="form-check-input" type="checkbox" id="gridCheck" style="margin-left: 0%;" onclick="visor(document.getElementById('cpass'))" >
      <label class="form-check-label cp" style="position: absolute;   margin-top: 3px;" for="gridCheck">
        Mostrar contraseña
      </label>
  </div>

  <div class="form-item">
   <input type="submit" class="login pull-right" value="Confirmar cambio" onclick="MdfPass(event,document.getElementById('npass').value,document.getElementById('cpass').value)">    
  </div>  

 </form>
</div>
</body>
</html>
<?php

if (isset($_GET['hcerrar']) || isset($_GET['hcerrar1']) ) 
{
CerrarSesion();

echo "<script type='text/javascript'>";

if (isset($_GET['hcerrar'])) { echo "Alerta('Sesión cerrada correctamente','success',1200);"; }

echo "LimpiarParametros(); </script>";
}





