
function updatedatalists(tipo,datalists) {

    $(datalists).each(function(index, datalist) {$(datalist).empty();});

    $.ajax({
        type: 'POST',
        url: '../Controllers/datos.php',
        data: { tipo: tipo },
        dataType: 'json',
        success: function (data) {

        $(datalists).each(function(index, datalist) {
 
        $.each(data, function(index, valor) {
        var keys = Object.keys(valor);
    
        $('<option>', { value: valor[keys[0]], text: valor[keys[1]] }).appendTo(datalist);
            });
        });},
        error: function () {res(txt.EELS, "error", 2000);}
      });
}




function datalistcontrol(input, input2, object, datalist,func = '', st = false) 
{
$(datalist).css('display','none');

if(!st && func != '')
{
if($(input2).val() == 0){modifystyle(object,'display','none');}
else {window[func]($(input2).val(),$(input).val());}
}

else 
{modifystyle(object,'display',$(input2).val() == 0 ? 'none' : 'block');}
}



function datalistclick(event,input,input2,objects,datalist,func = '',st = false) 
{
if (event.target.tagName === 'OPTION') 
{
$(input).val(event.target.textContent);
$(input2).val(event.target.value);
datalistcontrol(input,input2,objects,datalist,func,st);
}
}


function datalistinput(input,input2,objects,datalist)
{
$(input2).val(0);  let hasMatch = false;

if(objects != null){modifystyle(objects,'display','none');}

if($(input).val().toUpperCase() !== '') 
{
 $(datalist).find('option').each(function() 
 {
 if ($(this).text().toUpperCase().indexOf($(input).val().toUpperCase()) > -1)
 { $(this).show();   hasMatch = true; }

 else { $(this).hide(); }
 });
}

modifystyle(datalist,'display',hasMatch ? 'block' : 'none');
}


function datalistblur(input, input2, objects, datalist) 
{
setTimeout(() => {
if($(input2).val() == 0){
datalistcontrol(input,input2,objects,datalist)}
}, 200);
}


function datalistcontrol2(input,input2,datalist) 
{  
 modifystyle(datalist,'display','none');
 if($(input2).val() == 0){$(input).val('');}
}


function datalistclick2(event,input,input2,datalist)
{
  if (event.target.tagName === 'OPTION') 
  {
  $(input).val(event.target.textContent);
  $(input2).val(event.target.value);
  datalistcontrol2(input,input2,datalist)
  } 
}


function datalistblur2(input, input2, datalist)
{
    setTimeout(() => {
    if($(input2).val() == 0){
    datalistcontrol2(input,input2,datalist)}
    }, 200);
}