//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){ tablasejec('notif'); });


function tablasejec(str) 
{
    $.ajax({
    type: 'GET',//Metodo en el que se enviaran los datos
    url: '../Controllers/Tables.php',//Direccion a la que se enviaran los datos
    data: {tabla: str},//Datos que seran enviados
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (data) {
    data.error ? responses(data) : tablesresult(str,data);},
    error: function () {Alerta(txt.EELS, "error", 2000);}});   
}

function tablesresult(str,data){

  $('#tabla').DataTable().destroy();
  $('#tabla').html(data);

  switch (str) {

    case 'detalles': 
      $('#tabla thead tr').append('<th>INCONSISTENCIAS</th>'); // Agregar encabezado para el otro botón
      $('#tabla thead tr').append('<th>ARCHIVOS</th>');
    
      $('#tabla').DataTable($.extend(true, {}, tabledata, {
      "order": [],
      "columnDefs": [
      {
      "targets": 9, 
      "orderable": false,
      "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnverddc' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Abrir archivos</button>"
      },
      {
      "targets": 8, 
      "data": null,
      "orderable": false,
      "defaultContent": "<button type='button' class='btn btn-success btnverinc' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Ver inconsistencias</button>"
      },
      {
        "targets": 7,
        "orderable": false,
        "render": function (data, type, row) {
        if (row[7] != 'T') {
        return '<button type="button" class="btn btn-success btnenviar" style="background-color:green; height: 31px; --bs-btn-padding-y: 0px; margin-left: -10px;">Enviar</button>';
        } 
        else { return '<i class="bi bi-check2-circle center"></i>'; }}}]
      }));
      $('#tabla tbody').on('click', '.btnverddc', function() 
      {vddc($(this).closest('tr').find('td:eq(0)').text())});
    
      $('#tabla tbody').on('click', '.btnverinc', function() 
      {vincon($(this).closest('tr').find('td:eq(0)').text())});

      $('#tabla tbody').on('click', '.btnenviar', function() 
      {sendmailddc($(this).closest('tr').find('td:eq(0)').text())});
    break;


    case 'notif':
      $('#tabla thead tr').append('<th>CARTA</th>');
      
      $('#tabla').DataTable($.extend(true, {}, tabledata, {
      "order": [],
      "columnDefs": [
      {"targets": -1, 
      "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnvercarta' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Ver carta</button>"
      },
      { 
      "targets": 6,
      "orderable": false,
      "render": function (data, type, row) {
      if (row[6] != 'T') {
      return '<button type="button" class="btn btn-success btnenviarntf" style="background-color:green; height: 31px; --bs-btn-padding-y: 0px;">Enviar</button>';
      }
      else {return '<i class="bi bi-check2-circle center"></i>';}}
      }]
      }));

      $('#tabla tbody tr').on('click', function (event) 
      {
        const Boton = event.target.classList;

        if(Boton.contains('btn')){

        let ID = $(this).find('td:eq(0)').text().trim();

        Boton[2] === 'btnenviarntf' ? sendmail(ID) : vcarta(ID);}
      });

    break;

    }
}


eventlisten('.fico','click',function (){ 
  
  if ($('#fiicon').hasClass('bi-x-circle')) 
  { 
    $('#Cartanotif').val('');
    $('#labelcartanotif').text(`Archivos de la notificación - ${(Cartanotif.files.length)} añadidos`)
    $('#fispan').text(' Buscar archivos');
    $('#fiicon').removeClass('bi-x-circle');
    $('#fiicon').addClass('bi-arrow-up-circle');
  }

  else { $('#Cartanotif').click(); } 
  
});


eventlisten('#Cartanotif','change',function ()
{
  $('#fispan').text(' Quitar archivos' );
  $('#fiicon').removeClass('bi-arrow-up-circle');
  $('#fiicon').addClass('bi-x-circle');
  $('#labelcartanotif').text(`Archivos de la notificación - ${(Cartanotif.files.length)} añadidos`)

});


eventlisten('.fico1','click',function (){ 
  
    if ($('#fiiconddc').hasClass('bi-x-circle')) 
    { 
      $('#archivosddc').val('');
      $('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);
      $('#fispanddc').text(' Buscar archivos');
      $('#fiiconddc').removeClass('bi-x-circle');
      $('#fiiconddc').addClass('bi-arrow-up-circle');
    }
  
    else { $('#archivosddc').click(); } 
    
});
  
  
eventlisten('#archivosddc','change',function (){

  $('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);    
  $('#fispanddc').text(' Quitar archivos' );
  $('#fiiconddc').removeClass('bi-arrow-up-circle');
  $('#fiiconddc').addClass('bi-x-circle');

});