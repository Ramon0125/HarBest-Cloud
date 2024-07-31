<?php 

if (strpos($_SERVER['REQUEST_URI'], 'MDetalleCompleto.php') !== false) { header('LOCATION: ./404'); }?>


<div class="modal fade" id="DetailNotif" data-bs-backdrop="static" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content" style="transform: translate(-50%, 0%); width: 159%; left: 50%;">

    <div class="modal-body">

     <div class="ModalTitle">
         <h3 class="modal-title fb"> 
           Caso: <span id="TitleNotifDC"></span>  
         </h3>
         <hr class="my-4 Divisor">
     </div>

     <form id="formagrnotif">
      
        <div class="row g-3 " style="text-align: center; overflow-y: auto;">

         <div class="col-sm-4">
          <span>Cliente: </span>
          <span id="NombreCLienteDC" class="fb"></span> 
         </div>

         <div class="col-sm-4">
          <span>Email: </span>
          <span id="EmailCLienteDC" class="fb"></span> 
         </div>

         <div class="col-sm-4">
          <span>Administracion: </span>
          <span id="AdmCLienteDC" class="fb"></span> 
         </div>
    
         <hr class="Divisor" style="margin-bottom: 1%;">   
         
         <div class="class-lg-12">
          <span class="center fb">Notificacion de inconsistencia</span>
        </div>

         <div class="col-sm-6">
          <span>Fecha Notificación: </span>
          <span id="FechaNotifDC" class="fb"></span> 
         </div>

         <div class="col-sm-6">
          <span>Fecha Vencimiento: </span>
          <span id="FechaVenciNotifDC" class="fb"></span> 
         </div>
    
         <div class="col-sm-6">
          <span>Cartas Notificación: </span>
          <a id="ArchivosNotifDC" class="fb cp"><i class="bi bi-folder2-open"></i> Abrir archivos</a> 
         </div>

         <div class="col-sm-6">
          <span>Correo Notificación: </span>
          <a id="EstadoEmailNotifDC" class="fb"></a> 
         </div>
        
         <div class="DivTable">
          <ul class="sidebar-nav" id="sidebar-nav" style="width: 100%; margin-bottom: 0%;">
          <li class="nav-item" style="margin-top: 1%;">

          <a class="nav-link b1 collapsed" style="padding: 8px 0px;" data-bs-target="#divnotifi" data-bs-toggle="collapse" aria-expanded="false">
           <span id="spannotif" style="display: flex; width:88%; justify-content:center; position: absolute;">Notificaciones de inconsistencia</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>

          <div id="divnotifi" class="collapse" style="width: 100%;">
            <table class="table" style="width: 100%; overflow:auto; text-align:center; margin-bottom: 0%;"> 
             <colgroup>
              <col style="width: 33%;">
              <col style="width: 33%;">
              <col style="width: 33%;">
             </colgroup>

             <thead>
              <tr><th>Numero</th> <th>Tipo</th> <th>Impuesto</th></tr>
             </thead>
      
             <tbody id="tablanotifDC" style="user-select:text;"></tbody>
            </table>
          </div>

          </li>
          </ul>
         </div>
        </div>


         <!---------- FIN NOTIF ------------------>


         <div class="row g-3 " id="ContainerDetalleDC" style="display: none; text-align: center;">
         

         <hr class="Divisor" style="margin-bottom: 0%; margin-top: 6%;">

         <div class="class-lg-12">
          <span class="center fb">Detalle de citaciòn</span>
        </div>

         <div class="col-sm-6">
          <span>Fecha Detalle: </span>
          <span id="FechaDetalleDC" class="fb"></span> 
         </div>

         <div class="col-sm-6">
          <span>Fecha Vencimiento: </span>
          <span id="FechaVenciDC" class="fb"></span> 
         </div>
    
         <div class="col-sm-6">
          <span>Archivos Detalle: </span>
          <a id="ArchivosDC" class="fb cp"><i class="bi bi-folder2-open"></i> Abrir archivos</a> 
         </div>

         <div class="col-sm-6">
          <span>Correo Detalle: </span>
          <a id="EstadoEmailDetalleDC" class="fb">
          </a> 
         </div>
        
         <div class="DivTable">
  <ul class="sidebar-nav" id="sidebar-nav" style="width: 100%; margin-bottom: 0%;">
   <li class="nav-item" style="margin-top: 1%;">

  <a class="nav-link b1 collapsed" style="padding: 8px 0px;" data-bs-target="#divdetalle" data-bs-toggle="collapse" aria-expanded="false">
  <span id="spandetalle" class="center" style="width:100%;">Inconsistencias detalladas</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <div id="divdetalle" class="collapse" style="width: 100%;">
    <table class="table table-hover" style="width: 100%; table-layout: fixed; text-align:center; margin-bottom: 0%;"> 
    
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

      <tbody class="table-group-divider" id="tabladetallesDC" style="user-select:text;">

      </tbody>
    </table>
  </div>

    </li>
  </ul>
</div>

         </div>   

                  <!---------- FIN ESCRITO ------------------>

         <div class="row g-3 " id="ContainerEscritoDC" style="display:none; text-align: center;">
         

         <hr class="Divisor" style="margin-bottom: 0%; margin-top: 6%;">

         <div class="class-lg-12">
          <span class="center fb">Escrito de descargo</span>
        </div>

         <div class="col-sm-6">
          <span>Fecha Escrito: </span>
          <span id="FechaEscritoDC" class="fb"></span> 
         </div>

         <div class="col-sm-6">
          <span>Fecha Vencimiento: </span>
          <span id="FechaVenciEscritoDC" class="fb"></span> 
         </div>
    
         <div class="col-sm-6">
          <span>Escrito Descargo: </span>
          <a id="ArchivosEscritoDC" class="fb cp"><i class="bi bi-folder2-open"></i> Abrir archivos</a> 
         </div>

         <div class="col-sm-6">
          <span>Correo Escrito: </span>
          <a id="EstadoEmailEscritoDC" class="fb">
          </a> 
         </div>
        
         <hr class="Divisor" style="margin-bottom: -3%;">   
         </div>   


</form></div>
<div class="modal-footer justify-content-center">
<button type="button" class="btn btn-primary"  data-bs-dismiss="modal">Aceptar</button>
</div></div></div></div>