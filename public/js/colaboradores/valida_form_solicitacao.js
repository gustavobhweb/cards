var inputStyle = {
		error: function(element){
			$(element).css({"box-shadow":"0px 0px 4px 0px #FF9999",
				            "border":"1px solid #FF5959"});
             $(element).siblings('.glif').show()
				            .find('.glyphicon')
				            .removeClass('glyphicon-ok')
				            .addClass(' glyphicon-remove');
			
		},
		
		success: function(element){
			$(element).css({"box-shadow":"0px 0px 9px 0px #B3FF99", 
				            "border":"1px solid #2BA800"});
			$(element).siblings('.glif').show()
	            .find('.glyphicon')
	            .removeClass('glyphicon-remove')
	            .addClass('glyphicon-ok');
		}
}

$(function(){

	$(".cepInput").mask("99999-999");
	
	$("#email, #confirmaEmail").bind("copy paste contextmenu dragstart dragenter cut dragover", function(){return false;});
	
	$("#email").keyup(function(){

		var $self = $(this);

		if ($self.is(":invalid"))
		{
			inputStyle.error('#email');

		} else if ($("#confirmaEmail").val() == $self.val()) {

			inputStyle.success('#confirmaEmail');
			inputStyle.success('#email');

		}  else
		{
			inputStyle.success('#email');
			
		}
		
	});
	
	$("#confirmaEmail").keyup(function(){
		
		if ($("#confirmaEmail").is(":invalid"))
		{
			inputStyle.error('#confirmaEmail');
		}
		else if ($("#confirmaEmail").val() == $("#email").val()) {
			inputStyle.success('#confirmaEmail');
			inputStyle.success('#email');
		} 
		
	});

	$("#cep").keyup(function(){
		
		if ($(this).is(":invalid"))
		{
			inputStyle.error('#cep');
		}
		else {
			inputStyle.success('#cep');
		} 
		
	});
	
	$("#cidade").change(function() {
		
		var $self = $(this);

		if ($self.val() != '') {
			
			$self.css({
				"font":"12px",
				"color":"#000"
			});

			inputStyle.success("#cidade");

		} else {

			inputStyle.error('#cidade');

		}
		
	});
	
	$("#uf").change(function(){
		
		if ($(this).val() != '') {
			
			$("#uf").css({
			"font":"12px",
			"color":"#000"
			});
			inputStyle.success("#uf");
		} else {
			inputStyle.error('#uf');
		}
		
	});
	
	$("#endereco").keyup(function(){
		
		if ($("#endereco").is(":invalid"))
		{
			inputStyle.error('#endereco');
		}
		else {
			inputStyle.success('#endereco');
		} 
		
	});
	
	$("#numero").keyup(function(){
		
		if ($("#numero").is(":invalid"))
		{
			inputStyle.error('#numero');
		}
		else {
			inputStyle.success('#numero');
		} 
		
	});
	
	$("#bairro").keyup(function(){
		
		if ($("#bairro").is(":invalid"))
		{
			inputStyle.error('#bairro');
		}
		else {
			inputStyle.success('#bairro');
		} 
		
	});
	$("#complemento").keyup(function(){
		
		if ($("#complemento").is(":invalid"))
		{
			inputStyle.error('#complemento');
		}
		else {
			inputStyle.success('#complemento');
		} 
		
	});
	
	$(".btn_cancelar").click(function(){

		$(".glif").hide();

		$('input[type="text"], input[type="email"]').css({
			"box-shadow":"none",
	            "border":"1px solid #B5B5B5"
		})
	});
	
	$("#salvarSolicitacao").click(function(){

		if ($("#email").val() == '') {
			focusElement("#email");
		}

		if ($('#privacidade').is(':checked')) {

			alert("Por favor, marque a opção dos termos de privacidade");
			
			return false;
		}
		
		if ($("#confirmaEmail").val() != $("#email").val()) {
			inputStyle.error('#confirmaEmail');
			inputStyle.error('#email');
			
			var elemento = $("#confirmaEmail").offset().top - 50;
			console.log(elemento);
			$('html, body').animate({
				scrollTop: elemento
			}, 500);
			return false;
		} 
	});
});