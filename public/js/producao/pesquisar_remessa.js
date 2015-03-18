$(function()
{
	$.get('/producao/ajax-listar-remessas', function(response)
	{
		$('#pesquisar-remessa').autocomplete({
			source: response
		});
	});


	$('.mini-image').tooltip({
        content: function() {
        	var src = $(this).data('src');
        	console.log(src)
            return "<img width='200' height='267' src='" + src + "' />";
        },
        track: true
    });
});