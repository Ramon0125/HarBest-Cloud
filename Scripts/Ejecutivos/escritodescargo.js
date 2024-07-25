function closeescrito()
{
    $('#FileEscrito').val('');
    $('#file-browser').text('Buscar');
    $('#file-browser').removeClass('delete');
    LimpiarModal(['#slcntfedd1','#slcntfedd'],['#formEDD','#btnagredd'],['#formagrddc1']);
}


function addedd(CODNOT,ARCHIVOSEDD)
{
if(!validarparams(CODNOT) || !ARCHIVOSEDD) {return Alerta(txt.CTC,txt.W,2000);}

if ((ARCHIVOSEDD.size / (1024 ** 2)) > maxfilesize){return Alerta(txt.AMGR1, txt.W, false, true, txt.AMG);}

let formData = new FormData();

formData.append('FUNC','agredd')

formData.append('CodNot',CODNOT);

formData.append('Archivo[]',ARCHIVOSEDD);

$.ajax({
 type: "POST",
 url: PageURL+"Managers/ManagerEscrito.php",
 data: formData,
 contentType: false,
 processData: false,
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (DATA) { 
 if(DATA.success){ closeescrito(); updatedatalists(7,['#dtlagredd']); }
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
 url: PageURL+"Managers/ManagerEscrito.php",
 data: {FUNC: 'dltedd', CodEsc: CodEsc, CodNot: CodNot},
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (DATA) {
 if(DATA.success){ updatedatalists(7,['#dtlagredd']); updatedatalists(8,['#dtldltedd']); }
 responses(DATA); },
 error: function(){return Alerta(txt.EELS,txt.E,2000);}
});
}