$(document).ready(function () {  OnlyNumber('#Aincu'); });

var nonotif = []; //Variable de los numeros de notificación
var tipnotif = []; //Variable de los tipos de notificación
var impunotif = []; //Variable de los impuestos de notificación

const DivIncumpli = document.getElementById('Incumplimientos');

function addnotificacion(n,t) 
{
  if (!validarparams(n,t)) {return Alerta(txt.CTC,txt.W,2000);}

  if(nonotif.includes(n)){return Alerta(txt.ENYEA,txt.W,false,true);}
  
   let i = '';

   let inputs = DivIncumpli.getElementsByTagName('input');
  
   for (let c = 0; c < inputs.length; c += 2) 
   {
      if (c + 1 < inputs.length) 
      { 
        if(!validarparams(inputs[c].value,inputs[c+1].value)) {return Alerta(txt.CTC,txt.W,2000);}
        if(!validaraño(inputs[c+1].value)) {return Alerta(txt.IAV,txt.W,2000);}

        i += `${inputs[c].value}/${inputs[c+1].value}`;
          
        if (c + 2 < inputs.length) { i += ', '; }
      }
   }

   nonotif.push(n);
   tipnotif.push(t);
   impunotif.push(i);

   $('#Notfic').val('');
   $('#Tiponotf').val('');
   $('#Motnotif').val('');
   $('#Aincu').val('');

    while (inputs.length > 2) { dltinc() }

    updatenotificacion();  

    $('#spannotif').text(`${nonotif.length} Notificaciones agregadas`);

    Alerta(`${nonotif.length} Notificaciones en total`,txt.S,false,true,'Notificacion añadida'); 
}


function dropnotificacion()
{
  if (nonotif.length == 0)  {return Alerta(`No hay notificaciones agregadas`,txt.W,2000);}

  nonotif.pop();  tipnotif.pop();  impunotif.pop();

  updatenotificacion();

  $('#spannotif').text(`${nonotif.length} Notificaciones agregadas`);

  Alerta(`${nonotif.length} Notificaciones en total`,txt.S,false,true,'Ultima notificacion eliminada');
}


function updatenotificacion()
{
  let table = document.getElementById("tablanotif");

  while (table.firstChild) { table.removeChild(table.firstChild);}

  for (let i = 0; i < nonotif.length; i++) 
  {
  let newRow = document.createElement("tr");

  let newCell = document.createElement("td");
  newCell.innerHTML = nonotif[i];
  newRow.appendChild(newCell);

  let newCell1 = document.createElement("td");
  newCell1.innerHTML = tipnotif[i];
  newRow.appendChild(newCell1);


  let newCell2 = document.createElement("td");
  newCell2.innerHTML = impunotif[i] ;
  newRow.appendChild(newCell2);

  table.appendChild(newRow);
  }
} 


function closenotif()
{
nonotif = [];  tipnotif = [];  impunotif = [];

let inputs = DivIncumpli.getElementsByTagName('div');

updatenotificacion();

$('#Cartanotif').val('');
$('#spannotif').text(`${incon.length} Notificaciones agregadas`);
$('#labelcartanotif').text(`Archivos de la notificación - ${(Cartanotif.files.length)} añadidos`)
$('#fispan').text(' Buscar archivos');
$('#fiicon').removeClass('bi-x-circle');
$('#fiicon').addClass('bi-arrow-up-circle');

LimpiarModal('#cltagrnot1',false,'#formagrnotif');

while (inputs.length != 2) { dltinc() }
}


const addinc = () => {
  const inputs = (DivIncumpli.getElementsByTagName('input').length / 2 ) + 1;

  let div = document.createElement('div');
  div.classList = `col-sm-6`;
  div.innerHTML = `
  <label for="Motnotif-${inputs}" class="form-label">Motivo Notif. #${inputs}</label>
  <input type="text" class="form-control" id="Motnotif-${inputs}">`;
  DivIncumpli.appendChild(div);

  let div1 = document.createElement('div');
  div1.classList = `col-sm-6 ${inputs}`;
  div1.innerHTML = `
  <label for="Aincu-${inputs}" class="form-label">Año incumplimiento #${inputs} </label>
  <input type="text" class="form-control Aincu" name="Aincu-${inputs}" id="Aincu-${inputs}">`;
  DivIncumpli.appendChild(div1);

  OnlyNumber(`#Aincu-${inputs}`);
}// Constante que agrega campos de incumplimiento


