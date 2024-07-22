//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){ tablasejec('notif'); });


function tablasejec(str) 
{
    $.ajax({
    type: 'GET',//Metodo en el que se enviaran los datos
    url: '../Controllers/Tables.php',//Direccion a la que se enviaran los datos
    data: {tabla: str},//Datos que seran enviados
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (data) {
    data.error ? responses(data) : tablesresult(str,data);},
    error: function () {Alerta(txt.EELS, "error", 2000);}});   
}

function tablesresult(str,data){

  $('#tabla').DataTable().destroy();
  $('#tabla').html(data);

  switch (str) {

    case 'detalles': 
      $('#tabla thead tr').append('<th>DETALLES</th>'); // Agregar encabezado para el otro botón
      $('#tabla thead tr').append('<th>ARCHIVOS</th>');
    
      $('#tabla').DataTable($.extend(true, {}, tabledata, {
      "order": [],
      "columnDefs": [{
      "targets": 8, 
      "orderable": false,
      "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnverddc' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'><i class='bi bi-folder2-open btnverddc'></i> Abrir</button>"
      },
      {
      "targets": 7, 
      "data": null,
      "orderable": false,
      "defaultContent": "<button type='button' class='btn btn-success btnverinc' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'><i class='bi bi-eye-fill btnverinc'></i> Ver</button>"
      },
      {
      "targets": 6,
      "orderable": false,
      "render": function (data, type, row) {
      if (row[6] != 'T') {
      return '<button type="button" class="btn btn-success btnenviar" style="background-color:green; height: 31px; --bs-btn-padding-y: 0px; margin-left: -10px;"><i class="bi bi-send btnenviar"></i> Enviar</button>';
      }
      else { return '<i class="bi bi-check2-circle center"></i>'; }}}]
      }));

    break;

    case 'notif':
      $('#tabla thead tr').append('<th>CARTA</th>');
      
      $('#tabla').DataTable($.extend(true, {}, tabledata, {
      "order": [],
      "columnDefs": [{
      "targets": -1, 
      "data": null,
      "defaultContent": "<button type='button' class='btn btn-success btnvercarta' style='background-color:green; height: 31px; --bs-btn-padding-y: 0px;'><i class='bi bi-eye-fill btnvercarta'></i> Ver</button>"
      },
      { 
      "targets": 6,
      "orderable": false,
      "render": function (data, type, row) {
      if (row[6] != 'T') {
      return '<button type="button" class="btn btn-success btnenviarntf" style="background-color:green; height: 31px; --bs-btn-padding-y: 0px;"><i class="bi bi-send btnenviarntf"></i> Enviar</button>';
      }
      else {return '<i class="bi bi-check2-circle center"></i>';}}
      }]
      }));

    break;

  }

    $('#tabla tbody tr').on('click', function (event) 
    {
      let Boton = event.target.classList;

      if(Boton.contains('btn') || Boton.contains('bi'))
      {
      let ID = $(this).find('td:eq(0)').text().trim();

      switch (Boton[2]) 
      {
        case 'btnverddc': AbrirDocumentosDetalles(ID); break;

        case 'btnverinc': vincon(ID); break;

        case 'btnenviar': sendmailddc(ID); break;

        case 'btnenviarntf': sendmail(ID); break;

        case 'btnvercarta': vcarta(ID); break;
      }
      }
    });
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
          <input type="email" class="swal2-input" placeholder="Escriba el email del cliente" id="email-1" style="width: 74%; margin-top: 3%; margin-bottom: 4%;" value="${CCLT}">
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
        let addinput = (text = false) => {
          let emailContainer = document.getElementById('email-container');
          let newEmailIndex = emailContainer.getElementsByTagName('input').length + 1;
          let emailDiv = document.createElement('div');
          emailDiv.id = `email-div-${newEmailIndex}`;
          emailDiv.innerHTML = `
            <input type="email" class="swal2-input" placeholder="Escriba el email #${newEmailIndex}" id="email-${newEmailIndex}" style="width: 74%; margin-top: 3%;" ${text ? `value="${text}"` : ''}>
          `;
          emailContainer.appendChild(emailDiv);
        };

        document.getElementById('add-email').addEventListener('click', () => {addinput()});

        document.getElementById('remove-email').addEventListener('click', () => {
          const emailContainer = document.getElementById('email-container');
          const emailDivs = emailContainer.getElementsByTagName('div');

          if (emailDivs.length > 0) {
            emailContainer.removeChild(emailDivs[emailDivs.length - 1]);
          }
        });

        if (CC == null || CC.length === 0) {
          addinput('adm@harbest.net');
        } else {
          CC.forEach((correo) => {
            addinput(correo);
          });
        }

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
