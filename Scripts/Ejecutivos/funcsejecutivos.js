//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){ tablasejec('casos'); });


function tablasejec(str) 
{
    $.ajax({
    type: 'GET',//Metodo en el que se enviaran los datos
    url: PageURL+'Controllers/Tables',//Direccion a la que se enviaran los datos
    data: {tabla: str},//Datos que seran enviados
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (data) {
      
      if (data.error){ return responses(data); }

      $('#tabla').DataTable().destroy();
      $('#tabla').html(data);

      $('#tabla thead tr').append('<th>DETALLES</th>'); // Agregar encabezado para el otro botón
    
      $('#tabla').DataTable($.extend(true, {}, tabledata, {
      "order": [],
      "columnDefs": [{
      "targets": 5, 
      "orderable": false,
      "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnverdetalles' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'><i class='bi bi-folder2-open btnverddc'></i> Abrir</button>"
      }]
      }));

      $('#tabla tbody').on('click', 'button.btnverdetalles', function () 
      { DetailsNotif($(this).closest('tr').find('td:eq(0)').text().trim());});      
    },
    error: function () {Alerta(txt.EELS, "error", 2000);}});   
}


eventlisten('.fico','click',function (){ 
  
  if ($('#fiicon').hasClass('bi-x-circle')) 
  { 
    $('#Cartanotif').val('');
    $('#labelcartanotif').text(`Archivos de la notificación - ${(Cartanotif.files.length)} añadidos`)
    $('#fispan').text(' Buscar archivos');
    $('#fiicon').removeClass('bi-x-circle');
    $('#fiicon').addClass('bi-arrow-up-circle');
  }

  else { $('#Cartanotif').click(); } 
  
});


eventlisten('#Cartanotif','change',function ()
{
  $('#fispan').text(' Quitar archivos' );
  $('#fiicon').removeClass('bi-arrow-up-circle');
  $('#fiicon').addClass('bi-x-circle');
  $('#labelcartanotif').text(`Archivos de la notificación - ${(Cartanotif.files.length)} añadidos`)

});


