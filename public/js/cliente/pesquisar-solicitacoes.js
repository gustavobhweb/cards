$(function()
{
	$('.clickable').on('click', function()
	{
		var href = $(this).find('.continuar').attr('href');
		$(location).attr({href: href});
	});
});