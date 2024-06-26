/* DATALIST FROM EDTUSER */

// Evento 'onclick' para asignar los valores del datalist a los inputs
eventlisten('#browser1','click',function(event) 
{datalistclick(event,'#slcuser','#slcuser1',['#formedt','#btnedtusr'],'#browser1','vd');});

  
eventlisten('#slcuser','input',function () 
{datalistinput('#slcuser','#slcuser1',['#formedt','#btnedtusr'],'#browser1');});


eventlisten('#slcuser','blur',function () 
{datalistblur('#slcuser','#slcuser1',['#formedt','#btnedtusr'],'#browser1');});


eventlisten('#slcuser','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#browser1')}});

/* FIN DATALIST FROM EDTUSER */


/* DATALIST FROM DLTUSER */
eventlisten('#browserdltusr','click', function(event) 
{datalistclick(event,'#slcdltuser','#slcdltuser1','#btndltusr','#browserdltusr',false,true);});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'slcdltuser'
eventlisten('#slcdltuser','input', function() 
{datalistinput('#slcdltuser','#slcdltuser1','#btndltusr','#browserdltusr');});


// Evento 'onblur' para realizar acciones cuando 'slcdltuser' pierde el foco
eventlisten('#slcdltuser','blur', function() 
{datalistblur('#slcdltuser','#slcdltuser1','#btndltusr','#browserdltusr');});


eventlisten('#slcdltuser','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#browserdltusr')}});

/* FIN DATALIST FROM DLTUSER */


 /////////////////////////// DATALIST EDITAR CLIENTE//////////////////////////////////////////////
/* DATALIST FROM EDTCLT */

eventlisten('#browseredtclt','click',function(event) 
{datalistclick(event,'#slcclt','#slcclt1',['#formedtclt1','#btnedtclt'],'#browseredtclt','vdclt');});


eventlisten('#slcclt','input',function () 
{datalistinput('#slcclt','#slcclt1',['#formedtclt1','#btnedtclt'],'#browseredtclt');});


eventlisten('#slcclt','blur',function () 
{datalistblur('#slcclt','#slcclt1',['#formedtclt1','#btnedtclt'],'#browseredtclt');});


eventlisten('#slcclt','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#browseredtclt')}});

/* FIN DATALIST FROM EDTCLT */

/////////////////////////// DATALIST  ELIMINAR CLIENTE//////////////////////////////////////////////
/* DATALIST FROM DLTCLT */

eventlisten('#browserdltclt','click', function(event) 
{datalistclick(event,'#slcdltclt','#slcdltclt1','#btndltclt','#browserdltclt',false,true);});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'slcdltuser'
eventlisten('#slcdltclt','input', function() 
{datalistinput('#slcdltclt','#slcdltclt1','#btndltclt','#browserdltclt');});


// Evento 'onblur' para realizar acciones cuando 'slcdltuser' pierde el foco
eventlisten('#slcdltclt','blur', function() 
{datalistblur('#slcdltclt','#slcdltclt1','#btndltclt','#browserdltclt');});


eventlisten('#slcdltclt','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#browserdltclt')}});

/*FIN DATALIST FROM DLTCLT */


/* DATALIST FROM ADMCLT */
eventlisten('#browseradmclt','click', function(event)
{datalistclick2(event,'#admclt','#admclt1','#browseradmclt');});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'admclt'
eventlisten('#admclt','input',function () 
{datalistinput('#admclt','#admclt1',null,'#browseradmclt');});


// Evento 'onblur' para realizar acciones cuando 'admclt' pierde el foco
eventlisten('#admclt','blur',function ()
{datalistblur2('#admclt','#admclt1','#browseradmclt');});

eventlisten('#admclt','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#browseradmclt')}});
  
/* FIN DATALIST FROM ADMCLT */


/* DATALIST FROM EDTCLTADM */
eventlisten('#browseradmedtclt','click', function(event)
{datalistclick2(event,'#admedtclt','#admedtclt1','#browseradmedtclt');});


// Evento 'oninput' para filtrar opciones según la entrada del usuario en 'admclt'
eventlisten('#admedtclt','input',function () 
{datalistinput('#admedtclt','#admedtclt1',null,'#browseradmedtclt');});

    
// Evento 'onblur' para realizar acciones cuando 'admclt' pierde el foco
eventlisten('#admedtclt','blur',function () 
{datalistblur2('#admedtclt','#admedtclt1','#browseradmedtclt');});
    

eventlisten('#admedtclt','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#browseradmedtclt')}});
/////////FIN DATALIST ADM EDITAR CLIENTE//////////////////////////////////////////////


//////////// DATALIST AGRADM//////////////////////////////////////////////

eventlisten('#Datalistagradm','click',function(event) 
{datalistclick(event,'#admedt','#admedt1',['#btnedtadm','#formedtadm1'],'#Datalistagradm');});


eventlisten('#admedt','input',function () 
{datalistinput('#admedt','#admedt1',['#btnedtadm','#formedtadm1'],'#Datalistagradm');});


eventlisten('#admedt','blur',function () 
{datalistblur('#admedt','#admedt1',['#btnedtadm','#formedtadm1'],'#Datalistagradm');});


eventlisten('#admedt','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13)
{datalistkeydown(e,'#Datalistagradm')}});

/////////FIN DATALIST AGRADM//////////////////////////////////////////////