eventlisten('.fico1','click',function (){ 
  
    if ($('#fiiconddc').hasClass('bi-x-circle')) 
    { 
      $('#archivosddc').val('');
      $('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);
      $('#fispanddc').text(' Buscar archivos');
      $('#fiiconddc').removeClass('bi-x-circle');
      $('#fiiconddc').addClass('bi-arrow-up-circle');
    }
  
    else { $('#archivosddc').click(); } 
    
});
  
  
eventlisten('#archivosddc','change',function (){

  $('#labelarchivosddc').text(`Archivos de detalle - ${(archivosddc.files.length)} archivos añadidos`);    
  $('#fispanddc').text(' Quitar archivos' );
  $('#fiiconddc').removeClass('bi-arrow-up-circle');
  $('#fiiconddc').addClass('bi-x-circle');

});

eventlisten('#file-browser','click',function (){ 
  
  if ($('#file-browser').hasClass('delete')) 
  { 
    $('#FileEscrito').val('');
    $('#file-browser').text('Buscar');
    $('#file-browser').removeClass('delete');
  }

  else { $('#FileEscrito').click(); } 
  
});


eventlisten('#FileEscrito','change',function (){

  $('#file-browser').text('Quitar');
  $('#file-browser').addClass('delete');

});

async function Getcc(id, type) {

  return await new Promise((resolve, reject) => {

    if (!validarint(id, type)) { reject(txt.EELS);  }

      $.ajax({
          type: "POST",
          url: PageURL + "Managers/ManagerCliente.php",
          data: { FUNC: 'getccclt', id: id, type: type },
          dataType: "JSON",
          beforeSend: function () { load(1); },
          complete: function () { load(2); }, // Ocultar pantalla de carga
          success: function (res) 
          {
           if (res.success) 
           {
            let CCLT = res.message.EmailCliente;
            let CC = JSON.parse(res.message.CC);
            resolve({ CC, CCLT });
           }
          },
          error: function (){ reject(txt.EELS);}
      });
  }); 
}


async function ShowFormEmail(CC, CCLT) {
  return new Promise((resolve, reject) => {
    Swal.fire({
      title: 'Agregar correos adicionales',
      html: `
        <div id="email-container">
          <label for="email-1">Email del Cliente</label>
          <input type="email" class="swal2-input" list="dtlemails" placeholder="Escriba el email del cliente" id="email-1" style="width: 74%; margin-top: 3%; margin-bottom: 4%;" value="${CCLT}">
        </div>
  
        <div id="alert-span" style="margin: 11px 0px 6px 0px; display:none;">  
          <span style="color:red;" id="alert-span2">
            <i class="bi bi-exclamation-circle"></i>
            Hay un correo electrónico inválido
          </span>
        </div>
  
        <button type="button" id="add-email" class="swal2-confirm swal2-styled">Agregar correo</button>
        <button type="button" id="remove-email" class="swal2-deny swal2-styled">Eliminar último</button>`,
      confirmButtonColor: '#28a745',
      confirmButtonText: 'Enviar correo',
      showConfirmButton: true,
      showCloseButton: true,
      allowOutsideClick: false,
      didOpen: () => {

        let emailContainer = document.getElementById('email-container');

        let datalist = document.createElement('datalist');
        datalist.id = 'dtlemails';

        Directivos.forEach(optionValue => {

          $('<option>', { value: optionValue }).appendTo(datalist);
        });

        emailContainer.appendChild(datalist);

        let addinput = (text = false) => {

          let newEmailIndex = emailContainer.getElementsByTagName('input').length + 1;

          let emailDiv = document.createElement('div');
          emailDiv.id = `email-div-${newEmailIndex}`;
          emailDiv.innerHTML = `
            <input type="email" class="swal2-input" placeholder="Escriba el email #${newEmailIndex}" id="email-${newEmailIndex}" style="width: 74%; margin-top: 3%;" ${text ? `value="${text}"` : ''}>
          `;
          emailContainer.appendChild(emailDiv);

          $(`#email-${newEmailIndex}`).attr('list', `dtlemails`);
        };


        document.getElementById('add-email').addEventListener('click', () => {addinput()});

        document.getElementById('remove-email').addEventListener('click', () => {

          let emailDivs = emailContainer.getElementsByTagName('div');

          if (emailDivs.length > 0) { emailContainer.removeChild(emailDivs[emailDivs.length - 1]);}
        });

        if (CC == null || CC.length === 0) { addinput('adm@harbest.net');} 
        else { CC.forEach((correo) => { addinput(correo); }); }

        load(2);
      },
      preConfirm: () => {
        const emailContainer = document.getElementById('email-container');
        const inputs = emailContainer.getElementsByTagName('input');
        let emails = [];

        for (let input of inputs) {
          if (validaremail(input.value) || validaremailcl(input.value)) {
            emails.push(input.value);
          } else {
            input.classList.add('swal2-inputerror');
            document.getElementById('alert-span').style.display = 'block';

            input.addEventListener('input', () => {
              if (validaremail(input.value) || validaremailcl(input.value)) {
                input.classList.remove('swal2-inputerror');
                document.getElementById('alert-span').style.display = 'none';
              }
            });

            return false;
          }
        }

        return emails;
      }
    })
    .then((result) => { if (result.isConfirmed) { resolve(result.value); } })
    .catch(() => { reject(txt.EELS); });
  });
}


const ModNotif = ({FechaNotif, Fechavenci, IDNotificacion, Notificacion, Estatus}) => {

document.getElementById('FechaNotifDC').innerText = FechaNotif;
document.getElementById('FechaVenciNotifDC').innerText = Fechavenci;
document.getElementById('ArchivosNotifDC').setAttribute('onclick',`vcarta(${IDNotificacion})`);

let tabla = document.getElementById('tablanotifDC');
        
emptyTable(tabla);

// Itera sobre los registros y crea las filas
JSON.parse(Notificacion).forEach(registro => {
let fila = document.createElement('tr');

fila.innerHTML = `<td>${registro.NOTIFICACION}</td>
                  <td>${registro.TIPO}</td>
                  <td>${registro.IMPUESTO}</td>`;

tabla.appendChild(fila);
});

let EmailDiv = document.getElementById('EstadoEmailNotifDC');
        
if(Estatus === 'F')
{
EmailDiv.classList.add('cp');
EmailDiv.setAttribute('onclick',`sendmail(${IDNotificacion})`);
EmailDiv.innerHTML = '<i class="bi bi-send"></i> Enviar';
}
else
{ 
EmailDiv.classList.remove('cp');
EmailDiv.removeAttribute('onclick');
EmailDiv.innerHTML = '<i class="bi bi-check2-circle"></i> Enviado'; 
}
}


const ModDetalle = ({FechaDC,FechaVenciDC,IDDetalle,EstatusDC,DetallesCitacion}) => {

  document.getElementById('FechaDetalleDC').innerText = FechaDC;
  document.getElementById('FechaVenciDC').innerText = FechaVenciDC;
  document.getElementById('ArchivosDC').setAttribute('onclick',`AbrirDocumentosDetalles(${IDDetalle})`);

  let EmailDetallesDiv = document.getElementById('EstadoEmailDetalleDC');
 
  if(EstatusDC === 'F')
  {
  EmailDetallesDiv.classList.add('cp');
  EmailDetallesDiv.setAttribute('onclick',`sendmailddc(${IDDetalle})`);
  EmailDetallesDiv.innerHTML = '<i class="bi bi-send"></i> Enviar';
  }
  else
  { 
  EmailDetallesDiv.classList.remove('cp');
  EmailDetallesDiv.removeAttribute('onclick');
  EmailDetallesDiv.innerHTML = '<i class="bi bi-check2-circle"></i> Enviado'; 
  }

  // Selecciona la tabla
 let tablaDC = document.getElementById('tabladetallesDC');

 emptyTable(tablaDC);

 let detalles = JSON.parse(DetallesCitacion);

 for (let key in detalles)
 {
   let newRow = document.createElement("tr");
   newRow.classList = "trtable";

    $('<td>', {
    html: detalles[key].NOTIFICACION,
    rowspan: Object.keys(detalles[key].DETALLES).length + 1,
    css: { verticalAlign: 'middle' }}).appendTo(newRow);

   tablaDC.appendChild(newRow); 

   detalles[key].DETALLES.forEach( (element,index) => {

   let Rowincon = document.createElement("tr");
   Rowincon.classList = "trtable";

   Rowincon.innerHTML = `
   <td>${element.Detalle}</td>
   <td>${element.Periodo}</td>
   <td>${element.Valor}</td>
   <td>${element.Impuesto}</td>
   `;

   tablaDC.appendChild(Rowincon);
   });
    
 }
 modifystyle('#ContainerDetalleDC','display','flex');

}


const ModEscrito = ({FechaEscrito,FechaVenciED,EstatusED,IDEscrito}) => {
  document.getElementById('FechaEscritoDC').innerText = FechaEscrito;
  document.getElementById('FechaVenciEscritoDC').innerText = FechaVenciED;
  document.getElementById('ArchivosEscritoDC').setAttribute('onclick',`AbrirDocumentosEscrito(${IDEscrito})`);

  let EmailDetallesDiv = document.getElementById('EstadoEmailEscritoDC');
 
  if(EstatusED === 'F')
  {
  EmailDetallesDiv.classList.add('cp');
  EmailDetallesDiv.setAttribute('onclick',`AbrirDocumentosEscrito(${IDEscrito})`);
  EmailDetallesDiv.innerHTML = '<i class="bi bi-send"></i> Enviar';
  }
  else
  { 
  EmailDetallesDiv.classList.remove('cp');
  EmailDetallesDiv.removeAttribute('onclick');
  EmailDetallesDiv.innerHTML = '<i class="bi bi-check2-circle"></i> Enviado'; 
  }

  modifystyle('#ContainerEscritoDC','display','flex');

}


function DetailsNotif(IDD) 
{
  if (!validarparams(IDD)) {return Alerta(txt.EELS,txt.E,2000);}
  
  $.ajax({
   type: "POST",
   url: PageURL+"Managers/ManagerNotif.php",
   beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
   complete: function () { load(2); }, //Ocultar pantalla de carga
   data: {tipo: 'vdcaso',IDD: IDD},
   dataType: "JSON",
   success: function (DATA) {
   if(DATA.success)
   {
    document.getElementById('TitleNotifDC').innerText = DATA.CodigoNotif;
    document.getElementById('NombreCLienteDC').innerText = DATA.NombreCliente;
    document.getElementById('EmailCLienteDC').innerText = DATA.EmailCliente;
    document.getElementById('AdmCLienteDC').innerText = DATA.NombreAdm;     

    ModNotif(DATA);
        
    DATA.FechaDC ? ModDetalle(DATA) : modifystyle('#ContainerDetalleDC','display','none');        
    DATA.FechaEscrito ? ModEscrito(DATA) : modifystyle('#ContainerEscritoDC','display','none');
   }
   else{ return responses(DATA);}},
   error: function(){return Alerta(txt.EELS,txt.W,2000);}
  });

let Modal = new bootstrap.Modal(document.getElementById('DetailNotif'));
Modal.show();
}