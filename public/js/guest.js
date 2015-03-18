$(function(){

	var $inputCaptcha = $('[name=captcha]');

	var $btnReloadCaptcha = $('#btn-reload-captcha');

	var $imgCaptcha = $('#login-captcha');

	$imgCaptcha.hide();

	$imgCaptcha.bind('dragstart', function(){
		return false;
	})
	.load(function(){
		$('#loading-captcha').hide(0, function(){
			$imgCaptcha.show();
		});

	})
	
	$btnReloadCaptcha.click(function(){
	
		var src = $imgCaptcha.attr('src').split('?');

		src.pop();

		var newSrc = src.concat([$.now()]).join('?')

		$imgCaptcha.attr({src: newSrc}).hide(0, function(){
			$('#loading-captcha').show();
		});

	});


	$('#form-login').submit(function(e) {
		
		if (! $inputCaptcha.attr('required')) {

			e.preventDefault();
		}
	});
});
