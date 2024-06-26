//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){tablas('usrs');});

function datausrblocks()
{
    $('#tabla thead tr').append('<th>ACCIONES</th>');
  
    $('#tabla').DataTable($.extend(true, {}, tabledata, {"columnDefs": [
    {"targets": -1, 
    "data": null,
    "defaultContent": "<button type='button' class='btn btn-success btnusrbloc' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'>Desbloquear</button>"
    }]}));
  
    $('#tabla tbody').on('click', '.btnusrbloc', ()=> {
    desusr($(this).closest('tr').find('td:eq(0)').text());// Valor de la primera columna
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

  if(data.error){return responses(data);}

  $('#tabla').DataTable().destroy();
  $('#tabla').html(data);
  str === 'usrblocks' ? datausrblocks() :  $('#tabla').DataTable(tabledata); 
},
  error: function () {res(txt.EELS, txt.E, 2000);}});   
}

