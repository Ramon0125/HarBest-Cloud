/////////DATALIST NOTIF. SELECCIONAR CLIENTE//////////////////////////////////////////////

eventlisten('#dtlcltargnot','click',(event) => {datalistclick2(event,'#cltagrnot','#cltagrnot1','#dtlcltargnot');});

eventlisten('#cltagrnot','input',() => {datalistinput('#cltagrnot','#cltagrnot1',null,'#dtlcltargnot');});

eventlisten('#cltagrnot','blur',() => {datalistblur2('#cltagrnot','#cltagrnot1','#dtlcltargnot');});

eventlisten('#cltagrnot','keydown',(e) => {if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtlcltargnot')}});
    
/////////FIN DATALIST NOTIF. SELECCIONAR CLIENTE//////////////////////////////////////////////



/////////DATALIST DLTNOTIF//////////////////////////////////////////////

eventlisten('#dtldltnot','click', function(event) 
{datalistclick(event,'#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot',false,true);});

eventlisten('#slcdltnotif','input', function()
{datalistinput('#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot');});

eventlisten('#slcdltnotif','blur', function() 
{datalistblur('#slcdltnotif','#slcdltnotif1','#btndltnotif','#dtldltnot');});

eventlisten('#slcdltnotif','keydown',(e) => {
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtldltnot')}});

/////////FIN DATALIST DLTNOTIF//////////////////////////////////////////////



/////////DATALIST AGRDDC//////////////////////////////////////////////

eventlisten('#dtlagrddc','click', function(event)
{datalistclick(event,'#slcntfddc','#slcntfddc1',['#formDDC','#btnagrddc'],'#dtlagrddc','searchnotif');

incon = []; updatedetalles();

const miSelect = document.getElementById('nontfddc');

while (miSelect.options.length > 1) { miSelect.remove(1); }
});

eventlisten('#slcntfddc','input',function () 
{datalistinput('#slcntfddc','#slcntfddc1',['#formDDC','#btnagrddc'],'#dtlagrddc');});

eventlisten('#slcntfddc','blur',function () 
{datalistblur('#slcntfddc','#slcntfddc1',['#formDDC','#btnagrddc'],'#dtlagrddc');});

eventlisten('#slcntfddc','keydown',(e) => {
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtlagrddc')}});
    
/////////FIN DATALIST AGRDDC//////////////////////////////////////////////



/////////DATALIST DLTDDC//////////////////////////////////////////////

eventlisten('#dtldltddc','click', function(event) 
{datalistclick(event,'#slcdltddc','#slcdltddc1','#btndltddc','#dtldltddc',false,true);});

eventlisten('#slcdltddc','input', function() 
{datalistinput('#slcdltddc','#slcdltddc1','#btndltddc','#dtldltddc');});

eventlisten('#slcdltddc','blur', function() 
{datalistblur('#slcdltddc','#slcdltddc1','#btndltddc','#dtldltddc');});

eventlisten('#slcdltddc','keydown',(e) => { 
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtldltddc')}});

/////////FIN DATALIST DLTDDC//////////////////////////////////////////////