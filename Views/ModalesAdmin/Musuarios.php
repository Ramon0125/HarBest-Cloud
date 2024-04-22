<?php

if (strpos($_SERVER['REQUEST_URI'], 'Musuarios.php') === false) { ?>
<!-----------------MODAL AGREGAR USUARIOS--------------------->
<div class="modal modaladmin fade" id="agrusr" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar un nuevo usuario</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<form id="formagrusr">
<div class="container">
<div class="row g-3">

  <div class="col-sm-6">
  <label for="privusr" class="form-label">Privilegios</label>  
  <select id="privusr" name="privusr" class="form-select" style="width: 100%;">
  <option selected value="EJECUTIVO">Ejecutivo</option>
  </select>
  </div>
  
  <div class="col-sm-6">
  <label for="usremail" class="form-label">Email</label>
  <input type="email" class="form-control" id="usremail" name="usremail" autocomplete="off" maxlength="50">
  </div>

  <div class="col-sm-6">
  <label for="usrname" class="form-label">Nombres</label>
  <input type="text" class="form-control" id="usrname" name="usrname" autocomplete="off" maxlength="20">
  </div>

  <div class="col-sm-6">
  <label for="usrlastname" class="form-label">Apellidos</label>
  <input type="text" class="form-control" id="usrlastname" name="usrlastname" autocomplete="off" maxlength="20">
  </div>

</div>
</div></form></div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green" onclick="agrusr(document.getElementById('usremail').value, document.getElementById('usrname').value, document.getElementById('usrlastname').value)">Agregar Usuario</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(false,false,'#formagrusr')">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL AGREGAR USUARIOS------------------->



<!-----------------MODAL EDITAR USUARIOS--------------------->
<div class="modal modaladmin fade" id="edtusr" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Editar un usuario</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">
<div class="row g-3">

<div class="col-fluid col-lg-12">
<form id="formedtusr">
<label for="slcuser" class="form-label">Buscar el Usuario</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="slcuser" name="slcuser" placeholder="">
<input type="hidden" id="slcuser1" name="slcuser1">


<datalist id="browser1" role="listbox">
<?php $usuarios = Users(); // Obtener usuarios

if ($usuarios !== false && count($usuarios) > 0) {
foreach ($usuarios as $user){ ?>
<option value="<?php echo $user["ID_USUARIO"]; ?>"><?php echo $user["NOMBRE"]; ?></option>
<?php }} ?>
</datalist></form></div>
</div>
</div>
<div class="container" style="display: none;" id="formedt">
<form id="formedt1">
<br>
<div class="row g-3" >

  <div class="col-sm-6">
  <label for="edtusremail" class="form-label">Email</label>
  <input type="text" class="form-control" id="edtusremail" name="edtusremail" autocomplete="off" maxlength="50">
  </div>
       
  <div class="col-sm-6">
  <label for="edtusrname" class="form-label">Nombres</label>
  <input type="text" class="form-control" id="edtusrname" name="edtusrname" autocomplete="off" maxlength="20">
  </div>

  <div class="col-sm-6">
  <label for="edtusrlastname" class="form-label">Apellidos</label>
  <input type="text" class="form-control" id="edtusrlastname" name="edtusrlastname" autocomplete="off" maxlength="20">
  </div>

  <div class="col-sm-6">
  <label for="edtpassword" class="form-label">Contraseña</label>
  <input type="text" class="form-control" id="edtpassword" name="edtpassword" autocomplete="off" maxlength="15">
  </div>

</div></form></div></div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btnedtusr" class="btn btn-success" style="background-color:green; display:none" onclick="edtusr(document.getElementById('slcuser1').value, document.getElementById('slcuser').value, document.getElementById('edtusremail').value, document.getElementById('edtusrname').value, document.getElementById('edtusrlastname').value, document.getElementById('edtpassword').value)">Editar Usuario</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcuser1',['#browser1','#formedt','#btnedtusr'],['#formedtusr','#formedt1'])" >Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL EDITAR USUARIOS------------------->



<!-----------------MODAL ELIMINAR USUARIOS--------------------->
<div class="modal modaladmin1 fade" id="dltusr" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar un usuario</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div><div class="container"><div class="row g-3">

<div class="col-fluid col-lg-12">
<form id="formdltusr">
<label for="slcdltuser" class="form-label">Buscar el Usuario</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltuser" name="slcdltuser" placeholder="">
<input type="hidden" id="slcdltuser1" name="slcdltuser1">

<datalist id="browserdltusr" role="listbox">
<?php $usuarios1 = Users(); // Obtener usuarios

if ($usuarios1 !== false && count($usuarios1) > 0) {
foreach ($usuarios1 as $user1): ?>
<option value="<?php echo $user1["ID_USUARIO"]; ?>"><?php echo $user1["NOMBRE"]; ?></option>
<?php endforeach; }?>
</datalist></form></div>
</div>
</div>
</div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btndltusr" class="btn btn-success" style="background-color:green; display:none" onclick="dltusr(document.getElementById('slcdltuser1').value,document.getElementById('slcdltuser').value)">Eliminar Usuario</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltuser1',['#browserdltusr','#btndltusr'],'#formdltusr')">Cancelar</button>
</div></div></div></div><Header></Header>
<!---------------FIN MODAL ELIMINAR USUARIOS------------------->
<?php  } 

else {header('LOCATION: ./404');}