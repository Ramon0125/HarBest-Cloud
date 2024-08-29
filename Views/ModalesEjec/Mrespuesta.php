<?php 

if (preg_match('/Mrespuesta(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); }

else { ?><!---- MODAL AGREGAR RESPUESTA DGII --------->
<div class="modal fade" id="agrresdgii" data-bs-backdrop="static" aria-hidden="true" >
  <div class="modal-dialog center">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Agregar una respuesta de la DGII</h3>
          <hr class="hdivisor mb-2">
        </div>
  
        <div class="col-lg-12">
          <form id="formagrrdgii">
            <label for="slcntfrdgii" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>  
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfrdgii">
            <input type="hidden" id="slcntfrdgii1">

            <datalist id="dtlagrrdgii" role="listbox">
       <?php $DataRD = Datos(9);
       if ($DataRD !== false && count($DataRD) > 0) {
        foreach ($DataRD as $RDGII){ ?>
          <option value="<?php echo $RDGII["CodigoNotif"]; ?>"><?php echo $RDGII["CodigoNotif"]; ?></option>
       <?php }} ?>
      </datalist> 
     </form>
    </div>

    <div class="row" id="formrdgii" style="display: none; padding-left: unset;">

     <hr class="Divisor" style="margin-top: 3%; margin-bottom: 2%; width: 103%;">

     <div style="display:flex; gap: 10px; margin-bottom: 2%;">

      <div class="col-sm-6">
       <label for="frdgii" class="form-label center" style="margin-top: 3%;">Fecha respuesta</label>
       <input type="DATE" class="form-control" id="frdgii" name="frdgii">
  
       <label for="tipordgii" class="form-label center" style="margin-top: 13px;">Tipo respuesta</label>
       <select id="tipordgii" class="form-select">
        <option value="Acta de descargo">Acta de descargo</option>
        <option value="Aceptacion de inconsistencia">Aceptacion de inconsistencia</option>
        <!-- <option value="Resolucion de determinacion">Resolucion de determinacion</option> -->
       </select>   
      </div>
  
    <div class="col-sm-6 upload-container">

      <div class="border-container1">

        <div class="center">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
           <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z"/>
           <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
          </svg>
        </div>
       
        <input type="file" id="FileRes" hidden>
      
        <p class="center">       
         <span><a id="file-res-browser" class="cp">Buscar</a> el archivo.</span>
        </p>

      </div>
      
    </div>

    </div>

    <div class="col-lg-12" style="width: 102%;">
    <label for="ComentsRes" class="form-label labeledtmdf">Comentarios:</label>
    <textarea rows="5" class="form-control" id="ComentsRes" name="ComentsRes"></textarea>
  </div>

  </div>
 </div>

<div class="modal-footer justify-content-center">
 
 <button type="button" class="btn btn-success" id="btnagrrdgii" style="display:none;" 
 onclick="addres(document.getElementById('slcntfrdgii').value,document.getElementById('frdgii').value,document.getElementById('ComentsRes').value,document.getElementById('tipordgii').value,document.getElementById('FileRes').files[0])">
 <i class="bi bi-floppy"></i> Crear</button>

 <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeres()">Cancelar</button>

</div>

</div></div></div>
<!----------------FIN AGREGAR RESPUESTA DGII------------------------------->



<!----------------------- MODAL ELIMINAR RESPUESTA DGII-------------------->
<div class="modal fade" id="dltrdgii" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar una respuesta de la DGGI</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">

<div class="col-fluid col-lg-12">
<form id="formdltrdgii">
  <label for="slcdltrdgii" class="form-label labeledtmdf">Seleccione el codigo de notificaciòn</label>  
  <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltrdgii" name="slcdltrdgii" placeholder="">
  <input type="hidden" id="slcdltrdgii1" name="slcdltrdgii">
  <datalist id="dtldltrdgii" role="listbox">
  <?php $DataRD1 = Datos(10);
  if ($DataRD1 !== false && count($DataRD1) > 0) {
  foreach ($DataRD1 as $RDGII1){ ?>
  <option value="<?php echo $RDGII1["IDRespuesta"]; ?>"><?php echo $RDGII1["CodigoNotif"]; ?></option>
  <?php }} ?>
  </datalist>
</form>
</div>

</div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="modal-footer justify-content-center">
    <button type="button" id="btndltrdgii" class="btn btn-success" style="background-color:green; display:none;" onclick="dltrdgii(document.getElementById('slcdltrdgii1').value,document.getElementById('slcdltrdgii').value)">
    <i class="bi bi-trash"></i>Eliminar</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltrdgii1',['#dtldltrdgii','#btndltrdgii'],'#formdltrdgii')">Cancelar</button>
</div>
</div></div></div></div>
<!----------------FIN ELIMINAR RESPUESTA DGII------------------------------->
<?php }