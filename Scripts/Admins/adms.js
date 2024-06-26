function agradm(name,direcc) 
{
 if (!validarparams(name,direcc)) 
 {return res(txt.CTC, txt.W,2000);}

  $.ajax({
      type: "POST", // Metodo en el que se enviaran los datos
      beforeSend: function () { load(1); }, // Mostrar indicador de carga antes de enviar la solicitud
      complete: function () { load(2); }, // Ocultar indicador de carga después de completar la solicitud
      url: PageURL+'Managers/ManagerAdm.php', // Direccion a la que se enviaran los datos
      data: {FUNC: "agradm", Name: name, Dire: direcc}, // Datos que seran enviados
      dataType: "JSON", // Formato que recibira los datos la peticion
      success: function (data) {
      if (data.success)
      {
      LimpiarModal(['#nadm','#dadm']); 
      updatedatalists(3,['#Datalistagradm','#browseradmclt','#browseradmedtclt']);
      tablas('adms');
      }
      responses(data);}, // Acciones para cuando la solicitud sea exitosa
      error: function() {res(txt.EELS, txt.W,3000);} // Acciones para cuando la solicitud sea erronea    
  });   
}


function edtadm(id,name,nname,ndirecc) 
{
 if (!validarparams(name,nname,ndirecc) || id === 0) {return res(txt.CTC, txt.W,2000);}
 if (!validarint(id)){return res(txt.EELS, txt.W,3000);}

  $.ajax({
  type: "POST", // Metodo en el que se enviaran los datos
  beforeSend: function () { load(1); }, // Mostrar indicador de carga antes de enviar la solicitud
  complete: function () { load(2); }, // Ocultar indicador de carga después de completar la solicitud
  url: PageURL+'./Managers/ManagerAdm.php', // Direccion a la que se enviaran los datos
  data: {FUNC: 'edtadm',id: id, name: name, nname: nname, ndirec: ndirecc}, // Datos que seran enviados
  dataType: "JSON", // Formato que recibira los datos la peticion
  success: function (data) 
  {if(data.success){
  LimpiarModal('#admedt1',['#formedtadm1','#Datalistagradm','#btnedtadm'],['#formedtclt11','#formedtadm']);
  updatedatalists(3,['#Datalistagradm','#browseradmclt','#browseradmedtclt']);  tablas('adms');}
  responses(data);}, // Acciones para cuando la solicitud sea exitosa
  error: function() {res(txt.EELS, txt.W,3000);} // Acciones para cuando la solicitud sea erronea 
  });
}