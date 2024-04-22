

<!----------------------- MODAL EDITAR NOTIFICACION -------------------->
<div class="modal fade" id="edtnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Editar una notificación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div><div class="container"><main>
<form id="edtnotif" name="edtnotif" class="needs-validation" action="../Controllers/Sesion1.php" method="post" enctype="multipart/form-data">
<input type="hidden" value="edtnotific" id="edtnotific" name="edtnotific">
<div class="row g-5">
<div class="col-md-7 col-lg-12">


<div class="row g-3">
<div class="col-sm-6">
  <label for="slcnotif" class="form-label">Seleccione la notificacion</label>  
  <select id="slcnotif" name="slcnotif" class="form-select" style="height: 59% !important;" required>
  <option></option>
  <?php
  $sql1 = "SELECT notificacion FROM NOTIF_INCONSISTENCIA where IDEncargado = '".$_SESSION['ID']."'";
  $ejecucion1 = $conexion->prepare($sql1);
  $ejecucion1->execute();
  while ($ver = $ejecucion1->fetch(PDO::FETCH_ASSOC))
  {?>
  <option value="<?php echo $ver["notificacion"]; ?>"><?php echo $ver["notificacion"]; ?></option>
  <?php } ?>
  </select>
  </div>

  <script type="text/javascript">
  $(document).ready(function () {
  $('#slcnotif').select2({
  placeholder: " ",
  width: '100%',
  height: '59%',
  dropdownParent: $('#edtnot .modal-body')
  });});
  </script>
 
 <div class="col-sm-6">
  <label for="slccliente1" class="form-label">Seleccione el cliente</label>  
  <select id="slccliente1" name="slccliente1" class="form-select" style="height: 59% !important;" required>
  <option></option>
  <?php
  $sql1 = "SELECT RNC, NOMBRE_CLIENTE FROM CLIENTES";
  $ejecucion1 = $conexion->prepare($sql1);
  $ejecucion1->execute();
  while ($ver = $ejecucion1->fetch(PDO::FETCH_ASSOC))
  {?>
  <option value="<?php echo $ver["RNC"]; ?>"><?php echo $ver["NOMBRE_CLIENTE"]; ?></option>
  <?php } ?>
  </select>
  </div>

  <script type="text/javascript">
  $(document).ready(function () {
  $('#slccliente1').select2({
  placeholder: " ",
  width: '100%',
  height: '59%',
  dropdownParent: $('#edtnot .modal-body')
  });});
  </script>


<div class="row g-3">
  <div class="col-sm-6">
  <label for="Notfic1" class="form-label">Notificación</label>
  <input type="text" class="form-control" id="Notfic1" name="Notfic1" required autocomplete="off" maxlength="30">
  </div>


  <div class="col-sm-6">
  <label for="Datenotf" class="form-label">Fecha Notif.</label>
  <input type="DATE" class="form-control" id="Datenotf1" name="Datenotf1" required autocomplete="off">
  </div>  </div>

  <div class="row g-3">
  <div class="col-sm-6">
  <label for="Tiponotf1" class="form-label">Seleccione el tipo de notif.</label>  
  <select id="Tiponotf1" name="Tiponotf1" class="form-select" style="width: 100%;">
  <option disabled selected style="display:none;"></option>
  <option value="FISCALIZACION">Fiscalizaci&oacute;n</option>
  <option value="CONTROL">Control</option>
  <option value="DEBERES FORMALES">Deberes formales</option>
  </select>
  </div>

         
  <div class="col-md-6">
  <label for="incumpli1" class="form-label">Incumplimiento</label>
  <select class="form-select" id="incumpli1" name="incumpli1" required>
  <option disabled selected style="display:none;"></option>
  <option value="IR2">IR2</option>
  <option value="ITBIS">ITBIS</option>
  <option value="IR3">IR3</option>
  <option value="IR17">IR17</option>
  <option value="ACTIVO">ACTIVO</option>
  <option value="ANTICIPO">ANTICIPO</option>
  </select>
  </div>
  <div class=" justify-content-center">
  <label for="carta1" class="form-label">Seleccione la carta</label>
  <input class="form-control" type="file" id="carta1" name="carta1" accept=".pdf">
  </div></div></div></div></div></form>
</main>
</div></div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="modal-footer justify-content-center">
  <button type="button" class="btn btn-success" style="background-color:green" onclick="editnotifI(document.getElementById('slcnotif').value, document.getElementById('slccliente1').value, document.getElementById('Notfic1').value, document.getElementById('Datenotf1').value, document.getElementById('Tiponotf1').value, document.getElementById('incumpli1').value, document.getElementById('carta1').value)">Editar notif.</button>
  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="recargar()">Cancelar</button>
  </div></div></div></div>
