$(document).ready(function () {
OnlyNumber('#nocddc'); OnlyNumber('#telddc');  OnlyNumber('#valddc');  OnlyNumber('#perddc'); OnlyValor('#valddc');
});

var incon = [];

eventlisten('#nontfddc','change',function() {$('#nocddc').val('');})


function adddetail(NONotif,NOCaso,Detalle,Periodo,Valor,Impuesto) 
{
  if (!validarparams(NONotif,NOCaso,Detalle,Periodo,Valor,Impuesto))
    {return Alerta(txt.CTC,txt.W,2000);}

  if (!validarint(NOCaso)){return Alerta(txt.INCV,txt.W,2000);}

  if (!validarvalor(Valor)){return Alerta(txt.IVV,txt.W,2000);}

  if(!validaraño(Periodo.substring(0, 4)) || Periodo.substring(4) < 1 || Periodo.substring(4) > 12) 
  {return Alerta(txt.IPV,txt.W,2000);}

  let Informacion = {NOCaso,Detalle,Periodo,Valor,Impuesto};

  if(incon.hasOwnProperty(NONotif))
  { 
    let existeEntrada = incon[NONotif].some(item => 
      item.NOCaso === Informacion.NOCaso &&
      item.Detalle === Informacion.Detalle &&
      item.Periodo === Informacion.Periodo &&
      item.Valor === Informacion.Valor &&
      item.Impuesto === Informacion.Impuesto
    );

    if (existeEntrada) { return Alerta(txt.EDYEA, txt.W, false, true); }

    incon[NONotif].push(Informacion); 
  }
  
  else {
    
    for (let notif in incon) 
    {
      if (notif !== NONotif) 
      {
        let existeEntrada = incon[notif].some(item => item.NOCaso === NOCaso);
        
        if (existeEntrada) { return Alerta(txt.ENCYA, txt.W, false, true); }
      }
    }

    incon[NONotif] = [Informacion]; 
}
  Alerta('Detalle añadido',txt.S,2000); 
  updatedetalles();   $('#inconsisddc').val('');  $('#perddc').val(''); $('#valddc').val(''); $('#impddc').val('');
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

  emptyTable(table);

  for (let key in incon) 
  {
    let newRow = document.createElement("tr");
    newRow.classList = "trtable";
      
    $('<td>', { html: key, rowspan: (Object.keys(incon[key]).length + 1)}).appendTo(newRow);

    table.appendChild(newRow); 

    incon[key].forEach( (element,index) =>{

    let Rowincon = document.createElement("tr");
    Rowincon.classList = "trtable";

    $('<td>', { html: element.Detalle }).appendTo(Rowincon);
    $('<td>', { html: element.Periodo }).appendTo(Rowincon);
    $('<td>', { html: element.Valor }).appendTo(Rowincon);
    $('<td>', { html: element.Impuesto }).appendTo(Rowincon);

    table.appendChild(Rowincon);
    });
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


function addddc(INCODNOT,INFECHA,ARCHIVOS,INDETALL,PERIODO,VALOR,IMPUESTO,CORAUD,NOMAUD,TELAUD)
{

if(nontfddc.length - 1 != Object.keys(incon).length)
{return Alerta('Debe detallar todas las inconsistencias para continuar',txt.W,false,true);}

if (ARCHIVOS.length === 0 || Object.keys(incon).length === 0 || !validarparams(INCODNOT)) 
  {return Alerta(txt.CTC,txt.W,2000);}
  
if(validarparams(INDETALL) || validarparams(PERIODO) || validarparams(VALOR) || validarparams(IMPUESTO))
{return Alerta(txt.CTDD,txt.W,false,true);}

if(!validaraño(INFECHA.substring(0, 4))) {return Alerta(txt.IAV,txt.W,2000);}

if ((Array.from(ARCHIVOS).reduce((total, item) => total + item.size, 0) / (1024 ** 2)) > maxfilesize) 
{return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}


  let formData = new FormData();

  formData.append('INCODNOT', INCODNOT);
  formData.append('INFECHA', INFECHA);
  formData.append('CORAUD', validaremailcl(CORAUD) ? CORAUD : 'N/A');
  formData.append('NOMAUD', validarparams(NOMAUD) ? NOMAUD : 'N/A' );
  formData.append('TELAUD', validarint(TELAUD) ? TELAUD : 'N/A');
  formData.append('tipo', 'addddc');

  for (const key in incon) {
    if (incon.hasOwnProperty.call(incon, key)) 
    {
      formData.append('INCON[]', JSON.stringify({INCONSISTENCIA: key,  DETALLES: incon[key]}));
    }
  }

  Array.from(ARCHIVOS).forEach(document => {
    formData.append('ARCHIVOS[]', document)
  });

   $.ajax({
    type: "POST",
    url: PageURL+"Managers/ManagerDetalle",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (DATA)
    { 
      if(DATA.success)
      { 
      closedetails(); 
      updatedatalists(5,['#dtlagrddc']); 
      updatedatalists(6,['#dtldltddc']);
      tablasejec('casos');
      } responses(DATA);
    },
    error: function(){return Alerta(txt.EELS,txt.E,2000)}
  }); 

}


function AbrirDocumentosDetalles(IDD)
{
  if (!validarint(IDD)) {return Alerta(txt.EELS,txt.E,2000);}
  
    $.ajax({
      type: "POST",
      url: PageURL+"Managers/ManagerDetalle",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga  
      data: {tipo: 'vddc',IDD: IDD},
      dataType: "JSON",
      success: function (DATA) 
      { 
        DATA.success && DATA.CARTAS ? procesarCartas(DATA.CARTAS) : responses(DATA); 
      },
      error: function(){return Alerta(txt.EELS,txt.E,2000)}
    });
}


async function sendmailddc(nop) 
{
  if (!validarint(nop)) { return Alerta(txt.EELS,txt.W,2000); }
    
  try {

   const { CC, CCLT } = await Getcc(nop, 2);
  
   if (!validaremailcl(CCLT) || typeof CC != 'object') {return Alerta(txt.EELS, txt.W, 2000);}

   const values = await ShowFormEmail(CC, CCLT);

   if (!values || typeof values != 'object' ) {return Alerta(txt.EELS, txt.W, 2000)} 

   $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerEmails.php",
    data: { FUNC: 'DDC', ENTITY: nop, CC: values },
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) 
    {
      responses(res);
      if (res.success) 
      {
        tablasejec('casos'); 
        updatedatalists(6, ['#dtldltddc']);
        updatedatalists(7,['#dtlagredd']);
      }
    },
    error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
 
  } catch (error) { return Alerta(error, txt.W, 2000); }
  }
  

function searchnotif(Cod)
{
  if (!validarparams(Cod)) {return Alerta(txt.EELS, txt.W, 2000);}

  $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerNotif.php",
    data: { tipo: 'vdnot', Codigo: Cod},
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) 
     {
      if (res.success && res.message) 
      { 
        let SelectNotif = document.getElementById('nontfddc');

        $.each(JSON.parse(res.message), function(index, valor) 
        {
          $('<option>', { value: valor, text: valor}).appendTo(SelectNotif);
        });

        modifystyle(['#formDDC','#btnagrddc'],'display','block');
      }
      else {responses(res)}
     },
     error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
}


function dltddc(idd,noc)
{
  if (!validarint(idd) || !validarparams(noc)) { return Alerta(txt.EELS,txt.W,2000); }

    $.ajax({
     method: "POST",
     url: PageURL + "Managers/ManagerDetalle.php",
     data: {IDD: idd,NOC: noc,tipo: 'dltddc'},
     beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
     complete: function () { load(2); }, //Ocultar pantalla de carga
     success: function (DATA)
     { 
     if(DATA.success)
     {
      tablasejec('casos');
      LimpiarModal('#slcdltddc1',['#dtldltddc','#btndltddc'],'#formdltddc'); 
      updatedatalists(5,['#dtlagrddc']); 
      updatedatalists(6,['#dtldltddc']);
     } responses(DATA);
    },
     error: function(){return Alerta(txt.EELS, txt.W, 2000);}
    });
}

