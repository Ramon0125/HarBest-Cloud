$(document).ready(function () { OnlyNumber('#nocddc'); OnlyNumber('#telddc'); });

var incon = [];


function adddetail(NONotif,Detalle) 
{
  if (!validarparams(NONotif,Detalle)){return Alerta(txt.CTC,txt.W,2000);}
  
  if(incon.hasOwnProperty(NONotif))
  { 
    if (incon[NONotif].includes(Detalle.trim())){return Alerta(txt.EDYEA,txt.W,false,true)}

    incon[NONotif].push(Detalle.trim()); 
  }
  
  else { incon[NONotif] = [Detalle.trim()]; }

  Alerta(`${Object.keys(incon).length} Inconsistencias detalladas en total`,txt.S,false,true,'Detalle añadido'); 
  updatedetalles();   $('#inconsisddc').val('');  $('#nontfddc').val('');
}


function dropdetails()
{
  let Propiedades = Object.keys(incon);
  
  if(Propiedades.length === 0) {return Alerta('No hay detalles agregados',txt.W,2000);}

  let LastProperty = Propiedades[Propiedades.length - 1];

  incon[LastProperty].pop();

  if(incon[LastProperty].length === 0){delete incon[LastProperty];}
 
  updatedetalles();

  Alerta('Ultimo detalle eliminado',txt.S,false,true); 
}


function updatedetalles()
{
  let table = document.getElementById("detalles");

  while (table.firstChild) { table.removeChild(table.firstChild);}

  for (let key in incon) 
  {
    let newRow = document.createElement("tr");
    newRow.classList = "trtable";

    let Inconsistencia = document.createElement("td");
    Inconsistencia.innerHTML = key;

    newRow.appendChild(Inconsistencia);

    let value = "";

    incon[key].forEach( (element,index) =>{
    value += (index !== 0 ? "<br><br>" : "")+element;
    });

    let detalles = document.createElement("td");
    detalles.innerHTML = value;

    newRow.appendChild(detalles);
  
    table.appendChild(newRow); 
  }

$('#spandetalle').text(`${Object.keys(incon).length} Inconsistencias detalladas`);
} 


function closedetails()
{
incon = [];

updatedetalles();

$('#archivosddc').val('');
$('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);
$('#spandetalle').text(`${Object.keys(incon).length} Inconsistencias detalladas`);
$('#fispanddc').text(' Buscar archivos');
$('#fiiconddc').removeClass('bi-x-circle');
$('#fiiconddc').addClass('bi-arrow-up-circle');

LimpiarModal('#slcntfddc1',['#formDDC','#btnagrddc'],['#formagrddc','#formagrddc1']);
}


function addddc(INIDNOT,INNOCAS,INFECHA,NOTIF,INDETALL,ARCHIVOS,CORAUD,NOMAUD,TELAUD)
{

if(!validarint(INIDNOT)) {return Alerta(txt.EELS,txt.E,2000)}

if(validarparams(NOTIF) || validarparams(INDETALL)) {return Alerta(txt.CTDD,txt.W,false,true);}

if(!validaraño(INFECHA.substring(0, 4))) {return Alerta(txt.IAV,txt.W,2000);}

if(!validarint(INNOCAS)) {return Alerta(txt.INCV,txt.W,2000)}

if (ARCHIVOS.length === 0 || Object.keys(incon).length === 0) {return Alerta(txt.CTC,txt.W,2000);}

if ((Array.from(ARCHIVOS).reduce((total, item) => total + item.size, 0) / (1024 ** 2)) > maxfilesize) {return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}

if(nontfddc.length - 1 != Object.keys(incon).length){return Alerta('Debe detallar todas las inconsistencias para continuar',txt.W,false,true);}

  let formData = new FormData();
  formData.append('INIDNOT', INIDNOT);
  formData.append('INNOCAS', INNOCAS);
  formData.append('INFECHA', INFECHA);
  formData.append('CORAUD', validaremailcl(CORAUD) ? CORAUD : 'N/A');
  formData.append('NOMAUD', validarparams(NOMAUD) ? NOMAUD : 'N/A' );
  formData.append('TELAUD', validarint(TELAUD) ? TELAUD : 'N/A');
  formData.append('tipo', 'addddc');

  for (const key in incon) {
    if (incon.hasOwnProperty.call(incon, key)) {
      formData.append('INCON[]', JSON.stringify({INCONSISTENCIA: key,  DETALLES: incon[key]}));
    }
  }

  Array.from(ARCHIVOS).forEach(document => {
    formData.append('ARCHIVOS[]', document)
  });

   $.ajax({
    type: "POST",
    url: PageURL+"Managers/ManagerDetalle.php",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (DATA){ if(DATA.success){ responses(DATA);
    closedetails(); updatedatalists(5,['#dtlagrddc']); updatedatalists(6,['#dtldltddc']);
    tablasejec('detalles');}},
    error: function(){Alerta(txt.EELS,txt.E,2000)}
  }); 

}


function AbrirDocumentosDetalles(IDD)
{
  if (!validarint(IDD)) {return Alerta(txt.EELS,txt.E,2000);}
  
    $.ajax({
      type: "POST",
      url: PageURL+"Managers/ManagerDetalle.php",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga  
      data: {tipo: 'vddc',IDD: IDD},
      dataType: "JSON",
      success: function (DATA) { DATA.success && DATA.CARTAS ? procesarCartas(DATA.CARTAS) : responses(DATA); }
    });
}


function vincon(IDD) 
{
  if (!validarint(IDD)) {return Alerta(txt.EELS,txt.E,2000);}

  $.ajax({
    type: "POST",
    url: PageURL+"Managers/ManagerDetalle.php",
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    data: {tipo: 'viddc',IDD: IDD},
    dataType: "JSON",
    success: function (DATA) {
    if(DATA.success && DATA.INCON)
    {
    Swal.fire({
    html:`<p> ${DATA.INCON} </p>` ,
    confirmButtonColor: '#28a745',
    showConfirmButton: true,
    width: 'auto'
    });
    }
    else{responses(DATA);}},
    error: function(){Alerta(txt.EELS,txt.W,2000)}
  });
}


async function sendmailddc(nop){

  if (!validarparams(nop)) {return Alerta(txt.EELS,txt.W,2000);}

      let CC;
      let CCLT;
      
      await $.ajax({
       type: "POST",
       url: PageURL+"Managers/ManagerCliente.php",
       data: {FUNC: 'getccclt', id: nop, type: 2},
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
  
        if (emailDivs.length > 0) {emailContainer.removeChild(emailDivs[emailDivs.length - 1]);}
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
            url: PageURL+"Managers/ManagerEmails.php",
            data: {FUNC: 'DDC',ENTITY: nop, CC: formValues},
            dataType: "JSON",
            beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
            complete: function () { load(2); }, //Ocultar pantalla de carga
            success: function (res) { responses(res);
            if(res.success){tablasejec('detalles')} updatedatalists(6,['#dtldltddc'])},
            error: function(error){Alerta(error,txt.W,2000);}
          });
        }
      

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
     success: function (DATA){ 
     if(DATA.success){tablasejec('detalles');
     LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc'); 
     updatedatalists(5,['#dtlagrddc']); updatedatalists(6,['#dtldltddc']);
     } responses(DATA);},
     error: function(){txt.EELS,txt.E,2000}
    });
  }
  
  else {Alerta(txt.EELS,txt.W,2000)}
}

