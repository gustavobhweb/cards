$(document).ready(function(){
	var $frame = $('iframe[name=response_frame]');
	var $formXLS = $('#xls-upload-form');
	var $btn = $('#xls-submit');
	var $xlsFile = $(':file[name=xls]');

	$formXLS.submit(function(event) {
		if ($xlsFile.val() == '') {
			alert('Selecione um arquivo');
			return false;
		}

		$btn.html('Carregando...').attr('disabled', true);

		$frame.fadeIn(1500, function(){
			$btn.html('Enviar Carga').attr('disabled', false);
		});
	});
});