function agrusr(email, name, lastn) //Función para agregar un usuario
{
if (validarparams(email,name,lastn)) 
{//Esto verifica que los campos tengan contenidos 
if (validaremail(email)) {//Esto valida el email

$.ajax({// Realizar una solicitud AJAX para agregar el usuario
type: 'POST',//Metodo en el que se enviaran los datos
beforeSend: function () { load(1); }, // Mostrar indicador de carga antes de enviar la solicitud
complete: function () { load(2); }, // Ocultar indicador de carga después de completar la solicitud
url: '../Managers/ManagerUser.php',//Direccion a la cual se enviaran los datos
data: { tipo: "addusr", Email: email, Name: name, Lastn: lastn },//Datos que se enviaran
success: function (data){if(data.success){LimpiarModal(false,false,'#formagrusr'); updatedatalists(1,['#browser1','#browserdltusr'])}
responses(data); tablas('usrs');
},// Manejar la respuesta del servidor
error: function (){res(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
}
else {res(txt.ICV, txt.W, 2000);} // Mostrar advertencia si el correo electrónico no es válido
} 
else { res(txt.CTC, txt.W, 1460); } // Mostrar advertencia si faltan parámetros
}



function vd(id, token) // Función para obtener los detalles de un usuario
{
if (validarparams(id,token) && validarint(id)) 
{
    $.ajax({
    type: 'POST', //Metodo en el que se enviaran los datos
    url: '../Managers/ManagerUser.php',//Direccion a las que se enviaran los datos
    data: { tipo: "vdusr", ID: id, TOKEN: token },//Datos que se enviaran
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); },//Ocultar pantalla de carga
    success: function (data) {
    if (data.success) 
    {// Llenar los campos de edición con los detalles del usuario
    document.querySelector('#edtusremail').value = data.EMAIL;
    document.querySelector('#edtusrname').value = data.NOMBRE;
    document.querySelector('#edtusrlastname').value = data.APELLIDOS;
    document.querySelector('#edtpassword').value = '********';
    modifystyle(['#formedt','#btnedtusr'],'display','block');
    }                    
    else {responses(data);}}, // Mostrar mensaje de error
    error: function () {res(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
} 
else {res(txt.EELS, txt.E, 2000);}
}



function edtusr(id, name, email, nname, lastn, pass) // Función para editar un usuario
{
if (validarparams(id,name,email,nname,lastn,pass)) 
{//Verifica que los inputs tengan contenidos

    if (validaremail(email)) {//Verifica que el correo esta valido
    $.ajax({
    type: 'POST',//Metodo en el que se enviaran los datos
    url: '../Managers/ManagerUser.php',//Direccion a la que se enviaran los datos
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); },//Ocultar pantalla de carga
    data: { tipo: "edtusr", id: id, name: name, email: email, nname: nname, lastn: lastn, pass: pass },//Datos que se enviaran
    success: function (data) {
    if(data.success){LimpiarModal('#slcuser1',['#browser1','#formedt','#btnedtusr'],['#formedtusr','#formedt1']); updatedatalists(1,['#browser1','#browserdltusr']);}
    responses(data); tablas('usrs');}, // Mostrar mensaje de error
    error: function () {res(txt.EELS, "error", 2000);}});} // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
                
    else {res(txt.ICV, txt.W, 2000);} // Mostrar advertencia si el correo electrónico no es válido
        
}
else { res(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
}


// Función para eliminar un usuario
function dltusr(id, name) 
{
    if (validarparams(id,name)) 
    {//Verifica que los inputs contengan valores
    $.ajax({
    type: 'POST',//Metodo en el que se enviaran los datos
    url: '../Managers/ManagerUser.php',//Direccion a la que se enviaran los datos
    data: { tipo: "dltusr", id: id, name: name },//Datos que seran enviados
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (data) {
    if(data.success){LimpiarModal('#slcdltuser1',['#browserdltusr','#btndltusr'],'#formdltusr'); updatedatalists(1,['#browser1','#browserdltusr']);}
    responses(data); tablas('usrs');},
    error: function () {res(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX  
    } 
    
    else {res(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
}


function desusr(id) 
{
    if (validarparams(id)) 
    {//Verifica que los inputs contengan valores
    $.ajax({
    type: 'POST',//Metodo en el que se enviaran los datos
    url: '../Managers/ManagerUser.php',//Direccion a la que se enviaran los datos
    data: { tipo: "desusr", id: id},//Datos que seran enviados
    beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    complete: function () { load(2); }, //Ocultar pantalla de carga
    success: function (data) {responses(data); tablas('usrblocks');},
    error: function () {res(txt.EELS, txt.E, 2000);}}); // Mostrar mensaje de error en caso de fallo en la solicitud AJAX  
    } 
    
    else {res(txt.CTC, txt.W, 1460);} // Mostrar advertencia si faltan parámetros
}