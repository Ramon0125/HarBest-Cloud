eventlisten('#ContainerRES','click',
  function () { 
      
      if($('#ContainerRES').hasClass('has'))
      {
          $('#FileRes').val('');
          $('#ContainerRES').removeClass('has');
          $('#Spanres').text('Buscar');
          modifystyle(['#Spanres'],'color','green');
      }
      
      else{ $('#FileRes').click(); }
  }
  );
  
  eventlisten('#FileRes','change',
  function () { 
      
      if($('#FileRes')[0].files.length > 0)
      {
          $('#ContainerRES').addClass('has');
          $('#Spanres').text('Quitar');
          modifystyle(['#Spanres'],'color','red');
      }
      
      else
      { $('#ContainerRES').removeClass('has');
        $('#Spanres').text('Buscar');
        modifystyle(['#Spanres'],'color','green');
      }
  }
  );


function closeres()
{
    $('#FileRes').val('');
    $('#tipordgii').val('');
    $('#frdgii').val('');
    $('#ComentsRes').val('');
    $('#Spanres').text('Buscar');
    $('#ContainerRES').removeClass('has');
    modifystyle(['#Spanres'],'color','green');
    LimpiarModal(['#slcntfrdgii1','#slcntfrdgii'],['#formrdgii','#btnagrrdgii'],['#formagrrdgii']);
}


function addres(CODNOT,FECHA,COMENTARIOS,TIPO,ARCHIVORES)
{
if(!validarparams(CODNOT,FECHA,TIPO,COMENTARIOS) || !ARCHIVORES) {return Alerta(txt.CTC,txt.W,2000);}

if((ARCHIVORES.size / (1024 ** 2)) > maxfilesize){return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}

if(!validaraño(FECHA.substring(0, 4))){return Alerta(txt.IAV,txt.W,2000)}

let formData = new FormData();

formData.append('FUNC','agrres')
formData.append('CodNot',CODNOT);
formData.append('Fecha',FECHA);
formData.append('Coments',COMENTARIOS);
formData.append('Tipo',TIPO);

formData.append('Archivo[]',ARCHIVORES);

$.ajax({
 type: "POST",
 url: PageURL+"Managers/ManagerRes",
 data: formData,
 contentType: false,
 processData: false,
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (DATA) 
 { 
 if(DATA.success)
    { 
     closeres(); 
     updatedatalists(9,['#dtlagrrdgii']);
     updatedatalists(10,['#dtldltrdgii']); 
    }responses(DATA);
 },
 error: function(){return Alerta(txt.EELS,txt.E,2000);}
});
}


function dltrdgii(CodRes,CodNot)
{
if(!validarparams(CodNot)) {return Alerta(txt.CTC,txt.W,2000);}
if(!validarint(CodRes)) {return Alerta(txt.EELS,txt.E,2000);}

$.ajax({
 type: "POST",
 url: PageURL+"Managers/ManagerRes",
 data: {FUNC: 'dltres', CodRes: CodRes, CodNot: CodNot},
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (DATA) {
 if(DATA.success){ updatedatalists(9,['#dtlagrrdgii']); updatedatalists(10,['#dtldltrdgii']); }
 responses(DATA); },
 error: function(e){console.log(e);
  return Alerta(txt.EELS,txt.E,2000);}
});
}


function AbrirDocumentosRespuesta(IDD)
{
  if (!validarint(IDD)) {return Alerta(txt.EELS,txt.E,2000);}
  
    $.ajax({
      type: "POST",
      url: PageURL+"Managers/ManagerRes",
      beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2); }, //Ocultar pantalla de carga  
      data: {FUNC: 'vrespuesta',IDD: IDD},
      dataType: "JSON",
      success: function (DATA) 
      { 
        DATA.success && DATA.CARTAS ? procesarCartas(DATA.CARTAS) : responses(DATA); 
      },
      error: function(){return Alerta(txt.EELS,txt.E,2000)}
    });
}


async function SendmailRespuesta(nop) 
{
  if (!validarint(nop)) { return Alerta(txt.EELS,txt.W,2000);  }
    
  try {

   const { CC, CCLT } = await Getcc(nop, 4);
  
   if (!validaremailcl(CCLT) || typeof CC != 'object') {return Alerta(txt.EELS, txt.W, 2000);}

   const values = await ShowFormEmail(CC, CCLT);

   if (!values || typeof values != 'object' ) {return Alerta(txt.EELS, txt.W, 2000)} 

   $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerEmails",
    data: { FUNC: 'RDGII', ENTITY: nop, CC: values },
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) {  
    if(res.success)
    {
      updatedatalists(10,['#dtldltrdgii']);  
      tablasejec('casos')
    } responses(res);
    },
    error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
 
  } catch (error) { return Alerta(error, txt.W, 2000); }
  }