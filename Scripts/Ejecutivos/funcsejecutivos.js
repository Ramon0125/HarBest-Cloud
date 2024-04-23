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
    {
      $('#tabla').DataTable().destroy();
      $('#tabla').html(data);
      $('#tabla thead tr').append('<th>CARTAS</th>');
      

      $('#tabla').DataTable($.extend(true, {}, tabledata, {"columnDefs": [
      {"targets": -1, "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnvercarta' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Ver carta</button>"
      }]}));
      
      $('#tabla tbody').on('click', '.btnvercarta', function() 
      {var ID = $(this).closest('tr').find('td:eq(0)').text();
      vcarta(ID); });
    },
    error: function () {res(txt.EELS, "error", 2000);}});   
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