<?php

if (strpos($_SERVER['REQUEST_URI'], 'Madm.php') === false) { ?>

<!-----------------MODAL AGREGAR ADMINISTRACION--------------------->
<div class="modal modaladmin fade" id="agradm" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">

<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar una administracion</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>

<div class="container"><div class="row g-3">
<div class="col-fluid col-lg-12">
<form id="formagradm">
<label for="nadm" class="form-label">Escriba el nombre</label>  
<input class="form-control" autocomplete="off" id="nadm" name="nadm" placeholder="">
</form></div></div></div></div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green;" onclick="agradm(document.getElementById('nadm').value)">Agregar</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#nadm')">Cancelar</button>
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
<label for="admedt" class="form-label">Administracion</label>  
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
<label for="rncedtclt" class="form-label">Nuevo nombre</label>
<input type="text" class="form-control" id="admedtname" name="admedtname" autocomplete="off" maxlength="11">
</div>

</div></form></div>

</div></div>
</div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btnedtadm" class="btn btn-success" style="background-color:green; display:none" onclick="edtadm(document.getElementById('admedt1').value, document.getElementById('admedt').value, document.getElementById('admedtname').value)">Editar administracion</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#admedt1',['#formedtadm1','#Datalistagradm'],['#formedtclt11','#formedtadm'])">Cancelar</button>
</div></div></div></div>
<!---------------FIN MODAL EDITAR CLIENTES------------------->


<?php  } 

else {header('LOCATION: ./404');}