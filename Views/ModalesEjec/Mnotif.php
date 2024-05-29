<?php 

if (strpos($_SERVER['REQUEST_URI'], 'Mnotif.php') === false) { ?>
<!---- MODAL AGREGAR NOTIFICACION --------->
<div class="modal fade" id="agrnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar una nueva notificación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<form id="formagrnotif" style="overflow-y: auto;">

  <div class="container">
  <div class="row g-3">
  
  <div class="col-lg-12 cp">
    <label for="Cartanotif" class="form-label">Carta de notificación</label>
    <div class="form-control cartadiv">
    <input type="file" id="Cartanotif" class="cartafiles" accept=".pdf,.jpg,.png,.docx">
    <div class="fileicon fico">
    <i id="fiicon" class="bi bi-arrow-up-circle"></i><span id="fispan"> Buscar carta de notificación</span>
    </div>
    </div>
    </div>

    <div class="col-sm-6">
    <label for="cltagrnot" class="form-label">Cliente</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="cltagrnot" name="cltagrnot" placeholder="">
    <input type="hidden" id="cltagrnot1" name="cltagrnot1">
    <datalist id="dtlcltargnot" role="listbox">
    <?php $cliente = Datos(2); // Obtener clientes
    if ($cliente !== false && count($cliente) > 0) {
    foreach ($cliente as $clientes){ ?>
    <option value="<?php echo $clientes["ID_CLIENTE"]; ?>"><?php echo $clientes["NOMBRE_CLIENTE"]; ?></option>
    <?php }} ?>
    </datalist>
    </div>
  
  
    <div class="col-sm-6">
    <label for="Datenotf" class="form-label">Fecha Notificación</label>
    <input type="DATE" class="form-control" id="Datenotf" name="Datenotf" required autocomplete="off">
    </div>
        
            
    <div class="col-sm-6">
    <label for="Notfic" class="form-label">Numero Notificación</label>
    <input type="text" class="form-control" id="Notfic" name="Notfic" required autocomplete="off" maxlength="30">
    </div>
          
          
    <div class="col-sm-6">
    <label for="Tiponotf" class="form-label">Tipo Notificación</label>  
    <select id="Tiponotf" name="Tiponotf" class="form-select" style="width: 100%;">
    <option disabled selected style="display:none;"></option>
    <option value="FISCALIZACION">Fiscalizaci&oacute;n</option>
    <option value="CONTROL">Control</option>
    <option value="DEBERES FORMALES">Deberes formales</option>
    </select>
    </div>
          
                   
    <div class="col-sm-6">
    <label for="Motnotif" class="form-label">Motivo Notif</label>
    <input type="text" class="form-control" name="Motnotif" id="Motnotif">
    </div>
          
    <div class="col-sm-6">
    <label for="Aincu" class="form-label">Año incumplimiento </label>
    <input type="text" class="form-control" name="Aincu" id="Aincu">
    </div>
          
    <div class="col-lg-12">
    <label for="Coments" class="form-label">Comentarios</label>
    <textarea rows="2" cols="50" class="form-control" id="Coments" name="Coments"></textarea>
    </div>
          
  </div></div>

</form></div>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green" onclick="agrnotif(document.getElementById('cltagrnot1').value,document.getElementById('Datenotf').value,document.getElementById('Notfic').value,document.getElementById('Tiponotf').value,document.getElementById('Motnotif').value,document.getElementById('Cartanotif').files[0],document.getElementById('Aincu').value,document.getElementById('Coments').value)">Agregar notif.</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#cltagrnot1',false,'#formagrnotif')">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR NOTIFICACION------------------------------->


<!----------------------- MODAL EDITAR NOTIFICACION -------------------->
<div class="modal fade" id="edtnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-body">

<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Editar una notificación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>

<div class="container">
<div class="row g-3">

<div class="col-fluid col-lg-12">
<form id="formedtnotif">
  <label for="slcnotif" class="form-label labeledtmdf">Seleccione la notificacion</label>  
  <input class="form-control" autocomplete="off" role="combobox" list="" id="slcnotif" name="slcnotif" placeholder="">
  <input type="hidden" id="slcnotif1" name="slcnotif1">
  <datalist id="dtledtnot" role="listbox">
  <?php $notif = Datos(4); // Obtener clientes
  if ($notif !== false && count($notif) > 0) {
  foreach ($notif as $notifs){ ?>
  <option value="<?php echo $notifs["IDNotificacion"]; ?>"><?php echo $notifs["NONotificacion"]; ?></option>
  <?php }} ?>
  </datalist>
</form>
</div>

</div></div>

<div class="container" id="formedtnotif1" style="display: none;">
<form id="formedtnotif11">
<br>
<div class="row g-3">
<div class="col-sm-6">
    <label for="cltedtnot" class="form-label">Seleccione el cliente</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="cltedtnot" name="cltedtnot" placeholder="">
    <input type="hidden" id="cltedtnot1" name="cltedtnot1">
    <datalist id="dtlcltedtnot" role="listbox">
    <?php $cliente = Datos(2); // Obtener clientes
    if ($cliente !== false && count($cliente) > 0) {
    foreach ($cliente as $clientes){ ?>
    <option value="<?php echo $clientes["ID_CLIENTE"]; ?>"><?php echo $clientes["NOMBRE_CLIENTE"]; ?></option>
    <?php }} ?>
    </datalist>
</div>


<div class="col-sm-6">
  <label for="edtDatenotf" class="form-label">Fecha Notif.</label>
  <input type="DATE" class="form-control" id="edtDatenotf" name="edtDatenotf" required autocomplete="off">
  </div>


<div class="col-sm-6">
  <label for="edtNotfic1" class="form-label">Notificación</label>
  <input type="text" class="form-control" id="edtNotfic1" name="edtNotfic1" required autocomplete="off" maxlength="30">
  </div>


  <div class="col-sm-6">
  <label for="edtTiponotf1" class="form-label">Seleccione el tipo de notif.</label>  
  <select id="edtTiponotf1" name="edtTiponotf1" class="form-select" style="width: 100%;">
  <option disabled selected style="display:none;"></option>
  <option value="FISCALIZACION">Fiscalizaci&oacute;n</option>
  <option value="CONTROL">Control</option>
  <option value="DEBERES FORMALES">Deberes formales</option>
  </select>
  </div>

         
  <div class="col-sm-6">
    <label for="edtMotnotif" class="form-label">Motivo Notif</label>
    <input type="text" class="form-control" name="edtMotnotif" id="edtMotnotif">
    </div>
          
    <div class="col-sm-6">
    <label for="edtAincu" class="form-label">Año incumplimiento </label>
    <input type="text" class="form-control" name="edtAincu" id="edtAincu">
    </div>
          

</div></form></div>

</div>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
<div class="modal-footer justify-content-center">
<button type="button" id="btnedtnotif" class="btn btn-success" style="display:none; background-color:green" onclick="edtnotif(document.getElementById('slcnotif1').value,document.getElementById('slcnotif').value,document.getElementById('cltedtnot1').value,document.getElementById('edtDatenotf').value,document.getElementById('edtNotfic1').value,document.getElementById('edtTiponotf1').value,document.getElementById('edtMotnotif').value,document.getElementById('edtAincu').value)">Editar notif.</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#slcnotif1','#cltedtnot1'],['#dtledtnot','#formedtnotif1','#btnedtnotif'],['#formedtnotif11','#formedtnotif'])">Cancelar</button>
</div>
</div></div></div>

<!----------------FIN EDITAR NOTIFICACION------------------------------->



<!----------------------- MODAL ELIMINAR NOTIFICACION -------------------->
<div class="modal fade" id="dltnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar una notificación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">

<div class="col-fluid col-lg-12">
<form id="formdltnotif">
  <label for="slcdltnotif" class="form-label labeledtmdf">Seleccione la notificacion</label>  
  <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltnotif" name="slcdltnotif" placeholder="">
  <input type="hidden" id="slcdltnotif1" name="slcdltnotif1">
  <datalist id="dtldltnot" role="listbox">
  <?php $notif = Datos(4);
  if ($notif !== false && count($notif) > 0) {
  foreach ($notif as $notifs){ ?>
  <option value="<?php echo $notifs["IDNotificacion"]; ?>"><?php echo $notifs["NONotificacion"]; ?></option>
  <?php }} ?>
  </datalist>
</form>
</div>

</div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="d-flex justify-content-center mx-auto">
    <button type="button" id="btndltnotif" class="btn btn-success" style="background-color:green; display:none;" onclick="dltnotif(document.getElementById('slcdltnotif1').value,document.getElementById('slcdltnotif').value)">Eliminar notif.</button>
   &nbsp; <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltnotif1',['#dtldltnot','#btndltnotif'],'#formdltnotif')">Cancelar</button>
</div>
</div></div></div></div>
<!----------------FIN ELIMINAR NOTIFICACION------------------------------->


<?php }
else {header('LOCATION: ./404');}

?>