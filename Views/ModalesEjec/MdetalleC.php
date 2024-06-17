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


    
<div class="d-inline-flex gap-1">
<div class="col-sm-3.5">
   <label for="cdaddc" class="form-label">Correo del auditor</label>
   <input type="email" class="form-control" id="cdaddc" name="cdaddc" required autocomplete="off" maxlength="30">
  </div>


  <div class="col-sm-3.5">
   <label for="ndaddc" class="form-label">Nombre del auditor</label>
   <input type="text" class="form-control" id="ndaddc" name="ndaddc" required autocomplete="off" maxlength="30">
  </div>
          
  <div class="col-sm-3.5">
   <label for="telddc" class="form-label">telefono del auditor</label>
   <input type="tel" class="form-control" id="telddc" name="telddc" required autocomplete="off" maxlength="30">
  </div>
  </div>

  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">


  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">

    <a class="nav-link collapsed b1" style="padding: 8px 0px;" data-bs-target="#divdetalle" data-bs-toggle="collapse" href="#">
      <span id="spandetalle" style="display: flex; width:100%; justify-content:center">Detalles agregados</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>

    <div id="divdetalle" class="collapse" style="width: 100%;">
      <table id="tabladetalle" class="table" style="width: 100%; table-layout: fixed;"> 
        <col style="width: 100%;"> <!-- Establecer el ancho de cada columna -->
        <tbody id="detalles"></tbody>
      </table>
    </div>

    </li>
  </ul>



<div class="col-lg-12">
    <label id="labelinconsisddc" for="inconsisddc" class="form-label">Detalles de Inconsistencia</label>
    <textarea rows="4" cols="30" class="form-control" id="inconsisddc" name="inconsisddc"></textarea>
</div>

<div class="d-inline-flex gap-1 cp">
    <button tabindex="-1" type="button" style="width: 50%;" class="btn btn-primary" onclick="adddetail(document.getElementById('inconsisddc').value)">Agregar</button>
    <button tabindex="-1" type="button" style="width: 50%;" class="btn btn-warning" onclick="dropdetails()">Eliminar</button>
</div>

<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">

  </div></div>

</form></div>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">

<div class="modal-footer justify-content-center">
<button type="button" tabindex="-1" class="btn btn-success" style="background-color:green" onclick="addddc(document.getElementById('slcntfddc1').value,document.getElementById('nocddc').value,document.getElementById('fdddc').value,document.getElementById('archivosddc').files,document.getElementById('inconsisddc').value,document.getElementById('cdaddc').value,document.getElementById('ndaddc').value,document.getElementById('telddc').value)">Crear detalle</button>
<button type="button" tabindex="-1" class="btn btn-danger" data-bs-dismiss="modal" onclick="closedetails()">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR NOTIFICACION------------------------------->




<?php }
else {header('LOCATION: ./404');}

?>