<!----------------FIN EDITAR NOTIFICACION------------------------------->


<!----------------------- MODAL ELIMINAR NOTIFICACION -------------------->
<div class="modal fade" id="dltnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Eliminar una notificación</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">
<main>
<form id="dltnotif" name="dltnotifi" class="needs-validation" action="../Controllers/Sesion1.php" method="post" enctype="multipart/form-data">
<input type="hidden" value="dltnotif" id="dltnotif" name="dltnotif">
  
<div class="row g-3">
<div class="row">
    <div class="col-sm-6 mx-auto">
        <label for="slcnotific" class="form-label">Seleccione la notificacion</label>  
        <select id="slcnotific" name="slcnotific" class="form-select" style="height: 59% !important;" required>
            <option></option>
            <?php
            $sql1 = "SELECT notificacion FROM NOTIF_INCONSISTENCIA where IDEncargado = '".$_SESSION['ID']."'";
            $ejecucion1 = $conexion->prepare($sql1);
            $ejecucion1->execute();
            while ($ver = $ejecucion1->fetch(PDO::FETCH_ASSOC))
            {?>
                <option value="<?php echo $ver["notificacion"]; ?>"><?php echo $ver["notificacion"]; ?></option>
            <?php } ?>
        </select>
    </div>
</div>


  <script type="text/javascript">
  $(document).ready(function () {
  $('#slcnotific').select2({
  placeholder: " ",
  width: '100%',
  height: '59%',
  dropdownParent: $('#dltnot .modal-body')
  });});
  </script>
</div></form>
</main>
</div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="d-flex justify-content-center mx-auto">
    <button type="button" class="btn btn-success" style="background-color:green" onclick="dltnotifI(document.getElementById('slcnotific').value)">Eliminar notif.</button>
   &nbsp; <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="recargar()">Cancelar</button>
</div>
</div></div></div></div>
<!----------------FIN ELIMINAR NOTIFICACION------------------------------->


<!----------------------- MODAL CAMBIAR ESTADO -------------------->
<div class="modal fade" id="camnot" data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog"><div class="modal-content">
<div class="modal-body">
<div style="text-align: center; flex-direction: column; align-items: center; justify-content: center;">
<h3 style="color: #6f6e73;" class="modal-title"><strong>Cambiar estado de notificacion</strong></h3>
<hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
</div>
<div class="container">
<main>
<form id="fcamnotif" name="fcamnotif" class="needs-validation" action="../Controllers/Sesion1.php" method="post" enctype="multipart/form-data">
<input type="hidden" value="camnotifi" id="camnotifi" name="camnotifi">
  
<div class="row g-3">
    <div class="col-sm-6 ">
        <label for="slcnotifica" class="form-label">Seleccione la notificacion</label>  
        <select id="slcnotifica" name="slcnotifica" class="form-select" style="height: 59% !important;" required>
            <option></option>
            <?php
            $sql1 = "SELECT notificacion FROM NOTIF_INCONSISTENCIA where IDEncargado = '".$_SESSION['ID']."'";
            $ejecucion1 = $conexion->prepare($sql1);
            $ejecucion1->execute();
            while ($ver = $ejecucion1->fetch(PDO::FETCH_ASSOC))
            {?>
                <option value="<?php echo $ver["notificacion"]; ?>"><?php echo $ver["notificacion"]; ?></option>
            <?php } ?>
        </select>
    </div>

  <script type="text/javascript">
  $(document).ready(function () {
  $('#slcnotifica').select2({
  placeholder: " ",
  width: '100%',
  height: '59%',
  dropdownParent: $('#camnot .modal-body')
  });});
  </script>

<div class="col-sm-6">
  <label for="estad" class="form-label">Seleccione el estado</label>  
  <select id="estad" name="estad" class="form-select" style="width: 100%;">
  <option disabled selected style="display:none;"></option>
  <option value="COMPLETADA">COMPLETADA</option>
  <option value="NO APROBADA">NO APROBADA</option>
  </select>
  </div>
</div></form>
</main>
</div>
  <hr class="my-4" style="background-color: #53ce00 !important; color:#53ce00; height:4px;">
  <div class="d-flex justify-content-center mx-auto">
    <button type="button" class="btn btn-success" style="background-color:green" onclick="camnotif(document.getElementById('slcnotifica').value,document.getElementById('estad').value)">Cambiar estado</button>
   &nbsp; <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="recargar()">Cancelar</button>

  </div>
</div></div></div></div>
<!----------------FIN CAMBIAR NOTIFICACION------------------------------->

</body>   
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script></body>
</html>
