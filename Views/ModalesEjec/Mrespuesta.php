<?php 

if (preg_match('/Mrespuesta(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

?>

<!---- MODAL AGREGAR DETALLE DE CITACION --------->
<div class="modal fade" id="agrresdgii" data-bs-backdrop="static" aria-hidden="true" >
 <div class="modal-dialog center">
  <div class="modal-content">
   
  <div class="modal-body">
    <div class="ModalTitle">
     <h3 class="modal-title"><strong>Agregar un respuesta de la DGII</strong></h3>
     <hr class="my-4 Divisor">
    </div>
  
  <div class="col-fluid col-lg-12">
    <form id="formagrrdgii">
    <label for="slcntfrdgii" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>  
    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfrdgii" name="slcntfrdgii">
    <input type="hidden" id="slcntfrdgii1" name="slcntfrdgii1">
    <datalist id="dtlagrrdgii" role="listbox">
    <?php $DataED = Datos(7);
    if ($DataED !== false && count($DataED) > 0) {
    foreach ($DataED as $EDD){ ?>
    <option value="<?php echo $EDD["CodigoNotif"]; ?>"><?php echo $EDD["CodigoNotif"]; ?></option>
    <?php }} ?>
    </datalist>
    </form>
  </div>

  <div class="container" id="formrdgii" style="display: none; padding-left: unset;">

  <hr class="Divisor" style="margin-top: 3%; margin-bottom: 2%; width: 103%;">

  <div style="display:flex; gap: 10px;">
  <div class="col-sm-6">
    <label for="frdgii" class="form-label center" style="margin-top: 3%;">Fecha respuesta</label>
    <input type="DATE" class="form-control" id="frdgii" name="frdgii" required autocomplete="off">
  
    <label for="tipordgii" class="form-label center" style="margin-top: 13px;">Tipo respuesta</label>
        <select id="tipordgii" class="form-select">
            <option value="">Acta de descargo</option>
            <option value="">Aceptacion de inconsistencia</option>
            <option value="">Resolucion de determinacion</option>
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
       
        <input type="file" id="FileEscrito" hidden>
      
        <p class="center">       
         <span><a id="file-browser" class="cp">Buscar</a> el archivo.</span>
        </p>

      </div>
      
    </div>
    </div>

  </div>
 </div>

`<hr class="Divisor" style="margin-top: -5%;">

<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-success" id="btnagrrdgii" style="display:none" 
onclick="addedd(document.getElementById('slcntfedd1').value,document.getElementById('FechaEscrito').value,document.getElementById('FileEscrito').files[0])">
<i class="bi bi-floppy"></i> Crear</button>
<button type="button" tabindex="-1" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeescrito()">Cancelar</button>
</div></div></div></div>
<!----------------FIN AGREGAR ESCRITO------------------------------->