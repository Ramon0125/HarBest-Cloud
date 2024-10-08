const PageURL = 'http://192.168.0.186/HarBest-Cloud/';

const toggval = () => parseInt($('#sidebar').css('left'), 10); 

const maxfilesize = 10;

const NDate = new Date();

const currentYear = NDate.getFullYear();

//Acciones que se cumpliran cuando se cargue por completo el DOM
$(document).ready(function(){

  let params = new URLSearchParams(window.location.search);
  
  if (params.has('Notificacion')) 
  {
    let mensaje = params.get('Notificacion');
    Alerta(mensaje,txt.S,2000);
    LimpiarParametros();
  }

  if(toggval() == -300){$('#chk').click();}

  load(2);

  eventlisten('.toggle-sidebar-btn','click',function () {  
  $('body').toggleClass('toggle-sidebar');  });

  
  eventlisten('.hamburger-lines','click',function () {
  $('#chk').click(); $('body').toggleClass('toggle-sidebar');})

});

$(window).resize(function () { $('#chk').prop('checked',toggval() == 0 ? true : false); });


const tabledata = {
  "autoWidth": false,
  "order": [],
  "language": { "emptyTable":     "No se encontraron datos en la tabla",
  "info":           "&nbsp; Mostrando _END_ de _TOTAL_ registros",
  "infoEmpty":      "&nbsp;  _END_ de _TOTAL_ registros",
  "infoFiltered":   "(filtrado de _MAX_ registros totales)",
  "lengthMenu":     "&nbsp; Mostrar _MENU_ registros",
  "loadingRecords": "Cargando...",
  "processing":     "Procesando...",
  "search":         "Buscar:",
  "zeroRecords":    "No se encontraron coincidencias",
  "paginate": { "first":"Primero", "last": "Último", "next": ">", "previous":   "<" }},
  "lengthMenu": [ [15, 40, 50, -1], ["15", "40", "50", "Todos"] ]
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
MCI1: 'Solo se pueden agregar archivos con formato: ".PDF, .JPG, .PNG Y .DOCX"',
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
ENCYA: 'Este numero de caso ya esta agregado',
NIC: 'Notificacion Insertada correctamente',
EIN: 'Error al insertar notificaion',
EEC1: 'Email enviado correctamente',
EECE: 'Error al enviar email',
NMC: 'Notificacion modificada correctamente',
NEC: 'Notificacion eliminada correctamente',
EEN: 'Error al eliminar la notificacion',
EDCE: 'Este detalle de citación existe',
DIC: 'Detalle de citación insertado correctamente',
EID: 'Error al insertar detalle de citación',
INCV: 'Ingrese un numero de caso valido',
EED: 'Error al eliminar detalle de citacion',
DEC: 'Detalle eliminado correctamente',
ITV: 'Ingrese un numero telefonico valido',
AMG: 'Archivos muy grandes',
AMGR: `El tamaño maximo permitido por archivo es ${parseInt(maxfilesize/3.3) } MB`,
AMGR1: `El tamaño maximo permitido por archivo es ${maxfilesize} MB`,
CTDN: 'Para continuar los campos de notificación(Numero,Tipo,Motivo y Año) deben estar vacios',
ENYEA: 'Esta notificación ya esta agregada',
IAV: 'Ingrese un año valido',
EDYEA: 'Este detalle ya a esta agregado',
CTDD: 'Para continuar los campos de detalle (Inconsistencia, Periodo, etc.) deben estar vacios',
IVV: 'Ingrese un valor valido',
IPV: 'Ingrese un periodo valido',
EEDDE: 'Este escrito de descargo existe',
EDDIC: 'Escrito de descargo insertado correctamente',
EIEDD: 'Error al insertar escrito de descargo',
EDDEC: 'Escrito de descargo eliminado correctamente',
EEEDD: 'Error al eliminar escrito de descargo',
ERYE: 'Esta respuesta ya fue insertada',
RIC: 'Respuesta insertada correctamente',
EIR: 'Error al insertar respuesta',
REL: 'Respuesta eliminada correctamente',
EER: 'Error al eliminar respuesta',
PIC: 'Prorroga insertada correctamente',
EAIP: 'Error al insertar prorroga',
PEC: 'Prorroga eliminada correctamente',
EAEP: 'Error al eliminar prorroga'
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
  preConfirm: () => { window.location.href = PageURL+'?hcerrar';}});
}


// Función para mostrar las alertas
function Alerta(result, icon, tim, sc, tit,html) 
{
  Swal.fire({
  confirmButtonColor: '#28a745',
  showConfirmButton: sc,
  icon: icon,
  title: tit,
  text: result,
  timer: tim,
  html: html});
}


const LimpiarParametros = () => { history.replaceState({}, document.title, window.location.pathname); }


