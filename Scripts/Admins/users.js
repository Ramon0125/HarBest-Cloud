function agrusr(privi,email, name, lastn) //Función para agregar un usuario
{
if (!validarparams(privi,name,lastn)) {return Alerta(txt.CTC, txt.W, 2000); } // Mostrar advertencia si faltan parámetros
if (!validaremail(email)){return Alerta(txt.ICV, txt.W, 2000);} // Mostrar advertencia si el correo electrónico no es válido

$.ajax({// Realizar una solicitud AJAX para agregar el usuario
type: 'POST',//Metodo en el que se enviaran los datos
beforeSend: function () { load(1); }, // Mostrar indicador de carga antes de enviar la solicitud
complete: function () { load(2); }, // Ocultar indicador de carga después de completar la solicitud
url: PageURL+'Managers/ManagerUser',//Direccion a la cual se enviaran los datos
data: { tipo: "addusr",Privi: privi, Email: email, Name: name, Lastn: lastn },//Datos que se enviaran
success: function (data){
if(data.success){
LimpiarModal(false,false,'#formagrusr'); 
updatedatalists(1,['#browser1','#browserdltusr'])
tablas('usrs');} responses(data); 
},// Manejar la respuesta del servidor
error: function (){Alerta(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}


function vd(id, token) // Función para obtener los detalles de un usuario
{
if (!validarparams(token) || !validarint(id) || id === 0) {return Alerta(txt.EELS, txt.E, 2000);}

 $.ajax({
 type: 'POST', //Metodo en el que se enviaran los datos
 url: PageURL+'Managers/ManagerUser',//Direccion a las que se enviaran los datos
 data: { tipo: "vdusr", ID: id, TOKEN: token },//Datos que se enviaran
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); },//Ocultar pantalla de carga
 success: function (data) {
 if (data.success) 
 {// Llenar los campos de edición con los detalles del usuario
 document.querySelector('#edtusremail').value = data.Email;
 document.querySelector('#edtusrname').value = data.Nombres;
 document.querySelector('#edtusrlastname').value = data.Apellidos;
 document.querySelector('#edtpassword').value = '';
 modifystyle(['#formedt','#btnedtusr'],'display','flex');
 }
 else {responses(data);}}, // Mostrar mensaje de error
 error: function () {Alerta(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}



function edtusr(id, name, email, nname, lastn, pass) // Función para editar un usuario
{
if (!validarparams(name,nname,lastn,pass)) {return Alerta(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
if (!validaremail(email)) {return Alerta(txt.ICV, txt.W, 2000);} // Mostrar advertencia si el correo electrónico no es válido
if (!validarint(id)){return Alerta(txt.EELS, txt.E, 2000);}

 $.ajax({
 type: 'POST',//Metodo en el que se enviaran los datos
 url: PageURL+'Managers/ManagerUser',//Direccion a la que se enviaran los datos
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); },//Ocultar pantalla de carga
 data: {tipo: "edtusr", id: id, name: name, email: email, nname: nname, lastn: lastn, pass: pass},//Datos que se enviaran
 success: function (data) {
 if(data.success)
 {
  LimpiarModal('#slcuser1',['#browser1','#formedt','#btnedtusr'],['#formedtusr','#formedt1']); 
  updatedatalists(1,['#browser1','#browserdltusr']);
  tablas('usrs');
 } responses(data);}, // Mostrar mensaje de error
 error: function () {Alerta(txt.EELS, "error", 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}


// Función para eliminar un usuario
function dltusr(id, name) 
{
 if (!validarparams(name)){ return Alerta(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
 if (!validarint(id)){return Alerta(txt.EELS, txt.E, 2000);}


 $.ajax({
 type: 'POST',//Metodo en el que se enviaran los datos
 url: PageURL+'Managers/ManagerUser',//Direccion a la que se enviaran los datos
 data: { tipo: "dltusr", id: id, name: name },//Datos que seran enviados
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (data) {
 if(data.success)
 {
    LimpiarModal('#slcdltuser1',['#browserdltusr','#btndltusr'],'#formdltusr'); 
    updatedatalists(1,['#browser1','#browserdltusr']);
    tablas('usrs');
 } responses(data);},
 error: function () {Alerta(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX  
}


function desusr(id) 
{
 if (!validarint(id)){return Alerta(txt.EELS, txt.E, 2000);}

 $.ajax({
 type: 'POST',//Metodo en el que se enviaran los datos
 url: PageURL+'Managers/ManagerUser',//Direccion a la que se enviaran los datos
 data: { tipo: "desusr", id: id},//Datos que seran enviados
 beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
 complete: function () { load(2); }, //Ocultar pantalla de carga
 success: function (data) {responses(data); tablas('usrblocks');},
 error: function () {Alerta(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX  
}