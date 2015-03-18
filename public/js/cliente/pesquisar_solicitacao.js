$(function(){

	$('.passo').each(function(){

		var $self = $(this);

		var object = $self.data();

		var status = $self.closest('.regua').data('status')


		if (status >= object.greaterThan && $.inArray(status, object.notIn) == -1) {

			$self.addClass(object.class);

		} else {

			console.log(status)

		}





	})

});