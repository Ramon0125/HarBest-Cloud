function agradm(name,direcc) 
{
 if (validarparams(name,direcc)) 
 {
  $.ajax({
      type: "POST", // Metodo en el que se enviaran los datos
      beforeSend: function () { load(1); }, // Mostrar indicador de carga antes de enviar la solicitud
      complete: function () { load(2); }, // Ocultar indicador de carga después de completar la solicitud
      url: "../Managers/ManagerAdm.php", // Direccion a la que se enviaran los datos
      data: {FUNC: "agradm", Name: name, Dire: direcc}, // Datos que seran enviados
      dataType: "JSON", // Formato que recibira los datos la peticion
      success: function (data) {if (data.success){
      LimpiarModal(['#nadm','#dadm']); 
      updatedatalists(3,['#Datalistagradm','#browseradmclt','#browseradmedtclt']);
      tablas('adms');
    } 
      responses(data);}, // Acciones para cuando la solicitud sea exitosa
      error: function(e) {console.log(e); res(txt.EELS,'warning',3000);} // Acciones para cuando la solicitud sea erronea    
  });
 } 
 
 else { res(txt.CTC,'warning',2000); }    
}



function edtadm(id,name,nname,ndirecc) 
{
 if (validarparams(id,name,nname,ndirecc)) 
 {
  $.ajax({
  type: "POST", // Metodo en el que se enviaran los datos
  beforeSend: function () { load(1); }, // Mostrar indicador de carga antes de enviar la solicitud
  complete: function () { load(2); }, // Ocultar indicador de carga después de completar la solicitud
  url: "../Managers/ManagerAdm.php", // Direccion a la que se enviaran los datos
  data: {FUNC: 'edtadm',id: id, name: name, nname: nname, ndirec: ndirecc}, // Datos que seran enviados
  dataType: "JSON", // Formato que recibira los datos la peticion
  success: function (data) 
  {if(data.success){
  LimpiarModal('#admedt1',['#formedtadm1','#Datalistagradm','#btnedtadm'],['#formedtclt11','#formedtadm']);
  updatedatalists(3,['#Datalistagradm','#browseradmclt','#browseradmedtclt']);}
  responses(data);
  tablas('adms')}, // Acciones para cuando la solicitud sea exitosa
  error: function() {res(txt.EELS,'warning',3000);} // Acciones para cuando la solicitud sea erronea 
  });
 }
  
 else { res(txt.CTC,'warning',2000); }
}