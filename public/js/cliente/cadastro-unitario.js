$(function()
{
	$btnFakeFile = $('#btn-fake-file');
	$imagem      = $('#imagem');
	$preview 	 = $('#preview');

	$btnFakeFile.on('click', function()
	{
		$imagem.click();
	});

	$imagem.on('change', function(event)
	{
		var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
		var blob = URL.createObjectURL(event.target.files[0]);
		$btnFakeFile.html(filename);
		$preview.attr('src', blob).fadeIn();
	})
})