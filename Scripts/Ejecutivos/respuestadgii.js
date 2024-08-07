
eventlisten('#file-res-browser','click',function (){ 
  
    if ($('#file-res-browser').hasClass('delete')) 
    { 
      $('#FileRes').val('');
      $('#file-res-browser').text('Buscar');
      $('#file-res-browser').removeClass('delete');
    }
  
    else { $('#FileRes').click(); } 
});
  
  
eventlisten('#FileRes','change',function (){
  
    $('#file-res-browser').text('Quitar');
    $('#file-res-browser').addClass('delete');
  
});


function closeres()
{
    $('#FileRes').val('');
    $('#tipordgii').val('');
    $('#frdgii').val('');
    $('#file-res-browser').text('Buscar');
    $('#file-res-browser').removeClass('delete');
    LimpiarModal(['#slcntfrdgii1','#slcntfrdgii'],['#formrdgii','#btnagrrdgii'],['#formagrrdgii']);
}


function addres(CODNOT,FECHA,TIPO,ARCHIVORES)
{
if(!validarparams(CODNOT,FECHA,TIPO) || !ARCHIVORES) {return Alerta(txt.CTC,txt.W,2000);}

if((ARCHIVORES.size / (1024 ** 2)) > maxfilesize){return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}

if(!validaraño(FECHA.substring(0, 4))){return Alerta(txt.IAV,txt.W,2000)}

let formData = new FormData();

formData.append('FUNC','agrres')
formData.append('CodNot',CODNOT);
formData.append('Fecha',FECHA);
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