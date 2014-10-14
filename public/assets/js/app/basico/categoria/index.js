$(document).ready(function(){
	$("#btnNovaCategoria").click(function(){
	    var link = $(this).attr('data-link');
	    if (link == undefined || link == ''){
	    	link = $(this).attr('href');
	    }
	    if (link == undefined || link == ''){
		    alert('Ocorreu um problema ao abrir o formulário.');
		    return false; 
	    }

		BootstrapDialog.show({
			type: 'type-primary',
			cssClass: 'dialog-600',
			title: 'Nova Categoria',
            message: function(dialog) {
                var $message = $('<div></div>');
                var pageToLoad = dialog.getData('pageToLoad');
                $message.load(pageToLoad);
        
                return $message;
            },
            data: {
                'pageToLoad': link
            }
        });

		return false;
	});
});
