$(function(){

	var smallShake = function (el, repeat)
	{
		var $el = $(el),
			i = 0;

		var repeat = function($el, number) {

			$el.css({position: 'relative'})
			.animate({top: '+5px'}, 200, function(){
				$(this).animate({top: '-5px'}, 200, function(){
					$(this).css({position: 'static'})

					if (++i < number) {
						repeat($el, number)
					}
				})
			})
		}


		return repeat($el, repeat || 1)

		
	}

	var $form = $('#form-tipo-cartao'),

		$inputNome = $('[name=nome]');

		$inputNome.data('defaultValue', $inputNome.val())


	$form.submit(function(e){


		if ($inputNome.data('defaultValue') === $inputNome.val()) {

			$inputNome.focus();

			smallShake($inputNome, 5)

			return e.preventDefault();
		}


	});

});