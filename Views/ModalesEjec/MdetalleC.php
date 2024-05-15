<?php 

if (strpos($_SERVER['REQUEST_URI'], 'MdetalleC.php') === false) { ?>
<!---- MODAL AGREGAR DETALLE DE CITACION --------->
<div class="modal fade" id="agrddc" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable" style="display: flex;
    align-items: center;
    justify-content: center;
    width: 35%;
    max-width: none;"><div class="modal-content" style="max-width:none;">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Agregar un detalle de citación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<form id="formagrddc" style="overflow-y: auto;">

  <div class="container">
  <div class="row g-3">
  
  <div class="col-fluid col-lg-12">
    <form id="formagrddc1">
    <label for="slcntfddc" class="form-label">Seleccione la notificacion</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfddc" name="slcntfddc" placeholder="">
    <input type="hidden" id="slcntfddc1" name="slcntfddc1">
    <datalist id="dtlagrddc" role="listbox">
    <?php $ddc = Datos(5); // Obtener clientes
    if ($ddc !== false && count($ddc) > 0) {
    foreach ($ddc as $ddcs){ ?>
    <option value="<?php echo $ddcs["IDNotificacion"]; ?>"><?php echo $ddcs["NONotificacion"]; ?></option>
    <?php }} ?>
    </datalist>
    </form>
  </div>


  <div class="col-sm-6">
   <label for="nocddc" class="form-label">No. Caso</label>
   <input type="text" class="form-control" id="nocddc" name="nocddc" required autocomplete="off" maxlength="30">
  </div>
          
  <div class="col-sm-6">
    <label for="fdddc" class="form-label">Fecha detalle</label>
    <input type="DATE" class="form-control" id="fdddc" name="fdddc" required autocomplete="off">
  </div>

    <div class="col-lg-12 cp">
    <label for="archivosddc" id="labelarchivosddc" class="form-label">Archivos de detalle</label>
    <div class="form-control cartadiv">
    <input type="file" id="archivosddc" name="archivosdcc[]" class="cartafiles" accept=".pdf,.jpg,.png,.docx" multiple>
    <div class="fileicon fico1">
    <i id="fiiconddc" class="bi bi-arrow-up-circle"></i><span id="fispanddc"> Buscar archivos</span>
    </div>
    </div>
    </div>

<hr class="my-4" style="margin-bottom: 0rem !important; background-color: #53ce00 !important; color: #53ce00; height: 4px;">

<ul class="sidebar-nav" id="sidebar-nav">
<li class="nav-item">
  <a class="nav-link collapsed b1" style="padding: 8px 0px;" data-bs-target="#divdetalle" data-bs-toggle="collapse" href="#">
  <span id="spandetalle">Detalles agregados</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <div id="divdetalle" class="collapse" style="width: 100%;">
        <table id="tabladetalle" class="table" style="width: 100%; table-layout: fixed;"> 
            <col style="width: 100%;"> <!-- Establecer el ancho de cada columna -->
            <thead><th>Inconsistencia</th></thead>
            <tbody id="detalles"></tbody>
        </table>
</div></li></ul>


<hr class="my-4" style="margin-top: 0rem !important; margin-bottom: 0rem !important; background-color: #53ce00 !important; color: #53ce00; height: 4px;">


<div class="col-lg-12">
    <label id="labelinconsisddc" for="inconsisddc" class="form-label">Inconsistencia</label>
    <textarea rows="2" cols="50" class="form-control" id="inconsisddc" name="inconsisddc"></textarea>
</div>

    <div class="d-inline-flex gap-1 cp">
    <button type="button" style="width: 50%;" class="btn btn-primary" onclick="adddetail(document.getElementById('inconsisddc').value)">Agregar</button>
    
    <button type="button" style="width: 50%;" class="btn btn-warning" onclick="dropdetails()">Eliminar</button>
    </div>

  
  </div></div>

</form></div>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">

<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" style="background-color:green" onclick="addddc(document.getElementById('slcntfddc1').value,document.getElementById('nocddc').value,document.getElementById('fdddc').value,document.getElementById('archivosddc').files)">Crear detalle</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closedetails()">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR NOTIFICACION------------------------------->


<!----------------------- MODAL ELIMINAR NOTIFICACION -------------------->
<div class="modal fade" id="dltddc" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar un detalle de citación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">

<div class="col-fluid col-lg-12">
<form id="formdltddc">
  <label for="slcdltddc" class="form-label labeledtmdf">Seleccione el numero de caso</label>  
  <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltddc" name="slcdltddc" placeholder="">
  <input type="hidden" id="slcdltddc1" name="slcdltddc1">
  <datalist id="dtldltddc" role="listbox">
  <?php $ddc1 = Datos(6);
  if ($ddc1 !== false && count($ddc1) > 0) {
  foreach ($ddc1 as $ddc1s){ ?>
  <option value="<?php echo $ddc1s["ID_DETALLE"]; ?>"><?php echo $ddc1s["NO_CASO"]; ?></option>
  <?php }} ?>
  </datalist>
</form>
</div>

</div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="d-flex justify-content-center mx-auto">
    <button type="button" id="btndltddc" class="btn btn-success" style="background-color:green; display:none;" onclick="dltddc(document.getElementById('slcdltddc1').value,document.getElementById('slcdltddc').value)">Eliminar detalle</button>
   &nbsp; <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc')">Cancelar</button>
</div>
</div></div></div></div>
<!----------------FIN ELIMINAR NOTIFICACION------------------------------->


<?php }
else {header('LOCATION: ./404');}

?>