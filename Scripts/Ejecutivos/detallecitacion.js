
var incon = [];
var periodo = [];
var valor = [];

function adddetail(i,p,v) {

  if (validarparams(i,p,v)) {
    incon.push(i.trim());
    periodo.push(p.trim());
    valor.push(v.trim());

    updatedetalles();
  
    $('#spandetalle').text(`Detalles agregados${valor.length > 0 ? ': '+(valor.length) : ''}`);


    res(`${valor.length} detalles en total`,txt.S,false,true,'Detalle añadido');
    $('#inconsisddc').val(''); $('#periododdc').val(''); $('#valorddc').val('');

  }
  else {res(txt.CTC,txt.W,2000);} 

}

const dropdetails = () => { incon.pop(); periodo.pop(); valor.pop();

  updatedetalles();

  $('#spandetalle').text(`Detalles agregados${valor.length > 0 ? ': '+(valor.length) : ''}`);

  res(`${valor.length} detalles en total`,txt.S,false,true,'Ultimo detalle eliminado'); 

}


const updatedetalles = () => {

  let table = document.getElementById("detalles");

  while (table.firstChild) { table.removeChild(table.firstChild);
  }

  for (let i = 0; i < valor.length; i++) {
  let newRow = document.createElement("tr");

  let newCell = document.createElement("td");
  newCell.textContent = incon[i]; // Cambia el contenido según necesites
  newRow.appendChild(newCell);
  
  let newCell1 = document.createElement("td");
  newCell1.textContent = periodo[i]; // Cambia el contenido según necesites
  newRow.appendChild(newCell1);

  let newCell11 = document.createElement("td");
  newCell11.textContent = valor[i]; // Cambia el contenido según necesites
  newRow.appendChild(newCell11);

  table.appendChild(newRow);
  }
  
  // Insertar la nueva fila en la tabla

} 

function closedetails()
{
incon = []; periodo = []; valor = [];

updatedetalles();

$('#archivosddc').val('');
$('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);
$('#spandetalle').text(`Detalles agregados${valor.length > 0 ? ': '+(valor.length) : ''}`);
$('#fispanddc').text(' Buscar archivos');
$('#fiiconddc').removeClass('bi-x-circle');
$('#fiiconddc').addClass('bi-arrow-up-circle');

LimpiarModal('#slcntfddc1',false,'#formagrddc');
}


function addddc(INIDNOT,INNOCAS,INFECHA,INDETALL)
{
  
  if (validarparams(INFECHA) && valor.length > 0 && INDETALL.length > 0) {

    if (validarint(INIDNOT,INNOCAS)) {

      var formData = new FormData();

      formData.append('INIDNOT', INIDNOT);
      formData.append('INNOCAS', INNOCAS);
      formData.append('INFECHA', INFECHA);
      formData.append('tipo', 'addddc');
      formData.append('INDETALL[]', INDETALL);
      formData.append('INCON[]', incon);
      formData.append('PERIODO[]', periodo);
      formData.append('VALOR[]', valor);



      $.ajax({
        type: "POST",
        url: "../Managers/ManagerDetalle.php",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA){ if(DATA.success){closedetails();} responses(DATA);},
        error: function(){txt.EELS,txt.E,2000}
        });

     }
     else {res(txt.INCV,txt.W,2000)}
    }
    
    else {res(txt.CTC,txt.W,2000);} 

}