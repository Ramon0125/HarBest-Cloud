/* DATALIST FROM EDTCLTADM */
eventlisten('#dtlcltargnot','click', function(event)
{datalistclick2(event,'#cltagrnot','#cltagrnot1','#dtlcltargnot');});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'admclt'
eventlisten('#cltagrnot','input',function () 
{datalistinput('#cltagrnot','#cltagrnot1',null,'#dtlcltargnot');});

    
// Evento 'onblur' para realizar acciones cuando 'admclt' pierde el foco
eventlisten('#cltagrnot','blur',function () 
{datalistblur2('#cltagrnot','#cltagrnot1','#dtlcltargnot');});
    
/////////FIN DATALIST ADM EDITAR CLIENTE//////////////////////////////////////////////


/* DATALIST FROM EDTNOTIF */

eventlisten('#dtledtnot','click',function(event) 
{datalistclick(event,'#slcnotif','#slcnotif1',['#btnedtnotif','#formedtnotif1'],'#dtledtnot','vdntf');});


eventlisten('#slcnotif','input',function () 
{datalistinput('#slcnotif','#slcnotif1',['#btnedtnotif','#formedtnotif1'],'#dtledtnot');});


eventlisten('#slcnotif','blur',function () 
{datalistblur('#slcnotif','#slcnotif1',['#btnedtnotif','#formedtnotif1'],'#dtledtnot');});

    
/////////FIN DATALIST EDITAR NOTIFI//////////////////////////////////////////////


/* DATALIST FROM EDTCLTNOTIF */
eventlisten('#dtlcltedtnot','click', function(event)
{datalistclick2(event,'#cltedtnot','#cltedtnot1','#dtlcltedtnot');});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'admclt'
eventlisten('#cltedtnot','input',function () 
{datalistinput('#cltedtnot','#cltedtnot1',null,'#dtlcltedtnot');});

    
// Evento 'onblur' para realizar acciones cuando 'admclt' pierde el foco
eventlisten('#cltedtnot','blur',function () 
{datalistblur2('#cltedtnot','#cltedtnot1','#dtlcltedtnot');});
    
/////////FIN DATALIST NOTIF EDITAR CLIENTE//////////////////////////////////////////////


/* DATALIST FROM DLTNOTIF */
eventlisten('#dtldltnot','click', function(event) 
{datalistclick(event,'#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot',false,true);});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'slcdltuser'
eventlisten('#slcdltnotif','input', function() 
{datalistinput('#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot');});


// Evento 'onblur' para realizar acciones cuando 'slcdltuser' pierde el foco
eventlisten('#slcdltnotif','blur', function() 
{datalistblur('#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot');});
/* FIN DATALIST FROM DLTUSER */
