
var incon = [];

function adddetail(i) {

  if (validarparams(i)) {
    incon.push(i.trim());

    updatedetalles();
  
    $('#spandetalle').text(`Detalles agregados${incon.length > 0 ? ': '+(incon.length) : ''}`);

    res(`${incon.length} detalles en total`,txt.S,false,true,'Detalle añadido');
    $('#inconsisddc').val('');

  }
  else {res(txt.CTC,txt.W,2000);} 

}

const dropdetails = () => { incon.pop();

  updatedetalles();

  $('#spandetalle').text(`Detalles agregados${incon.length > 0 ? ': '+(incon.length) : ''}`);

  res(`${incon.length} detalles en total`,txt.S,false,true,'Ultimo detalle eliminado'); 

}


const updatedetalles = () => {

  let table = document.getElementById("detalles");

  while (table.firstChild) { table.removeChild(table.firstChild);
  }

  for (let i = 0; i < incon.length; i++) {
  let newRow = document.createElement("tr");

  let newCell = document.createElement("td");
  newCell.innerHTML = incon[i].replace(/\n/g, "<br>"); // Cambia el contenido según necesites
  newRow.appendChild(newCell);
  
  table.appendChild(newRow);
  }
  
  // Insertar la nueva fila en la tabla

} 

function closedetails()
{
incon = [];

updatedetalles();

$('#archivosddc').val('');
$('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);
$('#spandetalle').text(`Detalles agregados${incon.length > 0 ? ': '+(incon.length) : ''}`);
$('#fispanddc').text(' Buscar archivos');
$('#fiiconddc').removeClass('bi-x-circle');
$('#fiiconddc').addClass('bi-arrow-up-circle');

LimpiarModal('#slcntfddc1',false,'#formagrddc');
}


function addddc(INIDNOT,INNOCAS,INFECHA,INDETALL)
{
  
  if (validarparams(INFECHA) && incon.length > 0 && INDETALL.length > 0) {

    if (validarint(INIDNOT,INNOCAS)) {

      let formData = new FormData();

      formData.append('INIDNOT', INIDNOT);
      formData.append('INNOCAS', INNOCAS);
      formData.append('INFECHA', INFECHA);
      formData.append('tipo', 'addddc');

      for (let e = 0; e < INDETALL.length; e++) {
      formData.append('INCON[]', incon[e]);
      }

      for (let i = 0; i < INDETALL.length; i++) {
      formData.append('INDETALL[]', INDETALL[i]);
      }

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


function dltddc(idd,noc)
{
     if (validarint(idd,noc)) 
     {  
        $.ajax({
        method: "POST",
        url: "../Managers/ManagerDetalle.php",
        data: {IDD: idd,NOC: noc,tipo: 'dltddc'},
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA){ if(DATA.success){LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc'); tablasejec('notif');} responses(DATA);},
        error: function(){txt.EELS,txt.E,2000}
        });
     }
     else {res(txt.EELS,txt.W,2000)}
}


function vddc(IDD)
{

  if (validarint(IDD)) 
  {
    $.ajax({
      type: "POST",
      url: "../Managers/ManagerDetalle.php",
      data: {tipo: 'vddc',IDD: IDD},
      dataType: "JSON",
      success: function (DATA) {

        if(DATA.success && DATA.CARTAS){

        let archivos = JSON.parse(DATA.CARTAS);

        for (let v = 0; v < archivos.length; v++)
        {
          let binaryString = atob(archivos[v].archivo);

          let bytes = new Uint8Array(binaryString.length);

          for (let i = 0; i < binaryString.length; i++) { bytes[i] = binaryString.charCodeAt(i);}
        
          let blob = new Blob([bytes], {type: archivos[v].mime}); // Cambiar el tipo MIME según corresponda
        
          let url = URL.createObjectURL(blob);

          window.open(url, '_blank');
        }
      }
      else{responses(DATA);}
      }

      
    });
  }
  else {res(txt.EELS,txt.E,2000)}
}

function sendmailddc(nop){
  if (validarparams(nop)) {
    $.ajax({
      type: "POST",
      url: "../Managers/ManagerEmails.php",
      data: {FUNC: 'DDC',ENTITY: nop},
      dataType: "JSON",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga
      success: function (res) { responses(res);
      if(res.success){tablasejec('email_notif')}},
      error: function(error){res(error,txt.W,2000);}
    });
  }
  else {res(txt.EELS,txt.W,2000)}
  }