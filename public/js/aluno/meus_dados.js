$(function() {

    $('.cepInput').mask('00000-000');

    var captchaDefaultUrlSrc = $('#captcha').attr('src');

    $('#captcha-refresh').click(function(e) {
        e.preventDefault();

        var param = $.param({
            rand : Math.random()
        });

        $('#captcha').attr('src', captchaDefaultUrlSrc + param);
    });

    $('#confirmaEmail, #email').bind(
            'contextmenu copy paste cut dragstart drop', function(e) {
                return e.preventDefault();
            });

    $('.btn-verificar-cep').click(function(e){

        var $cepInput = $('.cepInput');

        if ($cepInput.is(':invalid')) {
            return false;
        }


        var cep = $cepInput.val().replace(/[^0-9]+/g, ''),
            link = 'http://cep.correiocontrol.com.br/' + cep + '.json';

         $.ajax({
            url: link,
            type: 'get',
            dataType: 'json',
            beforeSend: function(){
                $('#cep-error').hide();
            },
            success: function (response) {

                var $cidade = $("#cidade"),
                    $uf = $("#uf");

                if (! $cidade.is(':contains('+response.localidade+')')) {

                    $cidade.append($('<option />', {
                        html: response.localidade,
                        value: response.localidade
                    }));
                }


                if (!  $uf.is(':contains('+response.uf+')')) {

                    $uf.append($('<option />', {
                        html: response.uf,
                        value: response.uf
                    }));
                }

                $('#form-meus-dados').objectForm({
                    bairro      : response.bairro,
                    cidade      : response.localidade,
                    endereco    : response.logradouro,
                    uf          : response.uf,
                });
                
                
                $cidade.add($uf).trigger('change');
                


            }

         }).then(null, function(){
            $('#cep-error').fadeIn();
         });
    });


    $('#form-meus-dados').submit(function (e){

        var $confirmaEmail = $('#confirmaEmail');

        if ($confirmaEmail.val() !== $('#email').val()) {
            confirmaEmail.focus();

            return e.preventDefault();
        }

    });
    
    
    

    $('input,select').on('change keyup', function(e) {
    	
		var $self = $(this);
		
		var $emails = $('#confirmaEmail, #email');
		
		var isInvalidEmail = $emails.is(e.target);
		
		if (isInvalidEmail) {
			
			if ($('#confirmaEmail').val() != $('#email').val()) {
				
				$emails
					.removeClass('input-valid')
					.addClass('input-error')
					.siblings('.glif')
					.show()
					.find('.glyphicon')
					.addClass('glyphicon-remove')
					.removeClass('glyphicon-ok');
				
			} else {
				
				$emails
					.addClass('input-valid')
					.removeClass('input-error')
					.siblings('.glif')
					.show()
					.find('.glyphicon')
					.removeClass('glyphicon-remove')
					.addClass('glyphicon-ok');
			}
			
			return;
		}
		
		if ($self.is(':invalid')) {
			
			$self.removeClass('input-valid').addClass('input-error');

			$self.siblings('.glif')
				.show()
				.find('.glyphicon')
				.addClass('glyphicon-remove')
				.removeClass('glyphicon-ok');
			
			
		} else {
			
			$self.removeClass('input-error')
				.addClass('input-valid');

			$self.siblings('.glif')
				.show()
				.find('.glyphicon')
				.addClass('glyphicon-ok')
				.removeClass('glyphicon-remove')
		}
	});
});
