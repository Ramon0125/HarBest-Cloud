Object.prototype.ToContainerFile = function() 
{
    const keys = Object.keys(this);
    
    if (keys.length !== 3){console.error('It should accept 3 arguments.');}
    keys.forEach(str => { if(!/[^#12]/.test(str) || typeof str !== 'string'){ return console.error('You must enter 3 IDs with the `#` sign in front, for example: `(\'#container\', \'#input\', \'#span\');`.') } });
     
    const Container = keys[0];
    const Input = keys[1];
    const Span = keys[2];
    const Type = keys[3];


    const Type1 = () => {
        
        if(!$(Container).hasClass('upload-container') || $(Container).prop('tagName').toLowerCase() != 'div')
        {
            console.error('The container is not valid.'); 
            return null;
        }

        if(!$(Input).prop('tagName').toLowerCase() != 'input')
        {
            console.error('The input is not valid.'); 
            return null;
        }

        if(!$(Span).prop('tagName').toLowerCase() != 'span')
        {
            console.error('The Span is not valid.'); 
            return null;
        }

        eventlisten(Container,'click',function(){
            if($(Container).hasClass('has'))
            {
                $(Input).val('');
                $(Container).removeClass('has');
                $(Span).text('Buscar');
                modifystyle([Span],'color','green');
            }
            
            else{ $(Input).click(); }
        });

        eventlisten(Input,'change',function(){   
            if ($(Input)[0].files.length > 0)
            {
                $(Container).addClass('has');
                $(Span).text('Quitar');
                modifystyle([Span],'color','red');
            }
            
            else 
            {   
                $(Container).removeClass('has');
                $(Span).text('Buscar');
                modifystyle([Span],'color','green');
            }
        });
    };


    const Type2 = () => {

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
    }
}

eventlisten('#btnagrprg','click',
    () => { ADDPRG($('#slcntfprg1').val() ,$('#dateprg').val() ,$('#Comentsprg').val(),document.getElementById('Fileprg').files[0]);}
);


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

        console.log(response);
        
        if (response.success) 
        {
            closeescrito();
            updatedatalists(7, ['#dtlagredd']);
            updatedatalists(8, ['#dtldltedd']);
        }   responses(response);

} 
catch (error) { Alerta(txt.EELS, txt.E, 2000); }
}