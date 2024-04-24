$(document).ready(function(){
	var formInputs = $('input[type="email"],input[type="password"]');
	
	formInputs.focus(function() { $(this).removeAttr('readonly'); $(this).parent().children('label.formLabel').addClass('formTop'); });

	formInputs.blur(function() { if ($.trim($(this).val()).length == 0){ $(this).parent().children('label.formLabel').removeClass('formTop'); }});
	
	$('label.formLabel').click(function(){ $(this).parent().children('.form-style').focus();});

});


// Función para mostrar/ocultar contraseña
function visor(inputElement) { inputElement.type = inputElement.type == 'password' ? 'text' : 'password'; }


// Función para validar el inicio de sesion
function InicioSesion(Email, Password) 
{
if (validarparams(Email, Password)) //Esto verifica si los inputs no estan vacios
{
if(validaremail(Email)) //Esto valida que el correo sea correcto
  {   
    $.ajax({
    type: 'POST',//Metodo en el que se enviaran los datos
    url: './Managers/ManagerInicioSesion.php',//Direccion a la que se enviaran los datos
    data: { email: Email, password: Password, tipo: "iniusr" },//Datos que seran enviados
	beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
    success: function (data){ 
    if (data.success)
    {
    if(data.message === 'a')
    { var url = './Views/?Notificacion=' + encodeURIComponent(txt.SIC);
      window.location.href = url;
    }
    else {modifystyle('#modalpass','display','block');  modifystyle('#form','display','none'); load(2);}
	} 
    else {responses(data); load(2);}},
    error: function () {res(txt.EELS, 'error', 2000);}});
  }
  else { res(txt.ICV, "warning", 2000, false, false); }
}
else { res(txt.CTC, "warning", 2000, false, false); }
}


// Función para modificar la contraseña
function MdfPass(p, p2) {
	if (p === p2) //Esto verifica si las contraseñas son iguales 
	{
	  if (validarparams(p)) //Esto verifica si las contraseñas no estan vacias
	  {
		$.ajax({
		  type: 'POST',//Metodo en el que se enviaran los datos
		  url: './Managers/ManagerInicioSesion.php',//Direccion a la que se enviaran los datos
		  data: { tipo: "mdfpass", passwordn1: p },//Datos que seran enviados
		  beforeSend: function () { load(1); },//Mostrar pantalla de carga durante la solicitud
		  success: function (data) {
		  if (data.success) {var url = './Views/?Notificacion=' + encodeURIComponent(txt.CMC);
		  window.location.href = url;}
		  else{responses(data); load(2);}},
		  error: function () {res(txt.EELS, 'error', 2000);}});
	  }
	  
	  else { res(txt.CTC, 'warning', 1450, false, false); }
	}
	else { res(txt.LCC, 'error', 1450, false, false); }
  }