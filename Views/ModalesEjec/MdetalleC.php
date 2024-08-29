<?php 

if (preg_match('/MdetalleC(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

else { ?> <!---- MODAL AGREGAR DETALLE DE CITACION --------->
<div class="modal fade" id="agrddc" data-bs-backdrop="static" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content" style="width: 125%;">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Agregar un detalle de citación</h3>
          <hr class="hdivisor mb-2">
        </div>
  
        <div class="col-lg-12 SMData">
          <form id="formagrddc1">
            <label for="slcntfddc" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>  
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfddc">
            <input type="hidden" id="slcntfddc1">

            <datalist id="dtlagrddc" role="listbox" class="dtl2">
              <?php $DataDC = Datos(5); // Obtener clientes
                if ($DataDC !== false && count($DataDC) > 0) 
                {
                  foreach ($DataDC as $DDC)
                  { 
                    echo '<option value="' . htmlspecialchars($DDC["CodigoNotif"]) . '">' . htmlspecialchars($DDC["CodigoNotif"]) . '</option>';
                  }
                } 
              ?>
            </datalist>
          </form>
        </div>

        <div style="display:none;" id="formDDC">
          <hr class="hdivisor mb-2">
      
          <form class="row g-3" id="formagrddc">
            <div div class="col-sm-6">
              <label for="fdddc" class="form-label">Fecha detalle</label>
              <input type="DATE" class="form-control" id="fdddc">
            </div>

            <div class="col-sm-6 cp">
              <label for="archivosddc" id="labelarchivosddc" class="form-label">Archivos de detalle</label>
          
              <div class="form-control cartadiv ">
                <input type="file" id="archivosddc" class="cartafiles cp" multiple>
            
                <div class="fileicon fico1">
                  <i id="fiiconddc" class="bi bi-arrow-up-circle"></i>
                  <span id="fispanddc"> Buscar archivos</span>
                </div>
              </div>
            </div>

            <hr class="hdivisor">
    
            <div class="DivTable">
              <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item mt-1">
                  <a class="nav-link b1 collapsed" data-bs-target="#divdetalle" data-bs-toggle="collapse" aria-expanded="false">
                    <span id="spandetalle" class="center w-100">Inconsistencias detalladas</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                  </a>

                  <div id="divdetalle" class="collapse w-100">
                    <table id="tabladetalle" class="table table-hover mb-0 text-center"> 
                      <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 41%;">
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                      </colgroup>

                      <thead>
                        <tr>
                          <th scope="col">Notificaciòn</th> 
                          <th scope="col">Inconsistencia</th>
                          <th scope="col">Periodo</th>
                          <th scope="col">Valor</th>
                          <th scope="col">Impuesto</th>
                        </tr>
                      </thead>

                      <tbody id="detalles" style="user-select:text;"></tbody>
                    </table>
                  </div>
                </li>
              </ul>
            </div>

            <hr class="hdivisor">

            <div class="col-sm-6">
              <label for="nontfddc" class="form-label labeledtmdf">Notificaciòn</label>
          
              <select class="form-select" id="nontfddc">
                <option value=""></option>
              </select>
            </div>

            <div class="col-sm-6">
              <label for="nocddc" class="form-label labeledtmdf">No. Caso</label>
              <input type="text" class="form-control" id="nocddc" autocomplete="off" maxlength="30">
            </div>

            <div class="col-lg-12">
              <label id="labelinconsisddc" for="inconsisddc" class="form-label labeledtmdf">Inconsistencia</label>
              <textarea rows="1" class="form-control" id="inconsisddc"></textarea>
            </div>

            <div class="col-sm-4">
              <label for="perddc" class="form-label">Periodo</label>
              <input type="text" class="form-control" id="perddc" name="perddc" autocomplete="off" maxlength="6">
            </div>

            <div class="col-sm-4">
              <label for="valddc" class="form-label">Valor</label>
              <input type="text" class="form-control" id="valddc" name="valddc" autocomplete="off">
            </div>

            <div class="col-sm-4">
              <label for="impddc" class="form-label">Impuesto Afectado</label>

              <select class="form-select" id="impddc" name="impddc">
                <option value=""></option>
                <option value="ITB">ITB</option>
                <option value="IR1">IR1</option>
                <option value="IR2">IR2</option>
              </select>
            </div>

            <div class="d-inline-flex gap-1">
              <button type="button" class="btn btn-primary w-100" onclick="adddetail(document.getElementById('nontfddc').value,document.getElementById('nocddc').value,document.getElementById('inconsisddc').value,document.getElementById('perddc').value,document.getElementById('valddc').value,document.getElementById('impddc').value)">Agregar</button>
              <button type="button" class="btn btn-warning w-100" onclick="dropdetails()">Eliminar ultimo detalle</button>
            </div>

            <hr class="hdivisor">

            <div class="d-inline-flex gap-1">
              <div class="col-sm-4">
                <label for="cdaddc" class="form-label">Correo del auditor</label>
                <input type="email" class="form-control" id="cdaddc" autocomplete="off" maxlength="30">
              </div>

              <div class="col-sm-4">
                <label for="ndaddc" class="form-label">Nombre del auditor</label>
                <input type="text" class="form-control" id="ndaddc" autocomplete="off" maxlength="30">
              </div>
          
              <div class="col-sm-4">
                <label for="telddc" class="form-label">Telefono del auditor</label>
                <input type="tel" class="form-control" id="telddc" autocomplete="off" maxlength="30">
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" class="btn btn-success" id="btnagrddc" style="display:none" onclick="addddc(document.getElementById('slcntfddc1').value,document.getElementById('fdddc').value,document.getElementById('archivosddc').files,document.getElementById('inconsisddc').value,document.getElementById('perddc').value,document.getElementById('valddc').value,document.getElementById('impddc').value,document.getElementById('cdaddc').value,document.getElementById('ndaddc').value,document.getElementById('telddc').value)">
          <i class="bi bi-floppy"></i> Crear
        </button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closedetails()">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!----------------FIN AGREGAR DETALLES------------------------------->


<!----------------------- MODAL ELIMINAR DETALLE DE CITACION -------------------->
<div class="modal fade" id="dltddc" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Eliminar un detalle de citación</h3>
          <hr class="hdivisor mb-2">
        </div>

        <div class="container">
          <div class="col-lg-12 SMData">
            <form id="formdltddc">
              <label for="slcdltddc" class="form-label labeledtmdf">Seleccione el codigo de notificaciòn</label>  
              <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltddc">
              <input type="hidden" id="slcdltddc1">
              <datalist id="dtldltddc" role="listbox" class="dtl2">
                <?php $ddc1 = Datos(6);
                  if ($ddc1 !== false && count($ddc1) > 0) 
                  {
                    foreach ($ddc1 as $ddc1s)
                    { 
                      echo '<option value="' . htmlspecialchars($ddc1s["IDDetalle"]) . '">' . htmlspecialchars($ddc1s["CodigoNotif"]) . '</option>'; 
                    }
                  } 
                ?>
              </datalist>
            </form>
          </div>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" id="btndltddc" class="btn btn-success" style="display:none;" onclick="dltddc(document.getElementById('slcdltddc1').value,document.getElementById('slcdltddc').value)">
          <i class="bi bi-trash"></i>Eliminar
        </button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc')">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!----------------FIN ELIMINAR DETALLES-------------------------------><?php }