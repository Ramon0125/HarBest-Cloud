//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){

  load(2);

  eventlisten('.toggle-sidebar-btn','click',function () {
  $('body').toggleClass('toggle-sidebar');

  });

  // Obtener la fecha actual
  eventlisten('.modal','show.bs.modal', function () {

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    // Establecer la fecha actual en formato "yyyy-mm-dd" en todos los campos de fecha
    $(this).find('input[type="date"]').val(today);
});

});

const tabledata = {
  "language": { "emptyTable":     "No hay datos disponibles en la tabla",
  "info":           "&nbsp; Mostrando _END_ de _TOTAL_ registros",
  "infoEmpty":      "&nbsp; No hay coincidencias",
  "infoFiltered":   "(_MAX_ registros totales)",
  "infoPostFix":    "",
  "thousands":      ",",
  "lengthMenu":     "&nbsp; Mostrar _MENU_ registros",
  "loadingRecords": "Cargando...",
  "processing":     "Procesando...",
  "search":         "Buscar:",
  "zeroRecords":    "No se encontraron registros",
  "paginate": { "first":"Primero", "last": "Último", "next": ">", "previous":   "<" }}
  };

  
// Esta es la constante de respuestas AJAX
const txt = {
CMC: '¡Contraseña modificada correctamente!',
UIC: '¡Usuario insertado correctamente!',
EIU: '¡Error al insertar usuario!',
ECI: '¡Email o contraseña incorrecta!',
UMC: '¡Usuario modificado correctamente!',
SIC: 'Sesión iniciada correctamente',
EELS: 'Error en la solicitud',
CNV: 'Caracteres no válidos',
EANV: 'Extencion de archivo no valida',
MCI: 'Solo se pueden agregar letras, números y caracteres como: @ . _ -',
MCI1: 'Solo se pueden agregar archivos .PDF, .JPG, .PNG Y .DOCX',
LCC: 'Las contraseñas no coinciden',
CIC: '¡Cliente insertado correctamente!',
EIC: '¡Error al insertar cliente!',
UEC: '¡Usuario eliminado correctamente!',
CMC1: '¡Cliente modificado correctamente!',
EMC: 'Error al modificar cliente',
CEC: '¡Cliente eliminado correctamente!',
EEC: 'Error al eliminar cliente',
CTC: 'Complete todos los campos',
EUE: 'Este usuario ya existe',
ICV: '¡Ingrese un correo válido!',
EUNE: 'Este usuario no existe',
EMU: 'El usuario no se modifico',
EEU: 'Error al eliminar usuario',
ECE: 'Este cliente existe',
EMC1: 'Error al modificar cliente',
AIC: 'Administración insertada correctamente',
EIA: 'Error al insertar administración',
EAE: 'Esta administración existe',
AMC: 'Administración modificada correctamente',
EMA: 'Error al modificar administración',
AEC: 'Administración eliminada correctamente',
EEA: 'Error al eliminar administración',
RNV: 'RNC no valido',
EEE: 'Este correo existe',
ERE: 'Este RNC existe',
W: 'warning',
E: 'error',
S: 'success',
UDC: 'Usuario desbloqueado correctamente',
EDU: 'Error al desbloquear el usuario',
ENE: 'Esta Notificacion Existe',
NIC: 'Notificacion Insertada correctamente',
EIN: 'Error al insertar notificaion'
};


// Función para cerrar sesión
function cerrar() 
{
  Swal.fire({
  showCancelButton: true,
  icon: "warning",
  text: "¿Está seguro de que desea cerrar sesión?",
  confirmButtonColor: '#28a745',
  cancelButtonColor: '#dc3545',
  confirmButtonText: 'Si',
  cancelButtonText: 'Cancelar',
  preConfirm: () => { var url = '../?hcerrar';  window.location.href = url;}});
}


// Función para mostrar las alertas
function res(result, icon, tim, sc, tit) 
{
  history.replaceState({}, document.title, window.location.pathname);

  Swal.fire({
  confirmButtonColor: '#28a745',
  showConfirmButton: sc,
  icon: icon,
  title: tit,
  text: result,
  timer: tim});
}


function responses(respuesta)//Funcion que maneja las respuestas de las solicitudes AJAX
{
let resp = (respuesta.block ? "1" : "0") + (respuesta.error ? "1" : "0") + (respuesta.success ? "1" : "0") + (respuesta.CNV ? "1" : "0") + (respuesta.EANV ? "1" : "0");

switch (resp)
{
case "10000": location.reload(); break;///Se ejecuta si el array contiene la propiedad bloqueo
case "01000": const url = '../Error/?Error=002'; window.location.href = url; break;///Se ejecuta si el array contiene la propiedad error 
case "00100": res(txt[respuesta.message],txt.S, 2000, false,false); break; ///Se ejecuta si el array no contiene la propiedad success
case "00010": res(txt.MCI,txt.W,false,true,txt.CNV); break; ///Se ejecuta si el array contiene la propiedad CNV
case "00001": res(txt.MCI1,txt.W,false,true,txt.EANV); break; ///Se ejecuta si el array contiene la propiedad CNV
case "00000": res(txt[respuesta.message],txt.W, 2000, false,false); break; ///Se ejecuta si el array no contiene la propiedad success
};
}


//Funcion que verifica que los parametros no esten vacios
function validarparams(...args) { return !args.some(parametro => parametro.trim().length === 0); }


//Funcion que valida los emails
function validaremailcl(email) 
{ const tester = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return tester.test(email);}

//Funcion que valida los emails
function validaremail(email) 
{ const tester = /^[^\s@]+@harbest\.net$/;
  return tester.test(email);}

//Funcion que valida los numeros
function validarint(int) 
{ const tester1 = /^[0-9]+$/
  return tester1.test(int);} 


function modifystyle(objects, property, value) 
{ $(objects).each(function(index, object) {
    $(object).css(property, value);
  });}


// Función para mostrar/ocultar indicador de carga
function load(str) 
{
$('body').css('overflow', str == 1 ? 'hidden' : 'auto');
$('#carga').addClass(str == 1 ? 'loading' : 'hide');
$('#carga').removeClass(str == 1 ? 'hide' : 'loading');
}


function LimpiarModal(input = false,Objetos = false,forms = false)
{
if(Objetos){modifystyle(Objetos,'display','none');}

if(forms){
if(Array.isArray(forms)){for (const form of forms){$(form).trigger('reset'); }}
else {$(forms).trigger('reset');}}

if(input){
if(Array.isArray(input)){for (const inp of input){$(inp).val(''); }}
else {$(input).val('');}}
}


const eventlisten = (obj,event,func) => {$(obj).on(event,func);}