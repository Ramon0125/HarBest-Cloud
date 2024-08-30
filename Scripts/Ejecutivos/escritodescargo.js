eventlisten('#ContainerEDD','click',
  function () { 
      
      if($('#ContainerEDD').hasClass('has'))
      {
          $('#FileEDD').val('');
          $('#ContainerEDD').removeClass('has');
          $('#Spanedd').text('Buscar');
          modifystyle(['#Spanedd'],'color','green');
      }
      
      else{ $('#FileEDD').click(); }
  }
  );
  
  eventlisten('#FileEDD','change',
  function () { 
      
      if($('#FileEDD')[0].files.length > 0)
      {
          $('#ContainerEDD').addClass('has');
          $('#Spanedd').text('Quitar');
          modifystyle(['#Spanedd'],'color','red');
      }
      
      else
      { $('#ContainerEDD').removeClass('has');
        $('#Spanedd').text('Buscar');
        modifystyle(['#Spanedd'],'color','green');
      }
  }
  );


function closeescrito()
{
    $('#FileEDD').val('');
    $('#Spanedd').text('Buscar');
    $('#Spanedd').removeClass('has');
    modifystyle(['#Spanedd'],'color','green');
    LimpiarModal(['#slcntfedd1','#slcntfedd'],['#formEDD','#btnagredd'],['#formagrddc1']);
}


function addedd(CODNOT,FECHA,ARCHIVOSEDD)
{
if(!validarparams(CODNOT,FECHA) || !ARCHIVOSEDD) {return Alerta(txt.CTC,txt.W,2000);}

if((ARCHIVOSEDD.size / (1024 ** 2)) > maxfilesize){return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}

if(!validaraño(FECHA.substring(0, 4))){return Alerta(txt.IAV,txt.W,2000)}

let formData = new FormData();

formData.append('FUNC','agredd')

formData.append('CodNot',CODNOT);

formData.append('Archivo[]',ARCHIVOSEDD);

formData.append('Fecha',FECHA);

$.ajax({
 type: "POST",
 url: PageURL+"Managers/ManagerEscrito",
 data: formData,
 contentType: false,
 processData: false,
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (DATA) { 
 if(DATA.success)
  { 
    closeescrito(); 
    updatedatalists(7,['#dtlagredd']);
    updatedatalists(8,['#dtldltedd']);
  }
 responses(DATA);},
 error: function(){return Alerta(txt.EELS,txt.E,2000);}
});
}


function dltedd(CodEsc,CodNot)
{
if(!validarparams(CodNot)) {return Alerta(txt.CTC,txt.W,2000);}
if(!validarint(CodEsc)) {return Alerta(txt.EELS,txt.E,2000);}

$.ajax({
 type: "POST",
 url: PageURL+"Managers/ManagerEscrito",
 data: {FUNC: 'dltedd', CodEsc: CodEsc, CodNot: CodNot},
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (DATA) {
 if(DATA.success){ updatedatalists(7,['#dtlagredd']); updatedatalists(8,['#dtldltedd']); }
 responses(DATA); },
 error: function(){return Alerta(txt.EELS,txt.E,2000);}
});
}


function AbrirDocumentosEscrito(IDD)
{
  if (!validarint(IDD)) {return Alerta(txt.EELS,txt.E,2000);}
  
    $.ajax({
      type: "POST",
      url: PageURL+"Managers/ManagerEscrito",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga  
      data: {FUNC: 'vescrito',IDD: IDD},
      dataType: "JSON",
      success: function (DATA) 
      { 
        DATA.success && DATA.CARTAS ? procesarCartas(DATA.CARTAS) : responses(DATA); 
      },
      error: function(){return Alerta(txt.EELS,txt.E,2000)}
    });
}


async function SendmailEscrito(nop) 
{
  if (!validarint(nop)) { return Alerta(txt.EELS,txt.W,2000);  }
    
  try {

   const { CC, CCLT } = await Getcc(nop, 3);
  
   if (!validaremailcl(CCLT) || typeof CC != 'object') {return Alerta(txt.EELS, txt.W, 2000);}

   const values = await ShowFormEmail(CC, CCLT);

   if (!values || typeof values != 'object' ) {return Alerta(txt.EELS, txt.W, 2000)} 

   $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerEmails",
    data: { FUNC: 'EDD', ENTITY: nop, CC: values },
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) {  
    if(res.success)
    {
      updatedatalists(8,['#dtldltedd']);
      updatedatalists(9,['#dtlagrrdgii'])  
      tablasejec('casos')
    } responses(res);
    },
    error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
 
  } catch (error) { return Alerta(error, txt.W, 2000); }
  }