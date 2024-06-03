
var nonotif = [];
var tipnotif = [];
var monotif = [];
var annotif = [];


function addnotificacion(n,t,m,a) {
  if (!validarparams(n,t,m,a)) 
  {res(txt.CTC,txt.W,2000);}
  
  else 
  {  
    nonotif.push(n);
   tipnotif.push(t);
    monotif.push(m);
    annotif.push(a);

    $('#spannotif').text(`${nonotif.length} Notificaciones Agregadas`);

    $('#Notfic').val('');
    $('#Tiponotf').val('');
    $('#Motnotif').val('');
    $('#Aincu').val('');

    res(`${nonotif.length} Notificaciones en total`,txt.S,false,true,'Notificacion añadida');

    updatenotificacion();   
  }
}



function dropnotificacion(){

  nonotif.pop();
  tipnotif.pop();
  monotif.pop();
  annotif.pop();

  updatenotificacion();

  $('#spannotif').text(`${nonotif.length} Notificaciones agregadas`);

  res(`${nonotif.length} Notificaciones en total`,txt.S,false,true,'Ultima notificacion eliminada'); 
}


function updatenotificacion(){

  let table = document.getElementById("tablanotif");

  while (table.firstChild) { table.removeChild(table.firstChild);}

  for (let i = 0; i < nonotif.length; i++) {
  let newRow = document.createElement("tr");

  let newCell = document.createElement("td");
  newCell.innerHTML = nonotif[i];
  newRow.appendChild(newCell);

  let newCell1 = document.createElement("td");
  newCell1.innerHTML = tipnotif[i];
  newRow.appendChild(newCell1);


  let newCell2 = document.createElement("td");
  newCell2.innerHTML = monotif[i];
  newRow.appendChild(newCell2);


  let newCell3 = document.createElement("td");
  newCell3.innerHTML = annotif[i];
  newRow.appendChild(newCell3);
  
  table.appendChild(newRow);
  }
  
} 

function closenotif()
{
nonotif = [];
tipnotif = [];
monotif = [];
annotif = [];

updatenotificacion();

$('#Cartanotif').val('');
$('#spannotif').text(`${incon.length} Notificaciones agregadas`);
$('#fispan').text(' Buscar notificación');
$('#fiicon').removeClass('bi-x-circle');
$('#fiicon').addClass('bi-arrow-up-circle');

LimpiarModal('#cltagrnot1',false,'#formagrnotif')
}



function agrnotif(IDCLT,FECHANOT,NONOT,TIPNOT,MOTIVNOT,CARTA,AINCUMPLI,COMENTS = false)
{
 if (!validarparams(FECHANOT,NONOT,TIPNOT,MOTIVNOT,AINCUMPLI) || !CARTA) 
 {res(txt.CTC,txt.W,2000)}

 else if (CARTA && CARTA.size / (1024 * 1024) > (parseInt(maxfilesize/3.3))) {res(txt.AMGR,txt.W,false,true,txt.AMG);}

 else if (!validarint(IDCLT)) {res(txt.EELS,txt.W,2000)}

 else
 {
    let formData = new FormData();
    formData.append('IDCLT', IDCLT);
    formData.append('FECHANOT', FECHANOT);
    formData.append('NONOT', NONOT);
    formData.append('TIPNOT', TIPNOT);
    formData.append('MOTIVNOT', MOTIVNOT);
    formData.append('CARTA', CARTA);
    formData.append('AINCUMPLI', AINCUMPLI);
    formData.append('COMENTS', COMENTS ? COMENTS : 'SIN COMENTARIOS');
    formData.append('tipo','agrnotif');

    $.ajax({
        type: "POST",
        url: "../Managers/ManagerNotif.php",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA) { if(DATA.success){ updatedatalists(4,['#dtledtnot','#dtldltnot']);
        LimpiarModal(['#slcnotif1','#cltedtnot1'],['#dtledtnot','#formedtnotif1','#btnedtnotif'],['#formedtnotif11','#formedtnotif']);
        tablasejec('notif');} responses(DATA);},
        error: function(){txt.EELS,txt.E,2000}
    });
 }
}



