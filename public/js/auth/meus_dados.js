$(function(){

	var $boxPassword = $("#box-password"),
		$passwordShow = $(".password-show");


	if ($boxPassword.is(':visible')) {

			$passwordShow.filter('[value=1]').attr({checked:true});

	} else {

		$passwordShow.filter('[value=0]').attr({checked:true});
	}

    $('#form-meus-dados').find(':input').keyup(function(e) {
        
        var $self = $(this);

        if ($self.is(':invalid')) {

            $self.addClass('input-error').removeClass('input-valid');

        } else {

            $self.removeClass('input-error').addClass('input-valid');

        }

    });


    $passwordShow.change(function(){

    	var value = parseInt($(this).val());

    	console.log(value)

    	if (value) {
    		$boxPassword.show();
    	} else {
    		$boxPassword.hide();
    	}

    });

});