const dltinc = () => {
let inputs = DivIncumpli.getElementsByTagName('div');

if(inputs.length > 2)
{
  DivIncumpli.removeChild(inputs[inputs.length - 1]);
  DivIncumpli.removeChild(inputs[inputs.length - 1]);
}
}


function agrnotif(IDCLT,FECHANOT,CARTA,NONOT,TIPNOT,MOTIVNOT,AINCUMPLI)
{

 if (CARTA.length === 0 || nonotif.length === 0 || tipnotif.length === 0 || impunotif.length === 0) 
 {return Alerta(txt.CTC,txt.W,2000);}

 if(!validaraño(FECHANOT.substring(0, 4))){return Alerta(txt.IAV,txt.W,2000);}

 if (!validarint(IDCLT)) {return Alerta(txt.EELS,txt.W,2000)}

 if (validarparams(NONOT) || validarparams(TIPNOT) || validarparams(MOTIVNOT) || validarparams(AINCUMPLI))
  {return Alerta(txt.CTDN,txt.W,false,true);}

 if ((Array.from(CARTA).reduce((total, item) => total + item.size, 0) / (1024 ** 2)) > maxfilesize) 
  {return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}
  
    let formData = new FormData();
    formData.append('IDCLT', IDCLT);
    formData.append('FECHANOT', FECHANOT);
    formData.append('tipo','agrnotif');

    Array.from( CARTA).forEach(document => {
      formData.append('CARTA[]', document)
    });

    nonotif.forEach((nonot, index) => {
    formData.append('NONOTIF[]', nonot);
    formData.append('TIPNOTIF[]', tipnotif[index]);
    formData.append('IMPUNOTIF[]', impunotif[index]);
    });

    $.ajax({
        type: "POST",
        url: PageURL+"Managers/ManagerNotif.php",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA) { 
        if(DATA.success){
        updatedatalists(4,['#dtldltnot']);
        closenotif(); 
        tablasejec('notif');} 
        responses(DATA); },
    error: function(){return Alerta(txt.EELS,txt.E,2000);}
    });
}


function vcarta(IDN)
{
  if (!validarint(IDN)){ return Alerta(txt.EELS,txt.E,2000);}

    $.ajax({
      type: "POST",
      url: PageURL+"Managers/ManagerNotif.php",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga
      data: {tipo: 'vcarta',IDN: IDN},
      dataType: "JSON",
      success: function (DATA) {DATA.success && DATA.CARTA ? procesarCartas(DATA.CARTA) : responses(DATA);},
      error: function(){return Alerta(txt.EELS,txt.E,2000);}
    });
}


function dltnotif(idn,non)
{
  if (!validarparams(non)){return Alerta(txt.CTC,txt.W,2000);}
    
  if (!validarint(idn)) { return Alerta(txt.EELS,txt.W,2000);}


    $.ajax({
    type: "POST",
    url: PageURL+"Managers/ManagerNotif.php",
    data: {tipo:'dltnotif', IDN:idn, COD:non},
    dataType: "JSON",
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (DATA)
    {
      if(DATA.success)
      {
        LimpiarModal('#slcdltnotif1',['#dtldltnot','#btndltnotif'],'#formdltnotif'); 
        updatedatalists(4,['#dtldltnot']);
        tablasejec('notif');
      } responses(DATA);
    },
    error: function(){return Alerta(txt.EELS,txt.E,2000);}
    });
    
}

async function sendmail(nop) 
{
  if (!validarint(nop)) { return Alerta(txt.EELS,txt.W,2000);  }
    
  try {

   const { CC, CCLT } = await Getcc(nop, 1);
  
   if (!validaremailcl(CCLT) || typeof CC != 'object') {return Alerta(txt.EELS, txt.W, 2000);}

   const values = await ShowFormEmail(CC, CCLT);

   if (!values || typeof values != 'object' ) {return Alerta(txt.EELS, txt.W, 2000)} 

   $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerEmails.php",
    data: { FUNC: 'NOTIF.', ENTITY: nop, CC: values },
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) {  responses(res);
    if(res.success){updatedatalists(4,['#dtldltnot']); updatedatalists(5,['#dtlagrddc']);  tablasejec('notif')}},
    error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
 
  } catch (error) { return Alerta(error, txt.W, 2000); }
  }