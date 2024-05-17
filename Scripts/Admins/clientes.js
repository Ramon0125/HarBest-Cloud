//Funcion para agregar clientes
function agrclt(rnc,email,nombre,adm) 
{
if(validarparams(rnc,email,nombre,adm)){//Verifica que los inputs contengan valores
 if(validaremailcl(email))
  {// Verifica que sea un correo valido
    if(validarint(rnc,adm))//Verifica que sea un rnc valido
    {
      $.ajax({
      type: 'POST',//Metodo en el que se enviaran los datos
      url: '../Managers/ManagerCliente.php',//Direccion a la que seran enviados los datos
      data: {FUNC:'agrclt', rnc: rnc, email: email, nombre: nombre, adm: adm},//Datos que seran enviados
      beforeSend: function () { load(1);},//Mostrar pantalla de carga durante la solicitud
      complete: function () { load(2);},//Ocultar pantalla de carga
      success: function (data) { responses(data);
      if(data.success)
      {
       LimpiarModal('#admclt1',false,'#formagrclt'); 
       updatedatalists(2,['#browseredtclt','#browserdltclt']);
       tablas('clts');
      }},
      error: function(){res(txt.EELS, txt.E,2000)}});   
    }
    else {res(txt.RNV, txt.W, 2000);}
  }
 else {res(txt.ICV, txt.W,2000)}
}
else {res(txt.CTC, txt.W,2000)}
}



// Función para obtener los detalles de un cliente
function vdclt(id, token) 
{
 $.ajax({
 type: 'POST',
 url: '../Managers/ManagerCliente.php',
 data: { FUNC: "vdclt", ID: id, TOKEN: token },
 beforeSend: function () {load(1);},
 complete: function () {load(2);},
 success: function (data) {
 if (data.success) { // Llenar los campos de edición con los detalles del usuario
 $('#rncedtclt').val(data.RNC);
 $('#edtcltemail').val(data.EMAIL_CLIENTE);
 $('#edtcltname').val(data.NOMBRE_CLIENTE);
 $('#admedtclt1').val(data.ID_ADM);
$('#admedtclt').val(data.NOMBRE_ADM);
 modifystyle(['#formedtclt1','#btnedtclt'],'display','block');} // Mostrar el formulario de edición
 else {responses(data);}}, // Mostrar mensaje de error        
 error: function () {res(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}


//Funcion que edita clientes
function edtclt(id,nc,rnc,email,nombre,adm) 
{
if(validarparams(id,nc,rnc,email,nombre,adm)) //Funcion que valida que los inputs contengan valores
{
 if(validaremailcl(email))
 {//Funcion que valida el email
    if(validarint(rnc))
    {//Funcion que valida el rnc
        $.ajax({
        type: 'POST',//Metodo en el que seran enviados los datos
        url: '../Managers/ManagerCliente.php',//Direccion a la que seran enviados los datos
        data: {FUNC:'edtclt', id: id, nc: nc, rnc: rnc, email: email, nombre: nombre, adm: adm},//Datos que seran enviados
        beforeSend: function () { load(1);},//Mostrar pantalla de carga durante la solicitud
        complete: function () { load(2);},//Ocultar pantalla de carga
        success: function (data) {
        if (data.success) {LimpiarModal(['#slcclt1','#admedtclt1'],['#browseredtclt','#formedtclt1','#btnedtclt'],['#formedtclt','#formedtclt11']); updatedatalists(2,['#browseredtclt','#browserdltclt']);}
        responses(data);
        tablas('clts');}, // Mostrar mensaje de error
        error: function (){res(txt.EELS, txt.E,2000)}});
    }
    
    else {res(txt.RNV, txt.W, 2000);}
 }

 else {res(txt.ICV, txt.W,2000)}
}

else {res(txt.CTC, txt.W,2000)}
}


// Función para eliminar un usuario
function dltclt(id, name) 
{
 if (validarparams(id,name)) 
 {//Funcion que verifica si los inputs contienen valores
  $.ajax({
  type: 'POST',//Metodo en el que seran enviados los datos
  url: '../Managers/ManagerCliente.php',//Direccion a la que seran enviados los datos
  data: { FUNC: "dltclt", id: id, name: name },//Datos que seran enviados
  beforeSend: function() { load(1); },//Muestra la pantalla de carga durante la solicitud
  complete: function () { load(2); },//Oculta la pantalla de carga
  success: function (data) {
  if (data.success) {LimpiarModal('#slcdltclt1',['#browserdltclt','#btndltclt'],'#formdltclt'); updatedatalists(2,['#browseredtclt','#browserdltclt']);}  // Mostrar mensaje de éxito
  responses(data); tablas('clts');}, // Mostrar mensaje de error
  error: function () {res(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
 } 
  
 else { res(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
}