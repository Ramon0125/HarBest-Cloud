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