<?php 

if (strpos($_SERVER['REQUEST_URI'], 'Magrnotif.php') === false) { ?>
<!---- MODAL AGREGAR NOTIFICACION --------->
<div class="modal fade ifa" id="agrnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar una nueva notificación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<form id="formagrnotif" style="overflow-y: auto;">

  <div class="container">
  <div class="row g-3">
  
    <div class="col-sm-6">
    <label for="cltagrnot" class="form-label">Seleccione el cliente</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="cltagrnot" name="cltagrnot" placeholder="">
    <input type="hidden" id="cltagrnot1" name="cltagrnot1">
    <datalist id="dtlcltargnot" role="listbox">
    <?php $cliente = CLT(); // Obtener clientes
    if ($cliente !== false && count($cliente) > 0) {
    foreach ($cliente as $clientes){ ?>
    <option value="<?php echo $clientes["ID_CLIENTE"]; ?>"><?php echo $clientes["NOMBRE_CLIENTE"]; ?></option>
    <?php }} ?>
    </datalist>
    </div>
  
  
    <div class="col-sm-6">
    <label for="Datenotf" class="form-label">Fecha Notif.</label>
    <input type="DATE" class="form-control" id="Datenotf" name="Datenotf" required autocomplete="off">
    </div>
        
            
    <div class="col-sm-6">
    <label for="Notfic" class="form-label">No. Notificación</label>
    <input type="text" class="form-control" id="Notfic" name="Notfic" required autocomplete="off" maxlength="30">
    </div>
          
          
    <div class="col-sm-6">
    <label for="Tiponotf" class="form-label">Seleccione el tipo de notif.</label>  
    <select id="Tiponotf" name="Tiponotf" class="form-select" style="width: 100%;">
    <option disabled selected style="display:none;"></option>
    <option value="FISCALIZACION">Fiscalizaci&oacute;n</option>
    <option value="CONTROL">Control</option>
    <option value="DEBERES FORMALES">Deberes formales</option>
    </select>
    </div>
          
                   
    <div class="col-md-5">
    <label for="Motnotif" class="form-label">Motivo Notif</label>
    <select class="form-select" id="Motnotif" name="Motnotif" required>
    <option disabled selected style="display:none;"></option>
    <option value="IR2">IR2</option>
    <option value="ITBIS">ITBIS</option>
    <option value="IR3">IR3</option>
    <option value="IR17">IR17</option>
    <option value="ACTIVO">ACTIVO</option>
    <option value="ANTICIPO">ANTICIPO</option>
    </select>
    </div>
          
          
    <div class="col-md-7">
    <label for="carta" class="form-label">Seleccione la carta</label>
    <input class="form-control" type="file" id="carta" name="carta" accept=".pdf">
    </div>
          
    <div class="col-lg-12">
    <label for="Coments" class="form-label">Comentarios</label>
    <textarea rows="2" cols="50" class="form-control" id="Coments" name="Coments"></textarea>
    </div>
  
  </div></div>

</form></div>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green" onclick="agrnotif(document.getElementById('cltagrnot1').value,document.getElementById('Datenotf').value,document.getElementById('Notfic').value,document.getElementById('Tiponotf').value,document.getElementById('Motnotif').value,document.getElementById('carta').files[0],document.getElementById('Coments').value)">Agregar notif.</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#cltagrnot1',false,'#formagrnotif')">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR NOTIFICACION------------------------------->

<?php }
else {header('LOCATION: ./404');}

?>