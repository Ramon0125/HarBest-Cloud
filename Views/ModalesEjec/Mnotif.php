<?php 

if (strpos($_SERVER['REQUEST_URI'], 'Mnotif.php') === false) { ?>

<!---- MODAL AGREGAR NOTIFICACION --------->
<div class="modal fade" id="agrnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable"><div class="modal-content" style="left: -12%; width: 127%; top:2%;">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar una nueva notificación</strong></h3>
<hr class="my-4 hr4">
</div>
<form id="formagrnotif">

  <div class="container">

  <div class="row g-3">
  
  <div class="col-lg-12 cp">
    <label for="Cartanotif" class="form-label">Carta de notificación</label>
    <div class="form-control cartadiv">
    <input type="file" id="Cartanotif" class="cartafiles" accept=".pdf,.jpg,.png,.docx" multiple>
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
    <input type="DATE" class="form-control" id="Datenotf" name="Datenotf" required autocomplete="off"  max="<?php echo date("Y-m-d")?>">
  </div>
        

  <div style="overflow-y: auto;background: silver;">
  
  <ul class="sidebar-nav" id="sidebar-nav" style="width: 100%; margin-bottom: 0%;">
   <li class="nav-item" style="margin-top: 1%;">

  <a class="nav-link b1 collapsed" style="padding: 8px 0px;" data-bs-target="#divnotifi" data-bs-toggle="collapse" aria-expanded="false">
    <span id="spannotif" style="display: flex; width:88%; justify-content:center; position: absolute;">Notificaciones Agregadas</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <div id="divnotifi" class="collapse" style="width: 100%;">
    <table id="tablenotif" class="table" style="width: 100%; overflow:auto; text-align:center;"> 

      <colgroup><col style="width: 33%;">
      <col style="width: 33%;">
      <col style="width: 33%;">
      
      </colgroup><thead>
       <tr><th>Numero</th>
       <th>Tipo</th>
       <th>Impuesto</th>
      </tr></thead>
      
      <tbody id="tablanotif">
      </tbody>

    </table>
  </div>

   </li>
  </ul>
  </div>

  <div class="col-sm-6">
  <label for="Notfic" class="form-label">Numero Notificación</label>
  <input type="text" class="form-control" id="Notfic" name="Notfic" required autocomplete="off" maxlength="30">
  </div>
          
  <div class="col-sm-6">
  <label for="Tiponotf" class="form-label">Tipo Notificación</label>  
  <select id="Tiponotf" name="Tiponotf" class="form-select" style="width: 100%;">
  <option disabled selected style="display:none;"></option>
  <option value=""></option>
  <option value="FISCALIZACION">Fiscalizaci&oacute;n</option>
  <option value="CONTROL">Control</option>
  <option value="DEBERES FORMALES">Deberes formales</option>
  </select>
  </div>   

<div id="Incumplimientos" class="row g-3" style="margin-top: -2%;">  

  <div class="col-sm-6">
  <label for="Motnotif" class="form-label">Motivo Notif</label>
  <input type="text" class="form-control" name="Motnotif" id="Motnotif">
  </div>
          
  <div class="col-sm-6">
  <label for="Aincu" class="form-label">Año incumplimiento </label>
  <input type="text" class="form-control" name="Aincu" id="Aincu">
  </div>

</div>
  


  <hr class="my-4 hr4">

  <div class="d-inline-flex gap-2 cp">
  <button tabindex="-1" type="button" style="width: 50%;" class="btn btn-primary" onclick="addnotificacion(document.getElementById('Notfic').value,document.getElementById('Tiponotf').value,document.getElementById('Incumplimientos'))"><i class="bi bi-floppy"></i> Guardar inconsistencia</button>
   <button tabindex="-1" type="button" style="width: 50%;" class="btn btn-warning" onclick="dropnotificacion()"><i class="bi bi-trash"></i> Eliminar inconsistencia</button>
  <button tabindex="-1" type="button" class="btn btn-secondary" onclick="addinc()"><i class="bi bi-file-plus"></i> Añadir incumplimiento</button>
   <button tabindex="-1" type="button" class="btn btn-secondary" onclick="dltinc()"><i class="bi bi-trash"></i> Eliminar incumplimiento</button>
  </div>

      
  </div></div>

</form></div>
<hr class="my-4 hr4">
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green" onclick="agrnotif(document.getElementById('cltagrnot1').value,document.getElementById('Datenotf').value,document.getElementById('Cartanotif').files,document.getElementById('Notfic').value,document.getElementById('Tiponotf').value,document.getElementById('Motnotif').value,document.getElementById('Aincu').value)"><i class="bi bi-plus-circle"></i> Crear</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closenotif()">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR NOTIFICACION------------------------------->





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
  <option value="<?php echo $notifs["IDNotificacion"]; ?>"><?php echo $notifs["NOTIFICACION"]; ?></option>
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