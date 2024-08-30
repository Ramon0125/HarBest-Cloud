<?php

if (preg_match('/Mclientes(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

else { ?><!-----------------MODAL AGREGAR CLIENTES--------------------->
<div class="modal fade" id="agrclt" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Agregar un nuevo cliente</h3>
          <hr class="hdivisor mb-2">
        </div>
        
        <form id="formagrclt" class="row g-3">
          <div class="col-sm-6">
            <label for="rncagrclt" class="form-label">RNC</label>
            <input type="text" class="form-control" id="rncagrclt" autocomplete="off" maxlength="11">
          </div>
              
          <div class="col-sm-6">
            <label for="emailagrclt" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailagrclt" autocomplete="off" maxlength="100">
          </div>
              
          <div class="col-sm-6">
            <label for="nameagrclt" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nameagrclt" autocomplete="off" maxlength="100">
          </div>
              
          <div class="col-sm-6 SMData">
            <label for="admclt" class="form-label">Administración</label>
            <input class="form-control" autocomplete="off" role="combobox" list="" id="admclt">
            <input type="hidden" id="admclt1">
                
            <datalist id="browseradmclt" role="listbox" class="dtl2">
              <?php $adms = Datos(3); // Obtener usuarios
                if ($adms !== false && count($adms) > 0) 
                {
                  foreach ($adms as $adm)
                  {
                    echo '<option value="' . htmlspecialchars($adm["IDADM"]) . '">' . htmlspecialchars($adm["NombreADM"]) . '</option>'; 
                  }
                } 
              ?>
            </datalist>
          </div>

          <div class="col-lg-12 center">
            <span>Tipo de persona:</span>&nbsp;

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="Tipclt">Fisica&nbsp;</label>
              <input class="form-check-input" type="radio" name="Tipclt" id="Tipclt" value="Fisica">
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="Tipclt1">Juridica</label>
              <input class="form-check-input" type="radio" name="Tipclt" id="Tipclt1" value="Juridica">
            </div>
          </div>
        </form>
      </div>
      
      <div class="modal-footer mfooter">
        <button type="button" class="btn btn-success" onclick="agrclt(document.getElementById('rncagrclt').value, document.getElementById('emailagrclt').value, document.getElementById('nameagrclt').value, document.getElementById('Tipclt'), document.getElementById('Tipclt1'), document.getElementById('admclt1').value)"><i class="bi bi-floppy"></i> Agregar</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#admclt1', false, '#formagrclt')">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!---------------FIN MODAL AGREGAR CLIENTES------------------->


<!-----------------MODAL EDITAR CLIENTES--------------------->
<div class="modal fade" id="edtclt" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Editar un cliente</h3>
          <hr class="hdivisor mb-2">
        </div>

        <div class="col-lg-12 SMData">
          <form id="formedtclt">
            <label for="slcclt" class="form-label labeledtmdf">Seleccione el cliente</label>
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcclt">
            <input type="hidden" id="slcclt1">
                
            <datalist id="browseredtclt" role="listbox">
              <?php $clientes = Datos(2); // Obtener clientes
                if ($clientes !== false && count($clientes) > 0) 
                {
                  foreach ($clientes as $cliente)
                  {
                    echo '<option value="' . htmlspecialchars($cliente["IDCliente"]) . '">' . htmlspecialchars($cliente["NombreCliente"]) . '</option>'; 
                  }
                } 
              ?>
            </datalist>
          </form>
        </div>

        <div class="row g-3 mt-0" style="display: none;" id="formedtclt1">
          <hr class="hdivisor">

          <div class="col-sm-6">
            <label for="rncedtclt" class="form-label">RNC</label>
            <input type="text" class="form-control" id="rncedtclt" autocomplete="off" maxlength="11">
          </div>

          <div class="col-sm-6">
            <label for="edtcltemail" class="form-label">Email</label>
            <input type="text" class="form-control" id="edtcltemail" autocomplete="off" maxlength="100">
          </div>

          <div class="col-sm-6">
            <label for="edtcltname" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="edtcltname" autocomplete="off" maxlength="100">
          </div>

          <div class="col-sm-6">
            <label for="admedtclt" class="form-label">Administración</label>
            <input class="form-control" autocomplete="off" role="combobox" list="" id="admedtclt">
            <input type="hidden" id="admedtclt1">

            <datalist id="browseradmedtclt" role="listbox">
              <?php $adms = Datos(3); // Obtener usuarios
                if ($adms !== false && count($adms) > 0) 
                {
                  foreach ($adms as $adm)
                  { 
                    echo '<option value="' . htmlspecialchars($adm["IDADM"]) . '">' . htmlspecialchars($adm["NombreADM"]) . '</option>';
                  }
                } 
              ?>
            </datalist>
          </div>

          <div class="col-lg-12 center">
            <span>Tipo de persona:</span>&nbsp;

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="Tipedtclt">Fisica&nbsp;</label>
              <input class="form-check-input" type="radio" name="Tipedtclt" id="Tipedtclt" value="Fisica">
            </div>&nbsp;&nbsp;&nbsp;

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="Tipedtclt1">Juridica</label>
              <input class="form-check-input" type="radio" name="Tipedtclt" id="Tipedtclt1" value="Juridica">
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" id="btnedtclt" class="btn btn-success" style="display: none;" onclick="edtclt(document.getElementById('slcclt1').value, document.getElementById('slcclt').value, document.getElementById('rncedtclt').value, document.getElementById('edtcltemail').value, document.getElementById('edtcltname').value, document.getElementById('Tipedtclt'), document.getElementById('Tipedtclt1'), document.getElementById('admedtclt1').value)">
          <i class="bi bi-pencil"></i>&nbsp;Confirmar
        </button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#slcclt1','#admedtclt1'],['#browseredtclt','#formedtclt1','#btnedtclt'],['#formedtclt','#formedtclt11'])">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!---------------FIN MODAL EDITAR CLIENTES------------------->


<!-----------------MODAL ELIMINAR CLIENTES--------------------->
<div class="modal fade" id="dltclt" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Eliminar un cliente</h3>
          <hr class="hdivisor mb-2">
        </div>

        <div class="col-lg-12 SMData">
          <form id="formdltclt">
            <label for="slcdltclt" class="form-label labeledtmdf"> Seleccione el cliente</label>  
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltclt">
            <input type="hidden" id="slcdltclt1">

            <datalist id="browserdltclt" role="listbox">
              <?php $cliente1 = Datos(2); // Obtener clientes
                if ($cliente1 !== false && count($cliente1) > 0) 
                {
                  foreach ($cliente1 as $clientes1)
                  {
                    echo '<option value="' . htmlspecialchars($clientes1["IDCliente"]) . '">' . htmlspecialchars($clientes1["NombreCliente"]) . '</option>';
                  }
                } 
              ?>
            </datalist>
          </form>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" id="btndltclt" class="btn btn-success" style="display:none" onclick="dltclt(document.getElementById('slcdltclt1').value,document.getElementById('slcdltclt').value)">
          <i class="bi bi-trash"></i>&nbsp;Confirmar
        </button>
        
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltclt1',['#browserdltclt','#btndltclt'],'#formdltclt')">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!---------------FIN MODAL ELIMINAR IENTES-------------------><?php  } 
