//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){tablas('usrs');});

function datausrblocks()
{
    $('table').addClass('tcu');
    $('#tabla thead tr').append('<th>ACCIONES</th>');
  
    $('#tabla').DataTable($.extend(true, {}, tabledata, {"columnDefs": [
    {"targets": -1, 
    "data": null,
    "defaultContent": "<button type='button' class='btn btn-success btnusrbloc' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Desbloquear</button>"
    }]}));
  
    $('#tabla tbody').on('click', '.btnusrbloc', function() {
    let ID = $(this).closest('tr').find('td:eq(0)').text(); // Valor de la primera columna
    desusr(ID);
  });
}


function tablas(str) 
{
  $.ajax({
  type: 'GET',//Metodo en el que se enviaran los datos
  url: '../Controllers/Tables.php',//Direccion a la que se enviaran los datos
  data: {tabla: str},//Datos que seran enviados
  beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
  complete: function () { load(2); }, //Ocultar pantalla de carga
  success: function (data) {
  data.error ? responses(data) : tables(data,str);},
  error: function () {res(txt.EELS, "error", 2000);}});   
}


function tables(respuesta,str) 
{
$('#tabla').DataTable().destroy();
$('#tabla').html(respuesta);

if (str === 'usrblocks') { datausrblocks(); }

else 
{ 
  $('table').removeClass('tcu');      
  
  $('#tabla').DataTable($.extend(true, {}, tabledata, {"autoWidth": false  })); 
}
}