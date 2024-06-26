<?php

if (strpos($_SERVER['REQUEST_URI'], 'Madms.php') === false) { ?>

<!-----------------MODAL AGREGAR ADMINISTRACIÓN--------------------->
<div class="modal fade" id="agradm" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ModalTitle">
                    <h3 class="modal-title"><strong>Agregar una administración</strong></h3>
                    <hr class="my-4 Divisor">
                </div>
                <div class="row g-3">
                    <form id="formagradm">
                        <div class="col-lg-12">
                            <label for="nadm" class="form-label">Escriba el nombre</label>
                            <input class="form-control" autocomplete="off" id="nadm" name="nadm" autofocus>
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <label for="dadm" class="form-label">Escriba la dirección</label>
                            <input class="form-control" autocomplete="off" id="dadm" name="dadm">
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 Divisor">
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" onclick="agradm(document.getElementById('nadm').value,document.getElementById('dadm').value)"><i class="bi bi-floppy"></i> Agregar</button>
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
                    <h3 style="color: #6f6e73;" class="modal-title"><strong>Editar una administración</strong></h3>
                    <hr class="my-4 Divisor">
                </div>
                <div class="row g-3">
                    <div class="col-fluid col-lg-12">
                        <form id="formedtadm">
                            <label for="admedt" class="form-label labeledtmdf">Administración</label>  
                            <input class="form-control" placeholder="Seleccione la administración" autocomplete="off" role="combobox" list="" id="admedt" name="admedt" autofocus>
                            <input type="hidden" id="admedt1" name="admedt1">
                            <datalist id="Datalistagradm" role="listbox">
                                <?php $agradms = Datos(3); // Obtener usuarios
                                if ($agradms !== false && count($agradms) > 0) {
                                    foreach ($agradms as $agradms1): ?>
                                    <option value="<?php echo $agradms1["IDADM"]; ?>"><?php echo $agradms1["NombreADM"]; ?></option>
                                    <?php endforeach; }?>
                            </datalist>
                        </form>
                    </div>
                    <div class="container" style="display: none;" id="formedtadm1">
                        <form id="formedtclt11">
                            <br>
                            <div class="row g-3">
                                <div class="col-fluid col-lg-12">
                                    <label for="admedtname" class="form-label">Nuevo nombre</label>
                                    <input type="text" class="form-control" id="admedtname" name="admedtname" autocomplete="off" maxlength="50">
                                </div>
                                <div class="col-fluid col-lg-12">
                                    <label for="admedtdirecc" class="form-label">Nueva dirección</label>
                                    <input type="text" class="form-control" id="admedtdirecc" name="admedtdirecc" autocomplete="off" maxlength="100">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="my-4 Divisor">
            <div class="modal-footer justify-content-center">
                <button type="button" id="btnedtadm" class="btn btn-success" style="display:none" onclick="edtadm(document.getElementById('admedt1').value, document.getElementById('admedt').value, document.getElementById('admedtname').value, document.getElementById('admedtdirecc').value)"><i class="bi bi-pencil"></i> Confirmar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#admedt1','#admedt','#admedtname','#admedtdirecc'],['#formedtadm1','#btnedtadm','#Datalistagradm'],['#formedtclt11','#formedtadm'])">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!---------------FIN MODAL EDITAR ADMINISTRACIÓN------------------->



<?php  } 

else {header('LOCATION: ./404');}