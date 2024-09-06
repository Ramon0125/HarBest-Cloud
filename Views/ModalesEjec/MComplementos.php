<?php

if (preg_match('/MComplementos(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{
    http_response_code(404);    die(header('Location: ./404'));
} 

else { ?><!---- Seccion agregar prorrogas --------->
<div class="modal fade" id="agrprorrogas" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ModalTitle">
                    <h3 class="modal-title">Agregar una prorroga</h3>
                    <hr class="hdivisor mb-2">
                </div>

                <div class="col-lg-12 SMData">
                    <label for="slcntfprg" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>
                    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcntfprg">
                    <input type="hidden" id="slcntfprg1">
                    <datalist id="dtlagrprg" role="listbox">
                        <?php $DataProrroga = Datos(11);
                            if ($DataProrroga !== false && count($DataProrroga) > 0) 
                            {
                                foreach ($DataProrroga as $DATAPRG) 
                                { 
                                    echo '<option value="' . htmlspecialchars($DATAPRG["CodigoNotif"]) . '">' . htmlspecialchars($DATAPRG["CodigoNotif"]) . '</option>'; 
                                }
                            }
                        ?>
                    </datalist>
                </div>

                    <div class="row g-3 mt-0" id="Containeragrprg" style="display: none;">
                        <hr class="hdivisor">

                        <div class="col-sm-6">
                            <label for="dateprg" class="form-label labeledtmdf">Fecha prorroga</label>
                            <input type="DATE" class="form-control" id="dateprg">
                        </div>

                        <div class="col-sm-6 cp">
                            <label for="Fileprg" id="labelFileprg" class="form-label">Archivo de prorroga</label>
          
                            <div class="form-control cartadiv">
                                <input type="file" id="Fileprg" class="cartafiles cp" multiple>
            
                                <div class="fileicon fico1">
                                    <i id="fiiconprg" class="bi bi-arrow-up-circle"></i>
                                    <span id="Spanprg"> Buscar archivos</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="Comentsprg" class="form-label labeledtmdf">Comentarios</label>
                            <textarea rows="4" class="form-control" id="Comentsprg"></textarea>
                        </div>

                    </div>
                
                </div>

                <div class="modal-footer mfooter">

                    <button type="button" class="btn btn-success" id="btnagrprg" style="display:none;">
                    <i class="bi bi-floppy"></i>&nbsp;Crear
                    </button>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

                </div>

        </div></div>
    </div>
    <!----Fin Seccion agregar prorrogas --------->


    <!---- Seccion enviar prorrogas --------->
<div class="modal fade" id="sendprorrogas" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ModalTitle">
                    <h3 class="modal-title">Enviar una prorroga</h3>
                    <hr class="hdivisor mb-2">
                </div>

                <div class="col-lg-12 SMData">
                    <label for="slcsendprg" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>
                    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcsendprg">
                    <input type="hidden" id="slcsendprg1">
                    <datalist id="dtlsendprg" role="listbox">
                        <?php $SendProrroga = Datos(12);
                            if ($SendProrroga !== false && count($SendProrroga) > 0) 
                            {
                                foreach ($SendProrroga as $SENDPRG) 
                                { 
                                    echo '<option value="' . htmlspecialchars($SENDPRG["IDProrroga"]) . '">' . htmlspecialchars($SENDPRG["CodigoNotif"]) . '</option>'; 
                                }
                            }
                        ?>
                    </datalist>
                </div>     
            </div>

            <div class="modal-footer mfooter">
                <button type="button" class="btn btn-success" id="btnsendprg" style="display:none;">
                <i class="bi bi-floppy"></i>&nbsp;Crear
                </button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            </div>

        </div></div>
    </div>
    <!----Fin Seccion enviar prorrogas --------->
<?php }
