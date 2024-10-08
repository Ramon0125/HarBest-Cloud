<?php

if (preg_match('/Mprogrogas(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
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
                                <input type="file" id="Fileprg" class="cartafiles cp">
            
                                <div id="ContainerFileprg" class="fileicon">
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

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="CloseAddprg()">Cancelar</button>

                </div>

        </div></div>
    </div>
    <!----Fin Seccion agregar prorrogas --------->


    <!---- Seccion enviar prorrogas --------->
<div class="modal fade" id="sendprorrogas" data-bs-backdrop="static">
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
                        <?php $AllPRG = Datos(12);
                            if ($AllPRG !== false && count($AllPRG) > 0) 
                            {
                                foreach ($AllPRG as $SENDPRG) 
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

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#slcsendprg','#slcsendprg1'],'#btnsendprg',false)">Cancelar</button>
            </div>

        </div></div>
    </div>
    <!----Fin Seccion enviar prorrogas --------->


    <!---- Seccion eliminar prorrogas --------->
<div class="modal fade" id="dltprorrogas" data-bs-backdrop="static">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ModalTitle">
                    <h3 class="modal-title">Eliminar una prorroga</h3>
                    <hr class="hdivisor mb-2">
                </div>

                <div class="col-lg-12 SMData">
                    <label for="slcdltprg" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>
                    <input class="form-control" autocomplete="off" role="combobox" list="" id="slcdltprg">
                    <input type="hidden" id="slcdltprg1">
                    <datalist id="dtldltprg" role="listbox">
                        <?php 
                            if ($AllPRG !== false && count($AllPRG) > 0) 
                            {
                                foreach ($AllPRG as $DLTPRG) 
                                { 
                                    echo '<option value="' . htmlspecialchars($DLTPRG["IDProrroga"]) . '">' . htmlspecialchars($DLTPRG["CodigoNotif"]) . '</option>'; 
                                }
                            }
                        ?>
                    </datalist>
                </div>     
            </div>

            <div class="modal-footer mfooter">
                <button type="button" class="btn btn-warning" id="btndltprg" style="display:none;">
                <i class="bi bi-trash"></i>&nbsp;Eliminar
                </button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="LimpiarModal(['#slcdltprg','#slcdltprg'],['#btndltprg'],false)">Cancelar</button>
            </div>

        </div></div>
    </div>
    <!----Fin Seccion eliminar prorrogas --------->
<?php }
