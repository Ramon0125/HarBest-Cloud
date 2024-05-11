<?php

if (strpos($_SERVER['REQUEST_URI'], 'Madms.php') === false) { ?>

<!-----------------MODAL AGREGAR ADMINISTRACION--------------------->
<div class="modal modaladmin fade" id="agradm" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar una administracion</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>

<div class="container"><div class="row g-3">
<form id="formagradm">

<div class="col-lg-12">
<label for="nadm" class="form-label">Escriba el nombre</label>  
<input class="form-control" autocomplete="off" id="nadm" name="nadm" placeholder="">
</div>

<br>

<div class="col-lg-12">
<label for="dadm" class="form-label">Escriba la dirección</label>  
<input class="form-control" autocomplete="off" id="dadm" name="dadm" placeholder="">
</div>

</form></div></div>


</div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green;" onclick="agradm(document.getElementById('nadm').value,document.getElementById('dadm').value)">Agregar</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#nadm','#dadm'])">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL AGREGAR ADMINISTRACION------------------->



<!-----------------MODAL EDITAR ADMINISTRACION--------------------->
<div class="modal modaladmin fade" id="edtadm" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Editar una administracion</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;"></div>

<div class="container"><div class="row g-3">

<div class="col-fluid col-lg-12">
<form id="formedtadm">
<label for="admedt" class="form-label labeledtmdf">Administracion</label>  
<input class="form-control" autocomplete="off" role="combobox" list="" id="admedt" name="admedt">
<input type="hidden" id="admedt1" name="admedt1">

<datalist id="Datalistagradm" role="listbox">
<?php $agradms = ADM(); // Obtener usuarios

if ($agradms !== false && count($agradms) > 0) {
foreach ($agradms as $agradms1): ?>
<option value="<?php echo $agradms1["ID_ADM"]; ?>"><?php echo $agradms1["NOMBRE_ADM"]; ?></option>
<?php endforeach; }?>
</datalist>

</form></div>
<div class="container" style="display: none;" id="formedtadm1">
<form id="formedtclt11">
<br>
<div class="row g-3" >

<div class="col-fluid col-lg-12">
<label for="admedtname" class="form-label">Nuevo nombre</label>
<input type="text" class="form-control" id="admedtname" name="admedtname" autocomplete="off" maxlength="50">
</div>

<div class="col-fluid col-lg-12">
<label for="admedtdirecc" class="form-label">Nueva direccion</label>
<input type="text" class="form-control" id="admedtdirecc" name="admedtdirecc" autocomplete="off" maxlength="100">
</div>

</div></form></div>

</div></div>
</div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btnedtadm" class="btn btn-success" style="background-color:green; display:none" onclick="edtadm(document.getElementById('admedt1').value, document.getElementById('admedt').value, document.getElementById('admedtname').value, document.getElementById('admedtdirecc').value)">Editar administracion</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#admedt1',['#formedtadm1','#Datalistagradm'],['#formedtclt11','#formedtadm'])">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL EDITAR CLIENTES------------------->


<?php  } 

else {header('LOCATION: ./404');}