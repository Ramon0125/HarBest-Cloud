<?php 

if (preg_match('/Mescrito(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

else { ?><!---- MODAL AGREGAR ESCRITO DE DESCARGO --------->
<div class="modal fade" id="agredd" data-bs-backdrop="static" aria-hidden="true" >
 <div class="modal-dialog center">
  <div class="modal-content">  
    <div class="modal-body">
      <div class="ModalTitle">
        <h3 class="modal-title">Agregar un escrito de descargo</h3>
        <hr class="hdivisor mb-2">
      </div>
  
      <div class="col-lg-12 SMData">
        <form id="formagredd">
          <label for="slcntfedd" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>  
          <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfedd">
          <input type="hidden" id="slcntfedd1" name="slcntfedd1">
          
          <datalist id="dtlagredd" role="listbox" class="dtl2">
            <?php $DataED = Datos(7);
              if ($DataED !== false && count($DataED) > 0) 
              {
                foreach ($DataED as $EDD)
                { 
                  echo '<option value="' . htmlspecialchars($EDD["CodigoNotif"]) . '">' . htmlspecialchars($EDD["CodigoNotif"]) . '</option>'; 
                }
              } 
            ?>
          </datalist>
        </form>
      </div>

      <div id="formEDD" class="row g-3 mt-0" style="display: none;">
        <hr class="hdivisor">
  
        <div class="col-sm-6 mt-5"> 
          <label for="FechaEscrito" class="form-label labeledtmdf">Fecha escrito</label>
          <input type="DATE" class="form-control" id="FechaEscrito" autocomplete="off">
        </div>

        <div class="col-sm-6">
          <label for="Fileprg" class="labeledtmdf">Archivo de escrito</label>
          <input type="file" id="FileEDD" hidden>
          
          <div class="upload-container" id="ContainerEDD">
            <div class="border-container cp">
              <div class="center">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                  <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z"/>
                  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
              </div>
           
              <p class="center">       
                <span>
                  <a id="Spanedd" style="color: var(--color);">Buscar</a> el Archivo.
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-footer mfooter">
      <button type="button" class="btn btn-success" id="btnagredd" style="display:none;" onclick="addedd(document.getElementById('slcntfedd1').value,document.getElementById('FechaEscrito').value,document.getElementById('FileEDD').files[0])">
        <i class="bi bi-floppy"></i>&nbsp;Crear
      </button>

      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeescrito()">Cancelar</button>
    </div>
  </div>
 </div>
</div>
<!----------------FIN AGREGAR ESCRITO------------------------------->


<!----------------------- MODAL ELIMINAR ESCRITO -------------------->
<div class="modal fade" id="dltedd" data-bs-backdrop="static" aria-hidden="true" >
  <div class="modal-dialog center">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Eliminar un escrito de descargo</h3>
          <hr class="hdivisor mb-2">
        </div>
  
        <div class="col-lg-12">
          <form id="formagredd">
            <label for="slcdltedd" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>  
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltedd">
            <input type="hidden" id="slcdltedd1">

            <datalist id="dtldltedd" role="listbox">
              <?php $DataED1 = Datos(8);
                if ($DataED1 !== false && count($DataED1) > 0) 
                {
                  foreach ($DataED1 as $EDD1)
                  { 
                    echo '<option value="' . htmlspecialchars($EDD1["IDEscrito"]) . '">' . htmlspecialchars($EDD1["CodigoNotif"]) . '</option>';
                  }
                } 
              ?>
            </datalist>
          </form>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" class="btn btn-success" id="btndltedd" style="display:none" onclick="dltedd(document.getElementById('slcdltedd1').value,document.getElementById('slcdltedd').value)">
          <i class="bi bi-trash"></i> Eliminar
        </button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeescrito()">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!----------------FIN ELIMINAR ESCRITO-------------------------------> <?php }