function vcarta(IDN)
{

  if (validarparams(IDN) && validarint(IDN)) 
  {
    $.ajax({
      type: "POST",
      url: "../Managers/ManagerNotif.php",
      data: {tipo: 'vcarta',IDN: IDN},
      dataType: "JSON",
      success: function (DATA) {

        if(DATA.success && DATA.TIPO){

        let binaryString = atob(DATA.CARTA);

        let len = binaryString.length;
        let bytes = new Uint8Array(len);
        
        for (let i = 0; i < len; i++) { bytes[i] = binaryString.charCodeAt(i);}

        let blob = new Blob([bytes], {type: DATA.TIPO}); // Cambiar el tipo MIME según corresponda

        let url = URL.createObjectURL(blob);

        window.open(url, '_blank');
      }
      else{responses(DATA);}
      }
    });
  }
  else {res(txt.EELS,txt.E,2000)}
}



// Función para obtener los detalles de un cliente
function vdntf(id, non) 
{
 $.ajax({
 type: 'POST',
 url: '../Managers/ManagerNotif.php',
 data: { tipo: "vdatos", ID: id, NON: non },
 beforeSend: function () {load(1);},
 complete: function () {load(2);},
 success: function (data) {
 if (data.success) { // Llenar los campos de edición con los detalles del usuario
 $('#cltedtnot1').val(data.IDCliente);
 $('#cltedtnot').val(data.NOMBRE_CLIENTE);
 $('#edtNotfic1').val(data.NONotificacion);
 $('#edtDatenotf').val(data.FECHANotif);
 $('#edtTiponotf1').val(data.TIPONotif);
 $('#edtMotnotif').val(data.MOTIVONotif);
 $('#edtAincu').val(data.Aincumplimiento);
 modifystyle(['#formedtnotif1','#btnedtnotif'],'display','block');} // Mostrar el formulario de edición
 else {responses(data);}}, // Mostrar mensaje de error        
 error: function () {res(txt.EELS, "error", 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}



function edtnotif(idn,non,nidcli,nfech,nnon,ntipno,nmotnot,naincu) 
{
  if (validarparams(non,nfech,nnon,ntipno,nmotnot)) 
  {
   if (validarint(idn,nidcli,naincu)) 
   {  
      let formData = new FormData();
      formData.append('IDN', idn);
      formData.append('NON', non);
      formData.append('NIDCLI', nidcli);
      formData.append('NFECH', nfech);
      formData.append('NNON', nnon);
      formData.append('NTIPNO', ntipno);
      formData.append('NMOTNOT', nmotnot);
      formData.append('NAINCU', naincu);
      formData.append('tipo','edtnotif');
  
      $.ajax({
      type: "POST",
      url: "../Managers/ManagerNotif.php",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga
      success: function (DATA){ if(DATA.success){LimpiarModal(['#slcnotif1','#cltedtnot1'],['#dtledtnot','#formedtnotif1','#btnedtnotif'],['#formedtnotif11','#formedtnotif']); 
      updatedatalists(4,['#dtledtnot','#dtldltnot']);  tablasejec('notif');} responses(DATA);},
      error: function(){txt.EELS,txt.E,2000}
      });
   }
   else {res(txt.EELS,txt.W,2000)}
  }
  
  else {res(txt.CTC,txt.W,2000);}
}



function dltnotif(idn,non)
{
  if (validarparams(non)) 
    {
     if (validarint(idn)) 
     {  
        let formData = new FormData();
        formData.append('IDN', idn);
        formData.append('NON', non);
        formData.append('tipo','dltnotif');
    
        $.ajax({
        type: "POST",
        url: "../Managers/ManagerNotif.php",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA){ if(DATA.success){LimpiarModal('#slcdltnotif1',['#dtldltnot','#btndltnotif'],'#formdltnotif'); 
        updatedatalists(4,['#dtledtnot','#dtldltnot']);  tablasejec('notif');} responses(DATA);},
        error: function(){txt.EELS,txt.E,2000}
        });
     }
     else {res(txt.EELS,txt.W,2000)}
    }
    
    else {res(txt.CTC,txt.W,2000);} 
}


function sendmail(nop){
  if (validarparams(nop)) {
    $.ajax({
      type: "POST",
      url: "../Managers/ManagerEmails.php",
      data: {FUNC: 'NOTIF.',ENTITY: nop},
      dataType: "JSON",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga
      success: function (res) { responses(res);
      if(res.success){updatedatalists(4,['#dtledtnot','#dtldltnot']); updatedatalists(5,['#dtlagrddc']);  tablasejec('notif')}},
      error: function(error){res(error,txt.W,2000);}
    });
  }
  else {res(txt.EELS,txt.W,2000)}
  }