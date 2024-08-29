<?php 

if (preg_match('/Mnotif(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

else { ?><!---- MODAL AGREGAR NOTIFICACION --------->
<div class="modal fade" id="agrnot" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content" style="width: 127%;">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Agregar una nueva notificación</h3>
          <hr class="hdivisor mb-2">
        </div>

        <form id="formagrnotif">
          <div class="container">
            <div class="row g-3">

              <div class="col-sm-6 SMData">
                <label for="cltagrnot" class="form-label">Cliente</label>  
                <input class="form-control" autocomplete="off" role="combobox" list="" id="cltagrnot" placeholder="">
                <input type="hidden" id="cltagrnot1">

                <datalist datalist id="dtlcltargnot" role="listbox">
                  <?php $DataCliente = Datos(2); // Obtener clientes
                    if ($DataCliente !== false && count($DataCliente) > 0) 
                    {
                      foreach ($DataCliente as $DC)
                      { 
                        echo '<option value="' . htmlspecialchars($DC["IDCliente"]) . '">' . htmlspecialchars($DC["NombreCliente"]) . '</option>'; 
                      }
                    } 
                  ?>
                </datalist>
              </div>
                  
              <div class="col-sm-6">
                <label for="Datenotf" class="form-label">Fecha Notificación</label>
                <input type="DATE" class="form-control" id="Datenotf" autocomplete="off">
              </div>

              <div class="col-lg-12">
                <label id="labelcartanotif" for="Cartanotif" class="form-label">Archivos de la notificación</label>
                <div class="form-control cartadiv">
                  <input type="file" id="Cartanotif" class="cartafiles cp" multiple>
                  <div class="fileicon fico">
                    <i id="fiicon" class="bi bi-arrow-up-circle"></i>
                    <span id="fispan"> Buscar archivos</span>
                  </div>
                </div>
              </div>

              <hr class="hdivisor"> 
        
              <div class="DivTable">
                <ul class="sidebar-nav" id="sidebar-nav">
                  <li class="nav-item mt-1">
                    <a class="nav-link b1 collapsed" data-bs-target="#divnotifi" data-bs-toggle="collapse" aria-expanded="false">
                      <span id="spannotif" class="center w-100">Notificaciones Agregadas</span>
                      <i class="bi bi-chevron-down ms-auto"></i>
                    </a>

                    <div id="divnotifi" class="collapse w-100">
                      <table id="tablenotif" class="table mb-0 text-center"> 
                        <colgroup>
                          <col style="width: 33%;">
                          <col style="width: 33%;">
                          <col style="width: 33%;">
                        </colgroup>

                        <thead>
                          <tr>
                            <th>Numero</th> 
                            <th>Tipo</th> 
                            <th>Impuesto</th>
                          </tr>
                        </thead>
      
                        <tbody id="tablanotif" style="user-select:text;"></tbody>
                      </table>
                    </div>
                  </li>
                </ul>
              </div>
  
              <hr class="hdivisor">

              <div class="col-sm-6">
                <label for="Notfic" class="form-label">Numero Notificación</label>
                <input type="text" class="form-control" id="Notfic" autocomplete="off" maxlength="30">
              </div>
          
              <div class="col-sm-6">
                <label for="Tiponotf" class="form-label">Tipo Notificación</label>  

                <select id="Tiponotf" class="form-select">
                  <option value=""></option>
                  <option value="FISCALIZACION">Fiscalizaci&oacute;n</option>
                  <option value="CONTROL">Control</option>
                  <option value="DEBERES FORMALES">Deberes formales</option>
                </select>
              </div>   

              <div id="Incumplimientos" class="row g-3" style="display: contents;">  
                <div class="col-sm-6">
                  <label for="Motnotif" class="form-label">Motivo Notif</label>
                  <input type="text" class="form-control" id="Motnotif">
                </div>
          
                <div class="col-sm-6">
                  <label label for="Aincu" class="form-label">Año incumplimiento </label>
                  <input type="text" class="form-control" id="Aincu" maxlength="4">
                </div>
              </div>

              <div class="d-inline-flex gap-1">
                <button type="button" class="btn btn-secondary w-100" onclick="addinc()">
                  <i class="bi bi-file-plus"></i> Añadir incumplimiento
                </button>

                <button type="button" class="btn btn-secondary w-100" onclick="dltinc()">
                  <i class="bi bi-trash"></i> Eliminar incumplimiento
                </button>
              </div>

              <hr class="hdivisor">      
  
              <div class="d-inline-flex gap-1">
                <button type="button" class="btn btn-primary w-100" onclick="addnotificacion(document.getElementById('Notfic').value,document.getElementById('Tiponotf').value)">
                  <i class="bi bi-floppy"></i> Guardar inconsistencia
                </button>
          
                <button type="button" class="btn btn-warning w-100" onclick="dropnotificacion()">
                  <i class="bi bi-trash"></i> Eliminar inconsistencia
                </button=>
              </div>

            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" class="btn btn-success" onclick="agrnotif(document.getElementById('cltagrnot1').value,document.getElementById('Datenotf').value,document.getElementById('Cartanotif').files,document.getElementById('Notfic').value,document.getElementById('Tiponotf').value,document.getElementById('Motnotif').value,document.getElementById('Aincu').value)">
          <i class="bi bi-floppy"></i> Crear
        </button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closenotif()">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!----------------FIN AGREGAR NOTIFICACION------------------------------->


<!----------------------- MODAL ELIMINAR NOTIFICACION -------------------->
<div class="modal fade" id="dltnot" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Eliminar una notificación</h3>
          <hr class="hdivisor mb-2">
        </div>

        <div class="container">
          <div class="col-lg-12 SMData">  
            <form id="formdltnotif">
              <label for="slcdltnotif" class="form-label labeledtmdf">Seleccione el codigo de la notificación</label>  
              <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltnotif" placeholder="">
              <input type="hidden" id="slcdltnotif1" name="slcdltnotif1">

              <datalist id="dtldltnot" role="listbox" class="w-100">
                <?php $DataNotif = Datos(4);
                  if ($DataNotif !== false && count($DataNotif) > 0) 
                  {
                    foreach ($DataNotif as $notifs)
                    { 
                      echo '<option value="' . htmlspecialchars($notifs["IDNotificacion"]) . '">' . htmlspecialchars($notifs["Notificacion"]) . '</option>'; 
                    }
                  } 
                ?>
              </datalist>   
            </form>
          </div>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button id="btndltnotif" type="button" class="btn btn-success" style="display:none;" onclick="dltnotif(document.getElementById('slcdltnotif1').value,document.getElementById('slcdltnotif').value)">
          <i class="bi bi-trash"></i>Eliminar
        </button>
        
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltnotif1',['#dtldltnot','#btndltnotif'],'#formdltnotif')">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!----------------FIN ELIMINAR NOTIFICACION-------------------------------> <?php }