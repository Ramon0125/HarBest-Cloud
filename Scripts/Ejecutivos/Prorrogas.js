ToInputFile('#Fileprg','#ContainerFileprg','#fiiconprg','#Spanprg','#labelFileprg');
eventlisten('#btnagrprg','click',function(){ ADDPRG($('#slcntfprg1').val() ,$('#dateprg').val() ,$('#Comentsprg').val(),document.getElementById('Fileprg').files[0]);} );
eventlisten('#btndltprg','click',function(){ DLTPRG( $('#slcdltprg1').val(), $('#slcdltprg').val()) })

const CloseAddprg = () =>
{
$('#labelFileprg').text('Archivo de prorroga');
$('#Spanprg').text('Buscar archivo(s)');
$('#fiiconprg').removeClass('bi-x-circle');
$('#fiiconprg').addClass('bi-arrow-up-circle');

LimpiarModal(['#slcntfprg','#slcntfprg1','#dateprg','#Fileprg','#Comentsprg'],['#Containeragrprg','#btnagrprg'],false);
}


function ADDPRG(CodigoNotif,FechaPRG,ComentsPRG,ArchivoPRG)
{
if(!validarparams(CodigoNotif,FechaPRG,ComentsPRG) || !ArchivoPRG) { return Alerta(txt.CTC,txt.W,2000);}

if((ArchivoPRG.size / (1024 ** 2)) > maxfilesize){ return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG); }

if(!validaraño(FechaPRG.substring(0, 4))){ return Alerta(txt.IAV,txt.W,2000) }

let formData = new FormData();
formData.append('tipo','addprg')
formData.append('CodNot',CodigoNotif);
formData.append('Fecha',FechaPRG);
formData.append('Comentarios',ComentsPRG);
formData.append('Archivo[]',ArchivoPRG);
        
$.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerComplementos",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: () => load(1),
    complete: () => load(2),
    success: function (response)
    { 
      if (response.success) 
        {
            CloseAddprg();
            updatedatalists(5,['#dtlagrddc']);
            updatedatalists(7,['#dtlagredd']);
            updatedatalists(9,['#dtlagrrdgii']);
            updatedatalists(11, ['#dtlagrprg']);
            updatedatalists(12, ['#dtlsendprg','#dtldltprg']);        
        }   responses(response);
    },
    error: function(){return Alerta(txt.EELS, txt.W, 2000);}
});
}



async function sendmailprg(nop) 
{
  if (!validarint(nop)) { return Alerta(txt.EELS,txt.W,2000); }
    
  try {

    $('#sendprorrogas').modal('hide');
    LimpiarModal(['#slcsendprg','#slcsendprg1'],'#btnsendprg',false);

   const { CC, CCLT } = await Getcc(nop, 5);
  
   if (!validaremailcl(CCLT) || typeof CC != 'object') {return Alerta(txt.EELS, txt.W, 2000);}

   const values = await ShowFormEmail(CC, CCLT);

   if (!values || typeof values != 'object' ) {return Alerta(txt.EELS, txt.W, 2000)}
   
   $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerEmails",
    data: { FUNC: 'PRG', ENTITY: nop, CC: values },
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) 
    {
      if (res.success) 
      {
        updatedatalists(5,['#dtlagrddc']);
        updatedatalists(7,['#dtlagredd']);
        updatedatalists(9,['#dtlagrrdgii']);
        updatedatalists(11, ['#dtlagrprg']);
        updatedatalists(12, ['#dtlsendprg','#dtldltprg']);        

      } responses(res);
    },
    error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
 
  } catch (error) { return Alerta(error, txt.W, 2000); }
}


function DLTPRG(idp,non)
{
  if (!validarparams(non)){return Alerta(txt.CTC,txt.W,2000);}
    
  if (!validarint(idp)) { return Alerta(txt.EELS,txt.W,2000);}

    $.ajax({
    type: "POST",
    url: PageURL+"Managers/ManagerComplementos",
    data: {tipo:'dltprg', IDP:idp, COD:non},
    dataType: "JSON",
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (response)
    { 
      if (response.success) 
        {
            LimpiarModal(['#slcdltprg','#slcdltprg'],['#btndltprg'],false);
            updatedatalists(5,['#dtlagrddc']);
            updatedatalists(7,['#dtlagredd']);
            updatedatalists(9,['#dtlagrrdgii']);
            updatedatalists(11, ['#dtlagrprg']);
            updatedatalists(12, ['#dtlsendprg','#dtldltprg']);        

        }   responses(response);
    },
    error: function(){return Alerta(txt.EELS,txt.E,2000);}
    });
    
}