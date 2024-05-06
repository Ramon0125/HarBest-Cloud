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
    success: function (data) 
    {tablesresult(str,data)},
    error: function () {res(txt.EELS, "error", 2000);}});   
}

function tablesresult(str,data){

  $('#tabla').DataTable().destroy();
  $('#tabla').html(data);

  switch (str) {
    case 'notif':
      $('#tabla thead tr').append('<th>CARTA</th>');
      

      $('#tabla').DataTable($.extend(true, {}, tabledata, {"columnDefs": [
      {"targets": -1, "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnvercarta' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Ver carta</button>"
      }]}));
      
      $('#tabla tbody').on('click', '.btnvercarta', function() 
      {let ID = $(this).closest('tr').find('td:eq(0)').text();
      vcarta(ID); });
      break;
  
      case 'email_notif':
          $('#tabla thead tr').append('<th></th>');
      
          $('#tabla').DataTable($.extend(true, {}, tabledata, {
            "order": [],
              "columnDefs": [{
                  "targets": -1,
                  "orderable": false,
                  "data": null,
                  "render": function (data, type, row) {
                      if (row[6] != 'CORREO ENVIADO') {
                          return '<button type="button" class="btn btn-success btnenviar" style="background-color:green; height: 31px; --bs-btn-padding-y: 0px;">Enviar</button>';
                      } else {
                          return '<i class="bi bi-check2-circle" style="Dmargin-left: -10%;"></i>';
                      }
                  }
              }]
          }));
      
          $('#tabla tbody').on('click', '.btnenviar', function() 
          {let NOTIF = $(this).closest('tr').find('td:eq(0)').text();
          sendmail(NOTIF); });
        break;
    }
}



eventlisten('.fico','click',function (){ 
  
  if ($('#fiicon').hasClass('bi-x-circle')) 
  { 
    $('#Cartanotif').val('');
    $('#fispan').text(' Buscar carta');
    $('#fiicon').removeClass('bi-x-circle');
    $('#fiicon').addClass('bi-arrow-up-circle');
  }

  else { $('#Cartanotif').click(); } 
  
});


eventlisten('#Cartanotif','change',function (){

  $('#fispan').text(' Quitar carta' );
  $('#fiicon').removeClass('bi-arrow-up-circle');
  $('#fiicon').addClass('bi-x-circle');

  });
