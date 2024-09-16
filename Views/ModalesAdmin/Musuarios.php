<?php

if (preg_match('/Musuarios(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

else { ?><!-----------------MODAL AGREGAR USUARIOS--------------------->
<div class="modal fade" id="agrusr" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Agregar un nuevo usuario</h3>
          <hr class="hdivisor mb-2">
        </div>

        <form id="formagrusr" class="row g-3">
          <div class="col-sm-6">
            <label for="privusr" class="form-label">Departamento</label>  
            
            <select id="privusr" class="form-select">
              <option value="" selected></option>
              <option value="CASOS FISCALES">CASOS FISCALES</option>
              <option value="CONSULTA">CONSULTA</option>
            </select>
          </div>
  
          <div class="col-sm-6">
            <label for="usremail" class="form-label">Email</label>
            <input type="email" class="form-control" id="usremail" autocomplete="off" maxlength="50">
          </div>

          <div class="col-sm-6">
            <label for="usrname" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="usrname" autocomplete="off" maxlength="20">
          </div>

          <div class="col-sm-6">
            <label for="usrlastname" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="usrlastname" autocomplete="off" maxlength="20">
          </div>
        </form>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" class="btn btn-success" onclick="agrusr(document.getElementById('privusr').value, document.getElementById('usremail').value, document.getElementById('usrname').value, document.getElementById('usrlastname').value)">
          <i class="bi bi-floppy"></i>&nbsp;Agregar
        </button>
        
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(false,false,'#formagrusr')">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!---------------FIN MODAL AGREGAR USUARIOS------------------->



<!-----------------MODAL EDITAR USUARIOS--------------------->
<div class="modal fade" id="edtusr" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Editar un usuario</h3>
          <hr class="hdivisor mb-2">
        </div>

        <div class="col-lg-12 SMData">
          <form id="formedtusr">
            <label for="slcuser" class="form-label labeledtmdf">Seleccione el usuario</label>  
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcuser">
            <input type="hidden" id="slcuser1">

            <datalist id="browser1" role="listbox">
              <?php $usuarios = Datos(1); // Obtener usuarios
                if ($usuarios !== false && count($usuarios) > 0) 
                {
                  foreach ($usuarios as $user)
                  {
                    echo '<option value="' . htmlspecialchars($user["IDUsuario"]) . '">' . htmlspecialchars($user["NOMBRE"]) . '</option>'; 
                  }
                } 
              ?>
            </datalist>
          </form>
        </div>

        <div class="row g-3 mt-0" style="display: none;" id="formedt">
          <hr class="hdivisor">

          <div class="col-sm-6">
            <label for="edtusremail" class="form-label">Email</label>
            <input type="text" class="form-control" id="edtusremail" autocomplete="off" maxlength="50">
          </div>
       
          <div class="col-sm-6">
            <label for="edtusrname" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="edtusrname" autocomplete="off" maxlength="20">
          </div>

          <div class="col-sm-6">
            <label for="edtusrlastname" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="edtusrlastname" autocomplete="off" maxlength="20">
          </div>

          <div class="col-sm-6">
            <label for="edtpassword" class="form-label">Contraseña</label>
            <input type="text" class="form-control" id="edtpassword" autocomplete="off" maxlength="15">
          </div>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" id="btnedtusr" class="btn btn-success" style="display:none;" onclick="edtusr(document.getElementById('slcuser1').value, document.getElementById('slcuser').value, document.getElementById('edtusremail').value, document.getElementById('edtusrname').value, document.getElementById('edtusrlastname').value, document.getElementById('edtpassword').value)">
          <i class="bi bi-pencil"></i>&nbsp;Confirmar
        </button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcuser1',['#browser1','#formedt','#btnedtusr'],['#formedtusr'])" >Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!---------------FIN MODAL EDITAR USUARIOS------------------->


<!-----------------MODAL ELIMINAR USUARIOS--------------------->
<div class="modal fade" id="dltusr" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ModalTitle">
          <h3 class="modal-title">Eliminar un usuario</h3>
          <hr class="hdivisor mb-2">
        </div>

        <div class="col-lg-12 SMData">
          <form id="formdltusr">
            <label for="slcdltuser" class="form-label labeledtmdf">Seleccione el usuario</label>  
            <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltuser">
            <input type="hidden" id="slcdltuser1">

            <datalist id="browserdltusr" role="listbox">
              <?php 
                if ($usuarios !== false && count($usuarios) > 0) 
                {
                  foreach ($usuarios as $user)
                  { 
                    echo '<option value="' . htmlspecialchars($user["IDUsuario"]) . '">' . htmlspecialchars($user["NOMBRE"]) . '</option>';
                  } 
                }
              ?>
            </datalist>
          </form>
        </div>
      </div>

      <div class="modal-footer mfooter">
        <button type="button" id="btndltusr" class="btn btn-success" style="display:none;" onclick="dltusr(document.getElementById('slcdltuser1').value,document.getElementById('slcdltuser').value)">
          <i class="bi bi-trash"></i>&nbsp;Confirmar
        </button>
        
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal('#slcdltuser1',['#browserdltusr','#btndltusr'],'#formdltusr')">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!---------------FIN MODAL ELIMINAR USUARIOS-------------------><?php  }