function responses(respuesta)//Funcion que maneja las respuestas de las solicitudes AJAX
{
let resp = (respuesta.block ? "1" : "0") + (respuesta.error ? "1" : "0") + (respuesta.success ? "1" : "0") + (respuesta.CNV ? "1" : "0") + (respuesta.EANV ? "1" : "0");

switch (resp)
{
case "10000": location.reload(); break;///Se ejecuta si el array contiene la propiedad bloqueo
case "01000": let url = PageURL+'Error/?Error=002'; window.location.href = url; break;///Se ejecuta si el array contiene la propiedad error 
case "00100": $('.modal').modal('hide'); Alerta(txt[respuesta.message],txt.S, 2000, false,false); break; ///Se ejecuta si el array no contiene la propiedad success
case "00010": Alerta(false,txt.W,false,true,txt.CNV,
                `Por favor, evita ingresar los siguientes caracteres:<br><br>
                      <ul style="text-align:left;">
                       <li>Punto y coma (;)</li>
                       <li>Comillas ('-")</li>
                       <li>Comentarios de una sola línea con '--'</li>
                       <li>Comentarios multilíneas (/* comentario */)</li>
                       <li>Prefijo 'xp_'</li>
                       <li>Caracteres especiales como: $, %, <, >, =</li>
                      </ul>`); break; ///Se ejecuta si el array contiene la propiedad CNV
case "00001": Alerta(txt.MCI1,txt.W,false,true,txt.EANV); break; ///Se ejecuta si el array contiene la propiedad CNV
case "00000": Alerta(txt[respuesta.message],txt.W, 2000, false,false); break; ///Se ejecuta si el array no contiene la propiedad success
};
}


//Funcion que verifica que los parametros no esten vacios
function validarparams(...args) { return args.every(parametro => parametro.trim().length > 0); }


//Funcion que valida los emails
function validaremailcl(email) 
{ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); }


//Funcion que valida los emails
function validaremail(email) 
{ return /^[^\s@]+@harbest\.net$/.test(email.trim()); }


// Función que valida los números
function validarint(...ints) {
  return ints.every(val => 
    typeof val === 'number' || 
    (typeof val === 'string' && val.trim() !== '' && /^[0-9]+(\.[0-9]+)?(,[0-9]+)?$/.test(val))
  );
}

function validarvalor(...ints) {
  return ints.every(val => 
    typeof val === 'number' || 
    (typeof val === 'string' && val.trim() !== '' && /^(\d{1,3})(,\d{3})*(\.\d+)?$/.test(val))
  );
}


function validaraño(int) 
{ return validarint(int) ? !(int < 2015 || int > currentYear) : false; }


function modifystyle(objects, property, value) 
{ $(objects).each(function(index, object) {$(object).css(property, value);});}


// Función para mostrar/ocultar indicador de carga
function load(str) 
{
$('body').css('overflow', str == 1 ? 'hidden' : 'auto');
$('#carga').addClass(str == 1 ? 'loading' : 'hide');
$('#carga').removeClass(str == 1 ? 'hide' : 'loading');
}


function LimpiarModal(input = false,Objetos = false,forms = false)
{
if(Objetos)
{modifystyle(Objetos,'display','none');}

if(forms)
{
if(Array.isArray(forms)){for (const form of forms){$(form).trigger('reset'); }}
else {$(forms).trigger('reset');}
} 

if(input)
{
if(Array.isArray(input)){for (const inp of input){$(inp).val(''); }}
else {$(input).val('');}
}
}


const eventlisten = (obj,event,func) => {$(obj).on(event,func);}


function crearBlobDesdeBase64(base64, mimeType) {
  const binaryString = atob(base64);
  const len = binaryString.length;
  const bytes = new Uint8Array(len);

  for (let i = 0; i < len; i++) {
      bytes[i] = binaryString.charCodeAt(i);
  }

  return new Blob([bytes], { type: mimeType });
}


function procesarCartas(cartaData) 
{
  let archivos = JSON.parse(cartaData);

  archivos.forEach((archivo) => {
      const blob = crearBlobDesdeBase64(archivo.CARTA, archivo.MIME);
      const url = URL.createObjectURL(blob);
      window.open(url, '_blank');
  });
}

function OnlyNumber(input)
{
  eventlisten(input,'input', function (event) 
  {
    let value = event.target.value;

    validarint(event.data) ? null : event.target.value = value.replace(/[^0-9.]/g, '');
  });
}

function OnlyValor(input) {
  eventlisten(input, 'blur', function(event) {
    let value = event.target.value;

    let num = parseFloat(value.replace(/,/g, ''));
    
    if (!isNaN(num)) { event.target.value = num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });}
  });
}

const emptyTable = (table) => {
  while(table.firstChild){ table.removeChild(table.firstChild); }
}
