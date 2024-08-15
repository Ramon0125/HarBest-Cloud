$(document).ready(function(){
	
	let formInputs = $('input[type="email"],input[type="password"]');
	
	formInputs.focus(function() { $(this).removeAttr('readonly'); $(this).parent().children('label.formLabel').addClass('formTop'); });

	formInputs.blur(function() { if ($.trim($(this).val()).length == 0){ $(this).parent().children('label.formLabel').removeClass('formTop'); }});
	
	$('label.formLabel').click(function(){ $(this).parent().children('.form-style').focus();});
});


// Función para mostrar/ocultar contraseña
function visor(inputElement) { inputElement.type = inputElement.type == 'text' ? 'password' : 'text';  }


// Función para validar el inicio de sesion
function InicioSesion(event,Email, Password) 
{ event.preventDefault();

if (!validarparams(Email, Password)) {return Alerta(txt.CTC, txt.W, 2000);} //Esto verifica si los inputs no estan vacios

if(!validaremail(Email))  {return Alerta(txt.ICV, txt.W, 2000); } //Esto valida que el correo sea correcto

$.ajax({
type: 'POST',//Metodo en el que se enviaran los datos
url: PageURL+'Managers/ManagerInicioSesion',//Direccion a la que se enviaran los datos
data: { email: Email, password: Password, tipo: "iniusr" },//Datos que seran enviados
beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
success: function (data){ 
if (!data.success) { load(2); return responses(data);}
else
{
if(data.CCLAVE === 'T')
{ window.location.href = PageURL+'Views/?Notificacion=' + encodeURIComponent(txt.SIC); }
else 
{ 
 modifystyle('#modalpass','display','block'); 
 modifystyle('#form','display','none'); 
 load(2);
}
}},
error: function () {Alerta(txt.EELS,txt.E, 2000);}
});
}


// Función para modificar la contraseña
function MdfPass(event,p, p2) 
{ 
  event.preventDefault();
  
  if (!validarparams(p,p2)) {return Alerta(txt.CTC, txt.W, 1450); } //Esto verifica si las contraseñas no estan vacias

  if (p !== p2){return Alerta(txt.LCC, txt.E, 1450); }//Esto verifica si las contraseñas son iguales 

  if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(p))
  {
	return Alerta(false,txt.E,false,true,'Contraseña no valida',`Por favor, asegúrate de que tu contraseña:
			<ul style="text-align: left;">
			  <li>Contenga al menos 8 caracteres.</li>
			  <li>Incluya al menos una letra minúscula (a-z).</li>
			  <li>Incluya al menos una letra mayúscula (A-Z).</li>
			  <li>Incluya al menos un número (0-9).</li>
			</ul>`);
  }
	
  $.ajax({
  type: 'POST',//Metodo en el que se enviaran los datos
  url: PageURL+'Managers/ManagerInicioSesion',//Direccion a la que se enviaran los datos
  data: { tipo: "mdfpass", passwordn1: p },//Datos que seran enviados
  beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
  success: function (data) {
  if (data.success)
  {window.location.href = PageURL+'Views/?Notificacion=' + encodeURIComponent(txt.CMC);}
  else{load(2); responses(data); }},
  error: function () {Alerta(txt.EELS, txt.E, 2000);}});
  }