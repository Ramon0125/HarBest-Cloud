
var incon = [];


function adddetail(i) {
  if (validarparams(i)) 
  {
    incon.push(i.trim());
    $('#spandetalle').text(`${incon.length} Detalles agregados`);
    updatedetalles();   $('#inconsisddc').val('');
    res(`${incon.length} detalles en total`,txt.S,false,true,'Detalle añadido');
  }
  else {res(txt.CTC,txt.W,2000);} 
}


const dropdetails = () => { incon.pop();
  updatedetalles();

  $('#spandetalle').text(`${incon.length} Detalles agregados`);

  res(`${incon.length} detalles en total`,txt.S,false,true,'Ultimo detalle eliminado'); 
}


const updatedetalles = () => {

  let table = document.getElementById("detalles");

  while (table.firstChild) { table.removeChild(table.firstChild);}

  for (let i = 0; i < incon.length; i++) {
  let newRow = document.createElement("tr");

  let newCell = document.createElement("td");
  newCell.innerHTML = incon[i].replace(/\n/g, "<br>");
  newRow.appendChild(newCell);
  
  table.appendChild(newRow);
  }
  
} 

function closedetails()
{
incon = [];

updatedetalles();

$('#archivosddc').val('');
$('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);
$('#spandetalle').text(`${incon.length} Detalles agregados`);
$('#fispanddc').text(' Buscar archivos');
$('#fiiconddc').removeClass('bi-x-circle');
$('#fiiconddc').addClass('bi-arrow-up-circle');

LimpiarModal('#slcntfddc1',false,'#formagrddc');
}


function addddc(INIDNOT,INNOCAS,INFECHA,INDETALL,INCON)
{
  if (validarparams(INCON)) {incon.push(INCON.trim());}

  if (validarparams(INFECHA) && incon.length > 0 && INDETALL.length > 0) {

    if (validarint(INIDNOT,INNOCAS)) {

      let formData = new FormData();

      formData.append('INIDNOT', INIDNOT);
      formData.append('INNOCAS', INNOCAS);
      formData.append('INFECHA', INFECHA);
      formData.append('tipo', 'addddc');

      incon.forEach(element => {
      formData.append('INCON[]', element.trim());});

      INDETALL.forEach(element => {
      formData.append('INDETALL[]', element);});

      $.ajax({
        type: "POST",
        url: "../Managers/ManagerDetalle.php",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA){ if(DATA.success){
        closedetails(); updatedatalists(5,['#dtlagrddc']); updatedatalists(6,['#dtldltddc']);
        tablasejec('detalles');} responses(DATA);},
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
        success: function (DATA){ if(DATA.success){
        LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc'); 
        updatedatalists(5,['#dtlagrddc']); updatedatalists(6,['#dtldltddc']); tablasejec('detalles');} responses(DATA);},
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
        
          let blob = new Blob([bytes], {type: archivos[v].mime});
        
          window.open(URL.createObjectURL(blob), '_blank');
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


  function vincon(IDD) 
{
  $.ajax({
    type: "POST",
    url: "../Managers/ManagerDetalle.php",
    data: {tipo: 'viddc',IDD: IDD},
    dataType: "JSON",
    success: function (DATA) {

    if(DATA.success && DATA.INCON){
      Swal.fire({
        html:`<p> ${DATA.INCON} </p>` ,
        confirmButtonColor: '#28a745',
        showConfirmButton: true,
        width: 'auto'
      });
    }
    else{responses(DATA);}
    }});
}