<?php require '../Controllers/Conexion.php'; ?>
<!doctype html><html lang="en" data-bs-theme="auto">
<head>
<title><?php echo APP_NAME ?></title>
<meta name="robots" content="index, follow">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="keywords" content="<?php echo APP_NAME ?>, Contable,APP CONTABLE">
<meta name="description" content="<?php echo APP_NAME ?> es una app web creada para automatizar servicios contables y procesos financieros, permitiendo gestionar las finanzas de manera efectiva.">
<meta name="author" content="RAMON E. LEBRON">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo APP_URL ?>Data/favicon.ico"/>
<link rel="icon"  type="image/x-icon" href="<?php echo APP_URL?>Data/favicon.ico"/>
<?php 
require '../Controllers/datos.php';

require '../Controllers/ControllersBlocks.php';

if(is_null(USERDATA::GetInfo('ID_USUARIO')) || isset($_SESSION['LOG'])){ header("Location:".APP_URL);}

if (VALIDARBLOCK() === 'T') {

if(USERDATA::GetInfo('ID_USUARIO') > 0){
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?PHP echo APP_URL ?>Styles/style.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" rel="stylesheet" crossorigin="anonymous" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"  type="text/javascript" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js" type="text/javascript" crossorigin="anonymous"></script>

</head><body>


<div id="carga" class="loading">
<div class="spin"></div>
</div>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<!-- Logo -->
<div class="d-flex align-items-center justify-content-between">

 <a class="logo d-flex align-items-center">
 <img src="<?php echo APP_URL ?>Data/favicon.png" alt="Logo de <?php echo APP_NAME ?>">
 <span class="d-none d-lg-block"><?php echo APP_NAME ?></span>
 </a>
 
 <div class="header1 toggle-sidebar-btn">
  <input class="checkbox" type="checkbox" id="chk" checked/>
  <div class="hamburger-lines">
   <span class="line line1"></span>
   <span class="line line2"></span>
   <span class="line line3"></span>
  </div> 
 </div>

</div>
<!-- End Logo -->

<!-- Navigation -->
<nav class="header-nav ms-auto"><ul class="d-flex align-items-center">

<!--Profile Nav -->
<li class="nav-item dropdown pe-3">

<!--Profile Image Icon -->
<a class="nav-link nav-profile d-flex align-items-center pe-0 cpp cp" data-bs-toggle="dropdown">
 <i class="bi bi-person-circle rounded-circle"></i>
 <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo USERDATA::GetInfo('NOMBRES')." ".USERDATA::GetInfo('APELLIDOS'); ?></span>
</a><!-- End Profile Image Icon -->

<!-- Profile Dropdown Items -->
<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

<!-- Name and Role -->
<li class="dropdown-header logo">
 <h6><?php echo USERDATA::GetInfo('NOMBRES')." ".USERDATA::GetInfo('APELLIDOS') ?></h6>
 <span><?php echo USERDATA::GetInfo('PRIVILEGIOS') ?></span>
</li><!-- End Name and Role -->
 
<li><hr class="dropdown-divider"></li>

<!-- Actions -->
<li class="cna">
 <a class=" dropdown-item d-flex align-items-center disabled" aria-disabled="true" >
 <i class="bi bi-pencil-square"></i>
 <span>Cambiar contraseña</span>
 </a>
</li>

<li><hr class="dropdown-divider"></li>

<li>
 <a class="dropdown-item d-flex align-items-center" href="#">
 <i class="bi bi-question-circle"></i>
 <span>Need Help?</span>
 </a>
</li>

<li><hr class="dropdown-divider"></li>

<li class="dan cp" onclick="cerrar()">
 <a class="dropdown-item d-flex align-items-center dan" style="margin-bottom: 7px;">
 <i class="bi bi-box-arrow-right"></i>
 <span>Cerrar sesion</span>
 </a>
</li>
            
</ul><!-- End Profile Dropdown Items -->
        
</li><!-- End Profile Nav -->

</ul></nav><!-- End Navigation -->

</header><!-- End Header -->


<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

  <?php if(USERDATA::GetInfo('PRIVILEGIOS') === 'EJECUTIVO') { ?>

  <li class="nav-heading">Protocolos</li>

  <!-- Notificaciones de inconsistencia --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#notif" data-bs-toggle="collapse">
   <i class="bi bi-journal-text"></i>
   <span>Notif. de inconsistencias</span>
   <i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="notif" class="nav-content collapse" data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
   <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrnot">
   <i class="bi-plus-square"></i>Adicionar</a>
  </li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtnot">
  <i class="bi bi-pencil-square"></i>Modificar</a>
  </li>
  
  <li class="dropdown-item">
  <hr class="divioer">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltnot">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li>
  </ul></li><!-- End Notificaciones de inconsistencia -->

  
  <!-- Detalle de Citacion --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#detcit" data-bs-toggle="collapse" href="#">
  <i class="bi bi-journal-text"></i><span>Detalle de Citacion</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="detcit" class="nav-content collapse " data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrnot">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtnot">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>
  
  <li class="dropdown-item">
  <hr class="divioer">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltnot">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li>
  </ul></li><!-- End Detalle de Citacion -->



  <!--   Escrito de Descargo --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#addnotif" data-bs-toggle="collapse" href="#">
  <i class="bi bi-journal-text"></i><span>Escrito de Descargo</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="addnotif" class="nav-content collapse " data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrnot">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtnot">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>
  
  <li class="dropdown-item">
  <hr class="divioer">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltnot">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li>
  </ul></li><!--   Escrito de Descargo -->


  
  <!--   Resolución de Determinación --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#resdet" data-bs-toggle="collapse" href="#">
  <i class="bi bi-journal-text"></i><span>Res. de Determinación</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="resdet" class="nav-content collapse " data-bs-parent="#sidebar-nav">

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrnot">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtnot">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>
  
  <li class="dropdown-item">
  <hr class="divioer">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltnot">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li>
  </ul></li><!--- End Resolución de Determinación -->



    <!--    Recurso de Reconsideración. --><li class="nav-item">
    <a class="nav-link collapsed b1" data-bs-target="#resrec" data-bs-toggle="collapse" href="#">
  <i class="bi bi-journal-text"></i><span>Rec. de Reconsideración</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="resrec" class="nav-content collapse " data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrnot">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtnot">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>
  
  <li class="dropdown-item">
  <hr class="divioer">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltnot">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li>
  </ul></li><!--- End Resolución de Determinación -->



    <!--    Recurso Contencioso. --><li class="nav-item">
    <a class="nav-link collapsed dan dan1" data-bs-target="#reccon" data-bs-toggle="collapse" href="#">
  <i class="bi bi-journal-text "></i><span>Recurso Contencioso</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="reccon" class="nav-content collapse " data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrnot">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtnot">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>
  
  <li class="dropdown-item">
  <hr class="divioer">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltnot">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li>
  </ul></li><!--- End Resolución de Determinación -->

  <!-- Tablas -->

<?php } else { ?> 

<!-- End Tablas -->

    <li class="nav-heading">Tablas</li>
    
    <li class="nav-item">
    <a class="nav-link collapsed b1" onclick="tablas('usrs')">
    <i class="bi bi-person-lines-fill"></i>Tabla Usuarios</a></li>

    <li class="nav-item">
    <a class="nav-link collapsed b1" onclick="tablas('clts')">
    <i class="bi bi-person-vcard"></i>Tabla Clientes</a></li>

    <li class="nav-item">
    <a class="nav-link collapsed b1" onclick="tablas('adms')">
    <i class="bi bi-bag-fill"></i>Tabla Administracion</a></li>

    <li class="nav-item">
    <a class="nav-link collapsed b1" onclick="tablas('usrblocks')">
    <i class="bi bi-person-fill-slash"></i>Tabla Usuarios Bloqueados</a></li>

    <li class="nav-item">
    <a class="nav-link collapsed b1" onclick="tablas('auditoria')">
    <i class="bi bi-calendar3"></i>Tabla Auditoria</a></li>

<!-- End Tablas -->

  
  <li class="nav-heading">Procedimientos</li>

    <!--    USUARIOS. --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#users" data-bs-toggle="collapse">
  <i class="bi bi-person-lines-fill"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="users" class="nav-content collapse" data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrusr">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtusr">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>


  <li class="dropdown-item">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltusr">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li> <hr class="divioer">
  </ul></li><!--   END USUARIOS. -->


  <!--    CLIENTES. --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#clients" data-bs-toggle="collapse" href="#">
  <i class="bi bi-person-vcard"></i><span>Clientes</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="clients" class="nav-content collapse " data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agrclt">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtclt">
  <i class="bi bi-pencil-square"></i>Modificar</a></li>
  
  <li class="dropdown-item">
  <a class="dan nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#dltclt">
  <i class="dan bi bi-trash-fill"></i>Eliminar</a></li> <hr class="divioer">
  </ul></li><!--   END CLIENTES. -->


  <!--    ADMS. --><li class="nav-item">
  <a class="nav-link collapsed b1" data-bs-target="#adms" data-bs-toggle="collapse" href="#">
  <i class="bi bi-bag-fill"></i><span>Administracion</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="adms" class="nav-content collapse " data-bs-parent="#sidebar-nav">
  
  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#agradm">
  <i class="bi-plus-square"></i>Adicionar</a></li>

  <li class="dropdown-item">
  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#edtadm">
  <i class="bi bi-pencil-square"></i>Modificar</a></li> <hr class="divioer">
  </ul></li><!--   END ADMS. -->

 <?php } ?>
  </ul></aside><!-- End Sidebar-->

<!-----------------------------------------------------TABLA---------------------------------------------->
<main id="main" class="main">
<div class="card info-card sales-card" style=" overflow: auto;">
<table class="table table-hover" id="tabla" style="margin: 0; user-select:text; width:100%;"></table>
</div>
</main>
<!-----------------------------------------------------FIN TABLA---------------------------------------------->


<script defer src="<?php echo APP_URL ?>Scripts/globalfuncs.js" type="text/javascript"></script>
<script defer src="<?php echo APP_URL ?>Scripts/datalistsglobal.js" type="text/javascript"></script>

<?php if (USERDATA::GetInfo('PRIVILEGIOS') === 'ADMINISTRADOR') { ?> 
<script src="<?php echo APP_URL ?>Scripts/Admins/funcsadmins.js" type="text/javascript"></script>

<!---------------------MODALES------- ------------------->
<!-----------------------------------------------------MODAL USUARIOS---------------------------------------------->
<?php include_once './ModalesAdmin/Musuarios.php'; ?>
<!---------------------------------------------------FIN MODAL USUARIOS---------------------------------------------->

<!-----------------------------------------------------MODAL CLIENTES---------------------------------------------->
<?php include_once './ModalesAdmin/Mclientes.php'; ?>
<!---------------------------------------------------FIN MODAL CLIENTES---------------------------------------------->

<!-----------------------------------------------------MODAL ADMINISTRACION---------------------------------------------->
<?php include_once './ModalesAdmin/Madms.php'; ?>
<!---------------------------------------------------FIN MODAL ADMINISTRACION---------------------------------------------->
<!---------------------FIN MODALES------- ------------------->

<script defer src="<?php echo APP_URL ?>Scripts/Admins/datalistsadmin.js" type="text/javascript"></script> 
<script defer src="<?php echo APP_URL ?>Scripts/Admins/users.js" type="text/javascript"></script>
<script defer src="<?php echo APP_URL ?>Scripts/Admins/clientes.js" type="text/javascript"></script>
<script defer src="<?php echo APP_URL ?>Scripts/Admins/adms.js" type="text/javascript"></script> 
<?php } 

else {  ?>

<!---------------------MODALES------- ------------------->
<!-----------------------------------------------------MODAL NOTIF. INCONSIS---------------------------------------------->
<?php include_once './ModalesEjec/Magrnotif.php'; ?>
<!---------------------------------------------------FIN MODAL NOTIF. INCONSIS---------------------------------------------->
<!---------------------FIN MODALES------- ------------------->

<script defer src="<?php echo APP_URL ?>Scripts/Ejecutivos/funcsejecutivos.js" type="text/javascript"></script>
<script defer src="<?php echo APP_URL ?>Scripts/Ejecutivos/datalistsejec.js" type="text/javascript"></script> 
<script defer src="<?php echo APP_URL ?>Scripts/Ejecutivos/NotifInconsis.js" type="text/javascript"></script> 
<?php } ?> </body></html> <?php

if (isset($_GET['Notificacion']))
{echo "<script type='text/javascript'>window.onload = function() {
res('" . $_GET['Notificacion'] . "','success',1400)}</script>";
}}

else 
{ $url = APP_URL.'Error/index.php?Error=002';
  $html = file_get_contents($url);
  echo $html; 
} 

}

else 
{ $url = APP_URL.'Error/index.php?Error=001';
  $html = file_get_contents($url);
  echo $html; 
} 

