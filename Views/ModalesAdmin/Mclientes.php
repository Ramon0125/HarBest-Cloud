<?php

if (strpos($_SERVER['REQUEST_URI'], 'Mclientes.php') === false) { ?>
<!-----------------MODAL AGREGAR CLIENTES--------------------->
<div class="modal modaladmin fade" id="agrclt" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar un nuevo cliente</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<form id="formagrclt">
<div class="container">
<div class="row g-3">

<div class="col-sm-6">
<label for="rncagrclt" class="form-label">RNC</label>
<input type="text" class="form-control" id="rncagrclt" name="rncagrclt" autocomplete="off" maxlength="11">
</div>

<div class="col-sm-6">
<label for="emailagrclt" class="form-label">Email</label>
<input type="email" class="form-control" id="emailagrclt" name="emailagrclt" autocomplete="off" maxlength="50">
</div>
 
<div class="col-sm-6">
<label for="nameagrclt" class="form-label">Nombres</label>
<input type="text" class="form-control" id="nameagrclt" name="nameagrclt" autocomplete="off" maxlength="50">
</div>

<div class="col-sm-6">
<label for="admclt" class="form-label">Administracion</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="admclt" name="admclt">
<input type="hidden" id="admclt1" name="admclt1">

<datalist id="browseradmclt" role="listbox">
<?php $adms = Datos(3); // Obtener usuarios

if ($adms !== false && count($adms) > 0) {
foreach ($adms as $adm): ?>
<option value="<?php echo $adm["IDADM"]; ?>"><?php echo $adm["NombreADM"]; ?></option>
<?php endforeach; }?>
</datalist>
</div>

</div>
</div></form></div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green" onclick="agrclt(document.getElementById('rncagrclt').value, document.getElementById('emailagrclt').value, document.getElementById('nameagrclt').value, document.getElementById('admclt1').value)">Agregar Cliente</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#admclt1',false,'#formagrclt')">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL AGREGAR CLIENTES------------------->


<!-----------------MODAL EDITAR CLIENTES--------------------->
<div class="modal modaladmin fade" id="edtclt" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Editar un cliente</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">
<div class="row g-3">

<div class="col-fluid col-lg-12">
<form id="formedtclt">
<label for="slcclt" class="form-label labeledtmdf">Buscar el Cliente</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="slcclt" name="slcclt" placeholder="">
<input type="hidden" id="slcclt1" name="slcclt1">


<datalist id="browseredtclt" role="listbox">
<?php $cliente = Datos(2); // Obtener clientes

if ($cliente !== false && count($cliente) > 0) {
foreach ($cliente as $clientes){ ?>
<option value="<?php echo $clientes["IDCliente"]; ?>"><?php echo $clientes["NombreCliente"]; ?></option>
<?php }} ?>
</datalist></form></div>
</div>
</div>
<div class="container" style="display: none;" id="formedtclt1">
<form id="formedtclt11">
<br>
<div class="row g-3" >

<div class="col-sm-6">
<label for="rncedtclt" class="form-label">RNC</label>
<input type="text" class="form-control" id="rncedtclt" name="rncedtclt" autocomplete="off" maxlength="11">
</div>

  <div class="col-sm-6">
  <label for="edtcltemail" class="form-label">Email</label>
  <input type="text" class="form-control" id="edtcltemail" name="edtcltemail" autocomplete="off" maxlength="50">
  </div>
       
  <div class="col-sm-6">
  <label for="edtcltname" class="form-label">Nombres</label>
  <input type="text" class="form-control" id="edtcltname" name="edtcltname" autocomplete="off" maxlength="20">
  </div>

<div class="col-sm-6">
<label for="admedtclt" class="form-label">Administracion</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="admedtclt" name="admedtclt">
<input type="hidden" id="admedtclt1" name="admedtclt1">

<datalist id="browseradmedtclt" role="listbox">
<?php $adms1 = Datos(3); // Obtener usuarios

if ($adms1 !== false && count($adms1) > 0) {
foreach ($adms1 as $adm1): ?>
<option value="<?php echo $adm1["IDADM"]; ?>"><?php echo $adm1["NombreADM"]; ?></option>
<?php endforeach; }?>
</datalist>
</div>


</div></form></div></div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btnedtclt" class="btn btn-success" style="background-color:green; display:none" onclick="edtclt(document.getElementById('slcclt1').value, document.getElementById('slcclt').value, document.getElementById('rncedtclt').value, document.getElementById('edtcltemail').value, document.getElementById('edtcltname').value, document.getElementById('admedtclt1').value)">Editar Cliente</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#slcclt1','#admedtclt1'],['#browseredtclt','#formedtclt1','#btnedtclt'],['#formedtclt','#formedtclt11'])">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL EDITAR CLIENTES------------------->

<!-----------------MODAL ELIMINAR CLIENTES--------------------->
<div class="modal modaladmin1 fade" id="dltclt" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar un cliente</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div><div class="container"><div class="row g-3">

<div class="col-fluid col-lg-12">
<form id="formdltclt">
<label for="slcdltclt" class="form-label labeledtmdf">Buscar el Cliente</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltclt" name="slcdltclt" placeholder="">
<input type="hidden" id="slcdltclt1" name="slcdltclt1">

<datalist id="browserdltclt" role="listbox">
<?php $cliente1 = Datos(2); // Obtener clientes

if ($cliente1 !== false && count($cliente1) > 0) {
foreach ($cliente1 as $clientes1){ ?>
<option value="<?php echo $clientes1["IDCliente"]; ?>"><?php echo $clientes1["NombreCliente"]; ?></option>
<?php }} ?>
</datalist></form></div>
</div>
</div>
</div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btndltclt" class="btn btn-success" style="background-color:green; display:none" onclick="dltclt(document.getElementById('slcdltclt1').value,document.getElementById('slcdltclt').value)">Eliminar Cliente</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltclt1',['#browserdltclt','#btndltclt'],'#formdltclt')">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL ELIMINAR IENTES------------------->
<?php  } 

else {header('LOCATION: ./404');}