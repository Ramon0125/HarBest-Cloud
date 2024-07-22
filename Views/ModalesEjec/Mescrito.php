<?php if (strpos($_SERVER['REQUEST_URI'], 'Mescrito.php') !== false) { header('LOCATION: ./404');} ?>

<!---- MODAL AGREGAR DETALLE DE CITACION --------->
<div class="modal fade" id="agredd" data-bs-backdrop="static" aria-hidden="true" >
 <div class="modal-dialog center">
  <div class="modal-content">
   
  <div class="modal-body">
    <div class="ModalTitle">
     <h3 class="modal-title"><strong>Agregar un escrito de descargo</strong></h3>
     <hr class="my-4 Divisor">
    </div>
  
  <div class="col-fluid col-lg-12">
    <form id="formagredd">
    <label for="slcntfedd" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfedd" name="slcntfedd" placeholder="">
    <input type="hidden" id="slcntfedd1" name="slcntfedd1">
    <datalist id="dtlagredd" role="listbox">
        <option value="1">1eee</option>
        <option value="2">2rrr</option>
        <option value="3">3ttt</option>
    <?php // Obtener clientes
    $DataED = Datos(7);
    if ($DataED !== false && count($DataED) > 0) {
    foreach ($DataED as $EDD){ ?>
    <option value="<?php echo $EDD["CodigoNotif"]; ?>"><?php echo $EDD["CodigoNotif"]; ?></option>
    <?php }} ?>
    </datalist>
    </form>
  </div>

  <div class="container" id="formEDD" style="display: none; padding-left: unset;">


    <div class="upload-container">

      <div class="border-container">

      <div class="center">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
          <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z"/>
          <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
        </svg>
      </div>
       
       <input type="file" id="FileEscrito" hidden>
      
      <p class="center">       
         <span><a id="file-browser" class="cp">Buscar</a> el escrito de descargo.</span>
      </p>

      </div>
      
    </div>

  </div>
 </div>

`<hr class="Divisor" style="margin-top: -3%;">

<div class="modal-footer justify-content-center">
<button type="button" tabindex="-1" class="btn btn-success" id="btnagredd" style="display:none" 
onclick="addedd(document.getElementById('slcntfedd1').value,document.getElementById('FileEscrito').files[0])">
<i class="bi bi-floppy"></i> Crear</button>
<button type="button" tabindex="-1" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeescrito()">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR ESCRITO------------------------------->


<!----------------------- MODAL ELIMINAR ESCRITO -------------------->
<div class="modal fade" id="dltedd" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog"><div class="modal-content">
<div class="modal-body">
<div class="ModalTitle">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar un escrito</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">

<div class="col-fluid col-lg-12">
<form id="formdltddc">
  <label for="slcdltedd" class="form-label labeledtmdf">Seleccione el codigo de notificaciòn</label>  
  <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltedd" name="slcdltedd" placeholder="">
  <input type="hidden" id="slcdltedd1" name="slcdltedd1">
  <datalist id="dtldltedd" role="listbox">
  <?php $edd1 = Datos(8);
  if ($edd1 !== false && count($edd1) > 0) {
  foreach ($edd1 as $edd1s){ ?>
  <option value="<?php echo $edd1s["IDEscrito"]; ?>"><?php echo $edd1s["CodigoNotif"]; ?></option>
  <?php }} ?>
  </datalist>
</form>
</div>

</div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="d-flex justify-content-center mx-auto">
    <button type="button" id="btndltedd" class="btn btn-success" style="background-color:green; display:none;" onclick="dltddc(document.getElementById('slcdltddc1').value,document.getElementById('slcdltddc').value)">Eliminar detalle</button>
   &nbsp; <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc')">Cancelar</button>
</div>
</div></div></div></div>
<!----------------FIN ELIMINAR ESCRITO------------------------------->
