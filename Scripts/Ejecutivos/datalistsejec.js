/* DATALIST FROM SLCCLTNTF */
eventlisten('#dtlcltargnot','click',(event) => {datalistclick2(event,'#cltagrnot','#cltagrnot1','#dtlcltargnot');});

eventlisten('#cltagrnot','input',() => {datalistinput('#cltagrnot','#cltagrnot1',null,'#dtlcltargnot');});

eventlisten('#cltagrnot','blur',() => {datalistblur2('#cltagrnot','#cltagrnot1','#dtlcltargnot');});

eventlisten('#cltagrnot','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtlcltargnot')}});
    
/////////FIN DATALIST NTF SELECCIONAR CLIENTE//////////////////////////////////////////////


/* DATALIST FROM DLTNOTIF */
eventlisten('#dtldltnot','click', function(event) 
{datalistclick(event,'#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot',false,true);});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'slcdltuser'
eventlisten('#slcdltnotif','input', function() 
{datalistinput('#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot');});


// Evento 'onblur' para realizar acciones cuando 'slcdltuser' pierde el foco
eventlisten('#slcdltnotif','blur', function() 
{datalistblur('#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot');});


eventlisten('#slcdltnotif','keydown',(e) => {
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtldltnot')}});

/* FIN DATALIST FROM DLTNOTIF */


/* DATALIST FROM AGRDDC */
eventlisten('#dtlagrddc','click', function(event)
{datalistclick(event,'#slcntfddc','#slcntfddc1',['#formDDC','#btnagrddc'],'#dtlagrddc','searchnotif');

incon = []; updatedetalles();

const miSelect = document.getElementById('nontfddc');

while (miSelect.options.length > 1) { miSelect.remove(1); }

});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'admclt'
eventlisten('#slcntfddc','input',function () 
{datalistinput('#slcntfddc','#slcntfddc1',['#formDDC','#btnagrddc'],'#dtlagrddc');});

    
// Evento 'onblur' para realizar acciones cuando 'admclt' pierde el foco
eventlisten('#slcntfddc','blur',function () 
{datalistblur('#slcntfddc','#slcntfddc1',['#formDDC','#btnagrddc'],'#dtlagrddc');});

    
/////////FIN DATALIST ADM EDITAR CLIENTE//////////////////////////////////////////////


/* DATALIST FROM DLTNOTIF */
eventlisten('#dtldltddc','click', function(event) 
{datalistclick(event,'#slcdltddc','#slcdltddc1','#btndltddc','#dtldltddc',false,true);});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'slcdltuser'
eventlisten('#slcdltddc','input', function() 
{datalistinput('#slcdltddc','#slcdltddc1','#btndltddc','#dtldltddc');});


// Evento 'onblur' para realizar acciones cuando 'slcdltuser' pierde el foco
eventlisten('#slcdltddc','blur', function() 
{datalistblur('#slcdltddc','#slcdltddc1','#btndltddc','#dtldltddc');});
/* FIN DATALIST FROM DLTUSER */