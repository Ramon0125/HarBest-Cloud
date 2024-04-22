function agrnotif(IDCLT,FECHANOT,NONOT,TIPNOT,MOTIVNOT,CARTA,COMENTS = false)
{
if (validarparams(FECHANOT,NONOT,TIPNOT,MOTIVNOT)) 
{
 if (validarint(IDCLT)) 
 { 
    let formData = new FormData();
    formData.append('IDCLT', IDCLT);
    formData.append('FECHANOT', FECHANOT);
    formData.append('NONOT', NONOT);
    formData.append('TIPNOT', TIPNOT);
    formData.append('MOTIVNOT', MOTIVNOT);
    formData.append('CARTA', CARTA);
    formData.append('COMENTS', COMENTS ? COMENTS : 'SIN COMENTARIOS');
    formData.append('tipo','agrnotif');

    $.ajax({
        type: "POST",
        url: "../Managers/ManagerNotif.php",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2); }, //Ocultar pantalla de carga
        success: function (DATA) 
        {responses(DATA); tablasejec('notif');},
        error: function(){txt.EELS,txt.E,2000}
    });
 }
 else {res(txt.EELS,txt.W,2000)}
}

else 
{
 res(txt.CTC,txt.W,2000);
}
}


function vcarta(IDN)
{

  if (validarparams(IDN) && validarint(IDN)) 
  {
    $.ajax({
      type: "POST",
      url: "../Managers/ManagerNotif.php",
      data: {tipo: 'vcarta',IDN: IDN},
      dataType: "JSON",
      success: function (DATA) {

        if(DATA.success && DATA.TIPO && DATA.TIPO){

        let binaryString = atob(DATA.CARTA);

        let len = binaryString.length;
        let bytes = new Uint8Array(len);
        
        for (let i = 0; i < len; i++) { bytes[i] = binaryString.charCodeAt(i);}

        let blob = new Blob([bytes], {type: DATA.TIPO}); // Cambiar el tipo MIME según corresponda

        let url = URL.createObjectURL(blob);

        window.open(url, '_blank');
      }
      else{responses(DATA);}
      }
    });
  }
  else {res(txt.EELS,txt.E,2000)}

}