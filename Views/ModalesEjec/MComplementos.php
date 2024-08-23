<?php

if (preg_match('/MComplementos(?:\.php)?/', $_SERVER['REQUEST_URI'])) 
{
    http_response_code(404);    die(header('Location: ./404'));
} 

else {

?>
    <!---- Seccion agregar prorrogas --------->
    <div class="modal fade" id="agrprorrogas" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog center"><div class="modal-content">

                <div class="modal-body">

                    <div class="ModalTitle">
                        <h3 class="modal-title"><strong>Agregar una prorroga</strong></h3>
                        <hr class="my-4 Divisor">
                    </div>

                    <div class="col-fluid col-lg-12">
                        <label for="slcntfprg" class="form-label labeledtmdf">Seleccione el codigo de la notificacion</label>
                        <input class="form-control MInput" autocomplete="off" role="combobox" list="" id="slcntfprg" name="slcntfprg">
                        <input type="hidden" id="slcntfprg1" name="slcntfprg1">
                        <datalist id="dtlagrprg" role="listbox">
                            <?php $DataProrroga = Datos(11);

                                if ($DataProrroga !== false && count($DataProrroga) > 0) 
                                {
                                    foreach ($DataProrroga as $DATAPRG) { ?>
                                        <option value="<?php echo $DATAPRG["CodigoNotif"]; ?>"><?php echo $DATAPRG["CodigoNotif"]; ?></option>
                                    <?php }
                                } 

                            ?>
                        </datalist>
                    </div>

                    <div class="row" id="Containeragrprg" style="display: none;">

                        <hr class="Divisor" style="margin-top: 2%; margin-bottom: 2%;">

                            <div class="col-lg-12 center" style="flex-direction:column; margin-bottom: 2%;">
                                <label for="dateprg" class="form-label labeledtmdf">Fecha prorroga</label>
                                <input type="DATE" class="form-control" id="dateprg" style="text-align: center;  width: 50%;">
                            </div>

                            <div class="col-sm-6">
                                <label for="Comentsprg" class="form-label labeledtmdf">Comentarios</label>
                                <textarea style="height: 81.9%;" class="form-control" id="Comentsprg"></textarea>
                            </div>

                            <div class="col-sm-6">
                                <label for="Fileprg" class="labeledtmdf">Archivo de prorroga</label>
                                <input type="file" id="Fileprg" hidden>

                                <div class="upload-container" id="ContainerPRG">

                                    <div class="border-container1 cp">

                                    <div class="center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383"/>
                                            <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                        </svg>
                                    </div>

                                    <p class="center">       
                                        <span><a id="Spanprg" style="color: var(--color);">Buscar</a> el archivo.</span>
                                    </p>

                                    </div>

                                </div>
                            </div>

                    </div>
                
                </div>

                <div class="modal-footer justify-content-center">

                    <button type="button" class="btn btn-success" id="btnagrprg" style="display:none;">
                    <i class="bi bi-floppy"></i>&nbsp;Crear
                    </button>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

                </div>

        </div></div>
    </div>
    <!----Fin Seccion agregar prorrogas --------->

<?php }
