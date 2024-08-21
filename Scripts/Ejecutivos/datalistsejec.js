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



/////////DATALIST AGREDD//////////////////////////////////////////////

eventlisten('#dtlagredd','click', function(event)
{datalistclick(event,'#slcntfedd','#slcntfedd1',['#formEDD','#btnagredd'],'#dtlagredd',false,true);});

eventlisten('#slcntfedd','input',function () 
{datalistinput('#slcntfedd','#slcntfedd1',['#formEDD','#btnagredd'],'#dtlagredd');});

eventlisten('#slcntfedd','blur',function () 
{datalistblur('#slcntfedd','#slcntfedd1',['#formEDD','#btnagredd'],'#dtlagredd');});

eventlisten('#slcntfedd','keydown',(e) => {
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtlagredd')}});
    
/////////FIN DATALIST AGREDD//////////////////////////////////////////////



/////////DATALIST DLTEDD//////////////////////////////////////////////

eventlisten('#dtldltedd','click', function(event) 
{datalistclick(event,'#slcdltedd','#slcdltedd1','#btndltedd','#dtldltedd',false,true);});

eventlisten('#slcdltedd','input', function() 
{datalistinput('#slcdltedd','#slcdltedd1','#btndltedd','#dtldltedd');});

eventlisten('#slcdltedd','blur', function() 
{datalistblur('#slcdltedd','#slcdltedd1','#btndltedd','#dtldltedd');});

eventlisten('#slcdltedd','keydown',(e) => { 
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtldltedd')}});

/////////FIN DATALIST DLTEDD//////////////////////////////////////////////



/////////DATALIST AGRRDGII//////////////////////////////////////////////

eventlisten('#dtlagrrdgii','click', function(event)
{datalistclick(event,'#slcntfrdgii','#slcntfrdgii1',['#formrdgii','#btnagrrdgii'],'#dtlagrrdgii',false,true);});

eventlisten('#slcntfrdgii','input',function () 
{datalistinput('#slcntfrdgii','#slcntfrdgii1',['#formrdgii','#btnagrrdgii'],'#dtlagrrdgii');});

eventlisten('#slcntfrdgii','blur',function () 
{datalistblur('#slcntfrdgii','#slcntfrdgii1',['#formrdgii','#btnagrrdgii'],'#dtlagrrdgii');});

eventlisten('#slcntfrdgii','keydown',(e) => {
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtlagrrdgii')}});

/////////FIN DATALIST AGRRDGII//////////////////////////////////////////////


/////////DATALIST DLTRDGII//////////////////////////////////////////////

eventlisten('#dtldltrdgii','click', function(event) 
{datalistclick(event,'#slcdltrdgii','#slcdltrdgii1','#btndltrdgii','#dtldltrdgii',false,true);});

eventlisten('#slcdltrdgii','input', function() 
{datalistinput('#slcdltrdgii','#slcdltrdgii1','#btndltrdgii','#dtldltrdgii');});

eventlisten('#slcdltrdgii','blur', function() 
{datalistblur('#slcdltrdgii','#slcdltrdgii1','#btndltrdgii','#dtldltrdgii');});

eventlisten('#slcdltrdgii','keydown',(e) => { 
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtldltrdgii')}});

/////////FIN DATALIST DLTRDGII//////////////////////////////////////////////


/////////DATALIST AGRPRG//////////////////////////////////////////////

eventlisten('#dtlagrprg','click', function(event) 
{datalistclick(event,'#slcntfprg','#slcntfprg1',['#Containeragrprg'],'#dtlagrprg',false,true);});

eventlisten('#slcntfprg','input', function() 
{datalistinput('#slcntfprg','#slcntfprg1',['#Containeragrprg'],'#dtlagrprg');});

eventlisten('#slcntfprg','blur', function() 
{datalistblur('#slcntfprg','#slcntfprg1',['#Containeragrprg'],'#dtlagrprg');});

eventlisten('#slcntfprg','keydown',(e) => { 
if (e.keyCode === 40 || e.keyCode === 38 || e.keyCode === 13) {datalistkeydown(e,'#dtldltedd')}});

/////////FIN DATALIST AGRPRG//////////////////////////////////////////////

