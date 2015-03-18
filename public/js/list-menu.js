$(function(){
	var $toggle = $('.list-menu');
	var $box = $toggle.find('.box');
	$toggle.find('button').on('click', function(){
		event.stopPropagation();
		if (!$box.is(':visible')) {
			$box.fadeIn();
		} else {
			$box.fadeOut();
		}
	});
	$box.on('click', function(e){
		event.stopPropagation();
	});
	$('body').click(function(){
		if ($box.is(':visible')) $box.fadeOut();
	});
})