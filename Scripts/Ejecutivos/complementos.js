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
    
    if($('#Fileprg')[0].files.length > 0)
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