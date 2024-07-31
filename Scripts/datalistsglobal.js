
async function updatedatalists(tipo,datalists) 
{
  if(!validarint(tipo)){return Alerta(txt.EELS, txt.E, 2000);}

    $.ajax({
        type: 'POST',
        url: PageURL+'Controllers/datos.php',
        data: { tipo: tipo },
        dataType: 'json',
        success: function (data) {

        if (!data.error)
        { $(datalists).each(function(index, datalist) {

        $(datalist).empty();
        
        $.each(data, function(index, valor) {
        let keys = Object.keys(valor);
    
        $('<option>', { value: valor[keys[0]], text: valor[keys[1]] }).appendTo(datalist);
            });
        }); }
        
        else {responses(data);}
      },
      error: function(){return Alerta(txt.EELS,txt.E,2000);}
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

var currentFocus = -1;

function datalistinput(input,input2,objects,datalist)
{

$(input2).val(0);  let hasMatch = false; currentFocus = -1;

if(objects != null){modifystyle(objects,'display','none');}

if($(input).val().toUpperCase().trim() !== '')
{
 $(datalist).find('option').each(function() 
 {
  $(this).removeClass('active');
 if ($(this).text().toUpperCase().indexOf($(input).val().toUpperCase()) > -1)
 { $(this).show(); $(this).addClass('option-active');   hasMatch = true; }

 else { $(this).hide(); $(this).removeClass('option-active'); }
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
{ currentFocus = -1;
    setTimeout(() => {
    if($(input2).val() == 0){
    datalistcontrol2(input,input2,datalist)}
    }, 200);
}


function datalistkeydown(e, browser) {
  const options = $(browser).find('.option-active');
  
  const addActive = (index) => options.eq(index).addClass('active');
  
  if (currentFocus >= -1 && currentFocus < options.length) {
    e.preventDefault();
    
    switch (e.keyCode) {
      case 40:  if (currentFocus < options.length-1){ currentFocus++; }  break;
      case 38:  currentFocus = Math.max(currentFocus - 1, 0); break;
      case 13:  if (currentFocus > -1 && options.length > 0) { options.eq(currentFocus).click();} break;
    }

      options.removeClass('active');
      addActive(currentFocus);
    }
  }
  
