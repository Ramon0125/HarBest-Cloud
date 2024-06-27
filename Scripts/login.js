$(document).ready(function(){
	var formInputs = $('input[type="email"],input[type="password"]');
	
	formInputs.focus(function() { $(this).removeAttr('readonly'); $(this).parent().children('label.formLabel').addClass('formTop'); });

	formInputs.blur(function() { if ($.trim($(this).val()).length == 0){ $(this).parent().children('label.formLabel').removeClass('formTop'); }});
	
	$('label.formLabel').click(function(){ $(this).parent().children('.form-style').focus();});

});


// Función para mostrar/ocultar contraseña
function visor(inputElement) { 
inputElement.type = inputElement.type == 'text' ? 'password' : 'text'; 
}


// Función para validar el inicio de sesion
function InicioSesion(event,Email, Password) 
{ event.preventDefault();
if (!validarparams(Email, Password)) {return res(txt.CTC, txt.W, 2000);} //Esto verifica si los inputs no estan vacios

if(!validaremail(Email))  {return res(txt.ICV, txt.W, 2000); } //Esto valida que el correo sea correcto

    $.ajax({
    type: 'POST',//Metodo en el que se enviaran los datos
    url: PageURL+'Managers/ManagerInicioSesion.php',//Direccion a la que se enviaran los datos
    data: { email: Email, password: Password, tipo: "iniusr" },//Datos que seran enviados
	beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    success: function (data){ 
    if (data.success)
    {
    if(data.CCLAVE === 'T')
    {
	  var url = PageURL+'Views/?Notificacion=' + encodeURIComponent(txt.SIC);
      window.location.href = url;
    }
    else {modifystyle('#modalpass','display','block');  modifystyle('#form','display','none'); load(2);}
	} 
    else {load(2); responses(data);}},
    error: function () {res(txt.EELS, 'error', 2000);}});
}


// Función para modificar la contraseña
function MdfPass(event,p, p2) { event.preventDefault();
	if (p !== p2){return res(txt.LCC, txt.E, 1450); }//Esto verifica si las contraseñas son iguales 
	
	if (!validarparams(p)) {return res(txt.CTC, txt.W, 1450); } //Esto verifica si las contraseñas no estan vacias
	  
	$.ajax({
	type: 'POST',//Metodo en el que se enviaran los datos
	url: PageURL+'Managers/ManagerInicioSesion.php',//Direccion a la que se enviaran los datos
	data: { tipo: "mdfpass", passwordn1: p },//Datos que seran enviados
	beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
	success: function (data) {
	if (data.success) {var url = './Views/?Notificacion=' + encodeURIComponent(txt.CMC);
	window.location.href = url;}
	else{load(2); responses(data); }},
	error: function () {res(txt.EELS, txt.E, 2000);}});


  }