
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

    while (inputs.length != 2) { dltinc() }

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
  div.classList = `col-sm-6 ${inputs}`;
  div.innerHTML = `
  <label for="Motnotif-${inputs}" class="form-label">Motivo Notif #${inputs}</label>
  <input type="text" class="form-control" id="Motnotif-${inputs}">`;
  DivIncumpli.appendChild(div);

  let div1 = document.createElement('div');
  div1.classList = `col-sm-6 ${inputs}`;
  div1.innerHTML = `
  <label for="Aincu-${inputs}" class="form-label">Año incumplimiento ${inputs} </label>
  <input type="text" class="form-control" name="Aincu-${inputs}" id="Aincu-${inputs}">`;
  DivIncumpli.appendChild(div1);
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

 if (CARTA.length == 0 || nonotif.length == 0 || tipnotif.length == 0 || impunotif.length == 0) 
 {return Alerta(txt.CTC,txt.W,2000);}

 if(!validaraño(FECHANOT.substring(0, 4))){return Alerta(txt.IAV,txt.W,2000);}

 if (!validarint(IDCLT)) {return Alerta(txt.EELS,txt.W,2000)}

 if (validarparams(NONOT) || validarparams(TIPNOT) || validarparams(MOTIVNOT) || validarparams(AINCUMPLI))
  {return Alerta(txt.CTDN,txt.W,false,true);}

 let max = 0;

 for (let a = 0; a < CARTA.length; a++) { max += CARTA[a].size; }

 if((max / (1024**2) ) > maxfilesize)
 {return Alerta(txt.AMGR1,txt.W,false,true,txt.AMG);}


    let formData = new FormData();
    formData.append('IDCLT', IDCLT);
    formData.append('FECHANOT', FECHANOT);
    formData.append('tipo','agrnotif');

    for (const ARCHIVO of CARTA) { formData.append('CARTA[]', ARCHIVO); }

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
        error: function(){txt.EELS,txt.E,2000}
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
      success: function (DATA) {DATA.success && DATA.CARTA ? procesarCartas(DATA.CARTA) : responses(DATA);}
    });
}


function dltnotif(idn,non)
{
  if (!validarparams(non)){return Alerta(txt.CTC,txt.W,2000);}
    
  if (!validarint(idn)) { return Alerta(txt.EELS,txt.W,2000);}

    $.ajax({
    type: "POST",
    url: PageURL+"Managers/ManagerNotif.php",
    data: {tipo:'dltnotif', IDN:idn, NON:non},
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
    error: function(){txt.EELS,txt.E,2000}
    });

    
}


async function sendmail(nop){
  if (validarparams(nop)) 
  {
    let CC;
    let CCLT;
    
    await $.ajax({
     type: "POST",
     url: "../Managers/ManagerCliente.php",
     data: {FUNC: 'getccclt', id: nop},
     dataType: "JSON",
     beforeSend: function () { load(1); },
     success: function (res) {
     if(res.success) 
     {
     CCLT = res.message.EmailCliente;  
     CC = JSON.parse(res.message.CC); 
     } },
     error: function(error){Alerta(error,txt.W,2000);}
     });


     const { value: formValues } = await Swal.fire({
     title: 'Agregar correos adicionales',
     html: `
     <div id="email-container">
     <label for="email-1">Email del Cliente</label>
     <input type="email" class="swal2-input" placeholder="Escriba el email del cliente" id="email-1" style="width: 74%; margin-top: 3%; margin-bottom: 4%;" value="${CCLT}">
     </div>
 
     <div id="alert-span" style="margin: 11px 0px 6px 0px; display:none;">  
      <span style="color:red;" id="alert-span2">
      <i class="bi bi-exclamation-circle"></i>
      Hay un correo electronico invalido
      </span>
     </div>

     <button type="button" id="add-email" class="swal2-confirm swal2-styled">Agregar correo</button>
     <button type="button" id="remove-email" class="swal2-deny swal2-styled">Eliminar ultimo</button>`,
     confirmButtonColor: '#28a745',
     confirmButtonText:'Enviar correo',
     showConfirmButton: true,
     showCloseButton: true,
     allowOutsideClick: false,
     
     preConfirm: () => {
      const emailContainer = document.getElementById('email-container');
      const inputs = emailContainer.getElementsByTagName('input');
      let emails = [];

      for (let input of inputs) 
      {
        if (validaremail(input.value) || validaremailcl(input.value)) 
        { emails.push(input.value); }
            
        else 
        { 
        input.classList.add('swal2-inputerror');
        document.getElementById('alert-span').style.display = 'block';

        input.addEventListener('input',() => {
        if(validaremail(input.value) || validaremailcl(input.value))
        {
        input.classList.remove('swal2-inputerror');
        document.getElementById('alert-span').style.display = 'none';
        }
        });

        return false;
        }
      }
          
     return emails
    },

     didOpen: () => {
         
      let addinput = (text = false) => 
      {
      let emailContainer = document.getElementById('email-container');
      let newEmailIndex = emailContainer.getElementsByTagName('input').length + 1;
      let emailDiv = document.createElement('div');
      emailDiv.id = `email-div-${newEmailIndex}`;
      emailDiv.innerHTML = `
      <input type="email" class="swal2-input" placeholder="Escriba el email #${newEmailIndex}" id="email-${newEmailIndex}" style="width: 74%; margin-top: 3%;" ${typeof text == "string" ? "value="+text : null}>
      `;
      emailContainer.appendChild(emailDiv);
      }

      document.getElementById('add-email').addEventListener('click', addinput);
    
      document.getElementById('remove-email').addEventListener('click', () => {
      const emailContainer = document.getElementById('email-container');
      const emailDivs = emailContainer.getElementsByTagName('div');

      if (emailDivs.length > 0) 
      {emailContainer.removeChild(emailDivs[emailDivs.length - 1]);}
      });    


      if (CC == null || CC.length == 0)
      {
      addinput('administracion@harbest.net');
      }
      else{CC.forEach((correo) => { addinput(correo) }); }

      load(2);
        
      }
      });
    

      if (formValues) 
      {
        $.ajax({
          type: "POST",
          url: "../Managers/ManagerEmails.php",
          data: {FUNC: 'NOTIF.',ENTITY: nop, CC: formValues},
          dataType: "JSON",
          beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
          complete: function () { load(2); }, //Ocultar pantalla de carga
          success: function (res) {  responses(res);
          if(res.success){updatedatalists(4,['#dtldltnot']); /* updatedatalists(5,['#dtlagrddc']); */  tablasejec('notif')}},
          error: function(error){Alerta(error,txt.W,2000);}
        });
      }
    
  }
  else {Alerta(txt.EELS,txt.W,2000)}
  }