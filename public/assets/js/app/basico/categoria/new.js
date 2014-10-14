$(document).ready(function(){	
	$(':radio.uniform, :checkbox.uniform').uniform();
	$('#CategoriaPai').select2({
		width: '100%'
	});	
	
	$("#FrmCategoria").submit(function(){
		alert('ok');
		
		return false;
	});
});