eventlisten('#btnagrprg','click',function(){ ADDPRG($('#slcntfprg1').val() ,$('#dateprg').val() ,$('#Comentsprg').val(),document.getElementById('Fileprg').files[0]);} );

async function ADDPRG(CodigoNotif,FechaPRG,ComentsPRG,ArchivoPRG)
{
if(!validarparams(CodigoNotif,FechaPRG,ComentsPRG) || !ArchivoPRG) { return Alerta(txt.CTC,txt.W,2000);}

if((ArchivoPRG.size / (1024 ** 2)) > maxfilesize){ return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG); }

if(!validaraño(FechaPRG.substring(0, 4))){ return Alerta(txt.IAV,txt.W,2000) }


try 
{
        let formData = new FormData();
        formData.append('tipo','addprg')
        formData.append('CodNot',CodigoNotif);
        formData.append('Fecha',FechaPRG);
        formData.append('Comentarios',ComentsPRG);
        formData.append('Archivo[]',ArchivoPRG);
        
        let response = await $.ajax({
            type: "POST",
            url: PageURL + "Managers/ManagerComplementos",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: () => load(1),
            complete: () => load(2),
        });
        
        if (response.success) 
        {
            closeescrito();
            updatedatalists(7, ['#dtlagredd']);
            updatedatalists(8, ['#dtldltedd']);
        }   responses(response);

} 
catch (error) { Alerta(txt.EELS, txt.E, 2000); }
}


async function sendmailprg(nop) 
{
  if (!validarint(nop)) { return Alerta(txt.EELS,txt.W,2000); }
    
  try {

   const { CC, CCLT } = await Getcc(nop, 2);
  
   if (!validaremailcl(CCLT) || typeof CC != 'object') {return Alerta(txt.EELS, txt.W, 2000);}

   const values = await ShowFormEmail(CC, CCLT);

   if (!values || typeof values != 'object' ) {return Alerta(txt.EELS, txt.W, 2000)} 

   $.ajax({
    type: "POST",
    url: PageURL + "Managers/ManagerEmails",
    data: { FUNC: 'DDC', ENTITY: nop, CC: values },
    dataType: "JSON",
    beforeSend: function () { load(1); }, // Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, // Ocultar pantalla de carga
    success: function (res) 
    {
      if (res.success) 
      {
        tablasejec('casos'); 
        updatedatalists(6, ['#dtldltddc']);
        updatedatalists(7,['#dtlagredd']);
      } responses(res);
    },
    error: function (){ return Alerta(txt.EELS, txt.W, 2000); }
   });  
 
  } catch (error) { return Alerta(error, txt.W, 2000); }
}