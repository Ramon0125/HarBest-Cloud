eventlisten('#ContainerPRG','click',
function () { 
    
    if($('#ContainerPRG').hasClass('has'))
    {
        $('#Fileprg').val('');
        $('#ContainerPRG').removeClass('has');
        $('#Spanprg').text('Buscar');
        modifystyle(['#Spanprg'],'color','green');
    }
    
    else{ $('#Fileprg').click(); }
}
);

eventlisten('#Fileprg','change',
function () { 
    
    if($('#Fileprg').val() !== null)
    {
        $('#ContainerPRG').addClass('has');
        $('#Spanprg').text('Quitar');
        modifystyle(['#Spanprg'],'color','red');
    }
    
    else
    { $('#ContainerPRG').removeClass('has');
      $('#Spanprg').text('Buscar');
      modifystyle(['#Spanprg'],'color','green');
    }
}
);