<?php 

if (strpos($_SERVER['REQUEST_URI'], 'MdetalleC.php') === false) { ?>
<!---- MODAL AGREGAR DETALLE DE CITACION --------->

<div class="modal fade" id="agrddc" data-bs-backdrop="static" aria-hidden="true" >
 <div class="modal-dialog center" style="max-width:none;" >
  <div class="modal-content" style="width:39%;">
   
  <div class="modal-body">
    <div class="ModalTitle">
     <h3 class="modal-title"><strong>Agregar un detalle de citación</strong></h3>
     <hr class="my-4 Divisor">
    </div>
  
  <div class="col-fluid col-lg-12">
    <form id="formagrddc1">
    <label for="slcntfddc" class="form-label">Seleccione la notificacion</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfddc" name="slcntfddc" placeholder="">
    <input type="hidden" id="slcntfddc1" name="slcntfddc1">
    <datalist id="dtlagrddc" role="listbox">
    <?php $DataDC = Datos(5); // Obtener clientes
    if ($DataDC !== false && count($DataDC) > 0) {
    foreach ($DataDC as $DDC){ ?>
    <option value="<?php echo $DDC["IDNotificacion"]; ?>"><?php echo $DDC["NONotificacion"]; ?></option>
    <?php }} ?>
    </datalist>
    </form>
  </div>

  <div class="container" style="display: none;" id="formDDC">
  <form id="formagrddc" style="display:contents;">
    <br>
  <div class="row g-3">

  <div class="col-sm-6">
   <label for="nocddc" class="form-label">No. Caso</label>
   <input type="text" class="form-control" id="nocddc" name="nocddc" required autocomplete="off" maxlength="30">
  </div>
          
  <div class="col-sm-6">
    <label for="fdddc" class="form-label">Fecha detalle</label>
    <input type="DATE" class="form-control" id="fdddc" name="fdddc" required autocomplete="off">
  </div>

    <hr class="Divisor">

  <div class="col-sm-4 SMColumn center" >
   <label for="nontfddc" class="form-label" style="margin-top: -4%;">No. Inconsistencia</label>
   <select class="form-select" id="nontfddc" name="nontfddc" required>
   <option value=""></option>
   </select>
  </div>

  <div class="col-sm-8 SMColumn center">
    <label id="labelinconsisddc" for="inconsisddc" class="form-label" style="margin-top: -2%;">Detalle de Inconsistencia</label>
    <textarea rows="4" cols="30" class="form-control" id="inconsisddc" name="inconsisddc"></textarea>
</div>


<div class="DivTable">
  <ul class="sidebar-nav" id="sidebar-nav" style="width: 100%; margin-bottom: 0%;">
   <li class="nav-item" style="margin-top: 1%;">

  <a class="nav-link b1 collapsed" style="padding: 8px 0px;" data-bs-target="#divdetalle" data-bs-toggle="collapse" aria-expanded="false">
  <span id="spandetalle" class="center" style="width:100%;">Inconsistencias detalladas</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <div id="divdetalle" class="collapse" style="width: 100%;">
    <table id="tabladetalle" class="table table-hover" style="width: 100%; table-layout: fixed; text-align:center;"> 
    
    <colgroup>
      <col style="width: 30%;">
      <col style="width: 70%;">
    </colgroup>

      <thead>
        <tr><th scope="col">Inconsistencias</th> <th scope="col">Detalles</th></tr>
      </thead>

      <tbody class="table-group-divider" id="detalles" style="user-select:text;">

      </tbody>
    </table>
  </div>

    </li>
  </ul>
</div>

<div class="d-inline-flex gap-1 cp">
    <button tabindex="-1" type="button" style="width: 50%;" class="btn btn-primary" onclick="adddetail(document.getElementById('nontfddc').value,document.getElementById('inconsisddc').value)">Agregar</button>
    <button tabindex="-1" type="button" style="width: 50%;" class="btn btn-warning" onclick="dropdetails()">Eliminar</button>
</div>

<hr class="Divisor">


  <div class="col-lg-12 cp">
    <label for="archivosddc" id="labelarchivosddc" class="form-label">Archivos de detalle</label>
    <div class="form-control cartadiv">
    <input type="file" id="archivosddc" class="cartafiles" accept=".pdf,.jpg,.png,.docx,.doc" multiple>
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
   <label for="telddc" class="form-label">Telefono del auditor</label>
   <input type="tel" class="form-control" id="telddc" name="telddc" required autocomplete="off" maxlength="30">
  </div>
  </div></div>

  </form></div></div>

`<hr class="Divisor" style="margin-top: -3%;">

<div class="modal-footer justify-content-center">
<button type="button" tabindex="-1" class="btn btn-success" id="btnagrddc" style="display:none" onclick="addddc(document.getElementById('slcntfddc1').value,document.getElementById('nocddc').value,document.getElementById('fdddc').value,document.getElementById('nontfddc').value,document.getElementById('inconsisddc').value, document.getElementById('archivosddc').files,document.getElementById('cdaddc').value,document.getElementById('ndaddc').value,document.getElementById('telddc').value)">Crear detalle</button>
<button type="button" tabindex="-1" class="btn btn-danger" data-bs-dismiss="modal" onclick="closedetails()">Cancelar</button>
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
  <option value="<?php echo $ddc1s["IDDetalle"]; ?>"><?php echo $ddc1s["NOCaso"]; ?></option>
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