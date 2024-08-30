<?php

if (preg_match('/Musuarios(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{ http_response_code(404); die(header('Location: ./404')); } 

else { ?><!-----------------MODAL AGREGAR ADMINISTRACIÓN--------------------->
<div class="modal fade" id="agradm" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ModalTitle">
                    <h3 class="modal-title">Agregar una administración</h3>
                    <hr class="hdivisor mb-2">
                </div>

                <form id="formagradm" class="row g-3">
                    <div class="col-sm-6">
                        <label for="nadm" class="form-label">Escriba el nombre</label>
                        <input class="form-control" autocomplete="off" id="nadm">
                    </div>
                        
                    <div class="col-sm-6">
                        <label for="dadm" class="form-label">Escriba la dirección</label>
                        <input class="form-control" autocomplete="off" id="dadm">
                    </div>
                </form>
            </div>

            <div class="modal-footer mfooter">
                <button type="button" class="btn btn-success" onclick="agradm(document.getElementById('nadm').value,document.getElementById('dadm').value)">
                    <i class="bi bi-floppy"></i>&nbsp;Agregar
                </button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#nadm','#dadm'])">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!---------------FIN MODAL AGREGAR ADMINISTRACIÓN------------------->


<!-----------------MODAL EDITAR ADMINISTRACIÓN--------------------->
<div class="modal fade" id="edtadm" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ModalTitle">
                    <h3 class="modal-title">Editar una administración</h3=>
                    <hr class="hdivisor mb-2">
                </div>
                
                    <div class="col-lg-12 SMData">
                        <form id="formedtadm">
                            <label for="admedt" class="form-label labeledtmdf">Seleccione la administración</label>  
                            <input class="form-control" autocomplete="off" role="combobox" list="" id="admedt">
                            <input type="hidden" id="admedt1">
                            
                            <datalist id="Datalistagradm" role="listbox">
                                <?php $agradms = Datos(3); // Obtener usuarios
                                    if ($agradms !== false && count($agradms) > 0) 
                                    {
                                        foreach ($agradms as $agradms1)
                                        {
                                            echo '<option value="' . htmlspecialchars($agradms1["IDADM"]) . '">' . htmlspecialchars($agradms1["NombreADM"]) . '</option>';
                                        } 
                                    }
                                ?>
                            </datalist>
                        </form>
                    </div>

                    <div class="container" style="display: none;" id="formedtadm1">
                        <form id="formedtclt11" class="row g-3 mt-0">
                            <hr class="hdivisor">

                            <div class="col-sm-6">
                                <label for="admedtname" class="form-label">Nuevo nombre</label>
                                <input type="text" class="form-control" id="admedtname" autocomplete="off" maxlength="50">
                            </div>

                            <div class="col-sm-6">
                                <label for="admedtdirecc" class="form-label">Nueva dirección</label>
                                <input type="text" class="form-control" id="admedtdirecc" autocomplete="off" maxlength="100">
                            </div>
                        </form>
                    </div>

            </div>
            
            <div class="modal-footer mfooter">
                <button type="button" id="btnedtadm" class="btn btn-success" style="display:none" onclick="edtadm(document.getElementById('admedt1').value, document.getElementById('admedt').value, document.getElementById('admedtname').value, document.getElementById('admedtdirecc').value)">
                    <i class="bi bi-pencil"></i>&nbsp;Confirmar
                </button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#admedt1','#admedt','#admedtname','#admedtdirecc'],['#formedtadm1','#btnedtadm','#Datalistagradm'],['#formedtclt11','#formedtadm'])">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!---------------FIN MODAL EDITAR ADMINISTRACIÓN-------------------><?php  } 