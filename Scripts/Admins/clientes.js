$(document).ready(function () { OnlyNumber('#rncagrclt'); OnlyNumber('#telddc'); });

//Funcion para agregar clientes
function agrclt(rnc, email, nombre, tipo, tipo2, adm) 
{
if(!validarparams(nombre,adm) || !tipo.checked && !tipo2.checked) {return Alerta(txt.CTC, txt.W,2000);}//Verifica que los inputs contengan valores
 
if(!validaremailcl(email)) {return Alerta(txt.ICV, txt.W,2000);} // Verifica que sea un correo valido
    
if(!validarint(rnc) || rnc.length < 10) {return Alerta(txt.RNV, txt.W, 2000);}//Verifica que sea un rnc valido

if(!validarint(adm)){return Alerta(txt.EELS, txt.W,3000);}

let Tipopersona = tipo.checked ? tipo.value : tipo2.value;

  $.ajax({
  type: 'POST',//Metodo en el que se enviaran los datos
  url: PageURL+'Managers/ManagerCliente',//Direccion a la que seran enviados los datos
  data: {FUNC:'agrclt', rnc: rnc, email: email, nombre: nombre, tipopersona:Tipopersona, adm: adm},//Datos que seran enviados
  beforeSend: function () { load(1);},//Mostrar pantalla de carga durante la solicitud
  complete: function () { load(2);},//Ocultar pantalla de carga
  success: function (data) {
  if(data.success)
  {
   LimpiarModal('#admclt1',false,'#formagrclt'); 
   updatedatalists(2,['#browseredtclt','#browserdltclt']);
   tablas('clts');
  } responses(data); },
  error: function(){Alerta(txt.EELS, txt.E,2000)}});
}


// Función para obtener los detalles de un cliente
function vdclt(id,token) 
{
if(!validarparams(token)) {return Alerta(txt.CTC, txt.W,2000);}
if(!validarint(id)){return Alerta(txt.EELS, txt.E,2000);}

 $.ajax({
 type: 'POST',
 url: PageURL+'Managers/ManagerCliente',
 data: { FUNC: "vdclt", ID: id, TOKEN: token },
 beforeSend: function () {load(1);},
 complete: function () {load(2);},
 success: function (data) {
 if (data.success) { // Llenar los campos de edición con los detalles del usuario
 $('#rncedtclt').val(data.RNC);
 $('#edtcltemail').val(data.EmailCliente);
 $('#edtcltname').val(data.NombreCliente);
 $('#admedtclt1').val(data.IDADM);
 $('#admedtclt').val(data.NombreADM);
 $( data.TipoCliente == 'Fisica' ? '#Tipedtclt' : '#Tipedtclt1').prop('checked', true);
 modifystyle(['#formedtclt1','#btnedtclt'],'display','block');} // Mostrar el formulario de edición
 else {responses(data);}}, // Mostrar mensaje de error        
 error: function () {Alerta(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}


//Funcion que edita clientes
function edtclt(id,nc,rnc,email,nombre,tipo,tipo2,adm) 
{
if(!validarparams(nc,nombre) || id === 0 || adm === 0 || !tipo.checked && !tipo2.checked){ return Alerta(txt.CTC, txt.W,2000);} //Funcion que valida que los inputs contengan valores

if(!validaremailcl(email)){ return Alerta(txt.ICV, txt.W,2000);} //Funcion que valida el email
    
if(!validarint(rnc)){ return Alerta(txt.RNV, txt.W, 2000);} //Funcion que valida el rnc

if(!validarint(id,adm)){return Alerta(txt.EELS, txt.W,3000);}

let Tipopersona = tipo.checked ? tipo.value : tipo2.value;

 $.ajax({
 type: 'POST',//Metodo en el que seran enviados los datos
 url: PageURL+'Managers/ManagerCliente',//Direccion a la que seran enviados los datos
 data: {FUNC:'edtclt', id: id, nc: nc, rnc: rnc, email: email, nombre: nombre, tipopersona:Tipopersona ,adm: adm},//Datos que seran enviados
 beforeSend: function () { load(1);},//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2);},//Ocultar pantalla de carga
 success: function (data) {
 if (data.success) 
 {
 LimpiarModal(['#slcclt1','#admedtclt1'],['#browseredtclt','#formedtclt1','#btnedtclt'],['#formedtclt','#formedtclt11']); 
 updatedatalists(2,['#browseredtclt','#browserdltclt']);
 tablas('clts');
 } responses(data); },
 error: function (){Alerta(txt.EELS, txt.E,2000)}}); // Mostrar mensaje de error
}


// Función para eliminar un usuario
function dltclt(id, name) 
{
 if(!validarparams(name)) {return Alerta(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
 if(!validarint(id)){return Alerta(txt.EELS, txt.E,2000);}

  $.ajax({
  type: 'POST',//Metodo en el que seran enviados los datos
  url: PageURL+'Managers/ManagerCliente',//Direccion a la que seran enviados los datos
  data: { FUNC: "dltclt", id: id, name: name },//Datos que seran enviados
  beforeSend: function() { load(1); },//Muestra la pantalla de carga durante la solicitud
  complete: function () { load(2); },//Oculta la pantalla de carga
  success: function (data) {
  if (data.success) {
  LimpiarModal('#slcdltclt1',['#browserdltclt','#btndltclt'],'#formdltclt'); 
  updatedatalists(2,['#browseredtclt','#browserdltclt']);
  tablas('clts');} responses(data);  // Mostrar mensaje de éxito
  },
  error: function () {Alerta(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}