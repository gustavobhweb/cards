$(function(){


    $('#nome').keydown(function (event) {
        var nameParts = this.value.match(/[^\s]+/g) || [];

    	if (nameParts.length < 2) {
    		var message = 'Esse campo deve conter pelo menos um sobrenome';
    		event.target.setCustomValidity(message);
    	} else {
    		event.target.setCustomValidity(null);
    	}

    }).bind('invalid', function() {
    	
    });

    var blockedCommands = [
        'contextmenu',
        'copy',
        'cut',
        'dragenter',
        'dragstart',
        'drop',
        'paste',
    ].join(' ');


    var validate = function () {

        var $email = $("#email"),
            $confirmaEmail = $('#confirmaEmail');

        if (($email).is(':valid') 
            && $email.val() != $confirmaEmail.val()) {
            $confirmaEmail.get(0).setCustomValidity(
                'O email digitado não confere'
            );

        } else {
            $confirmaEmail.get(0).setCustomValidity(null);
        }

        var $senha = $('#senha'),
            $confirmaSenha = $('#confirmaSenha');


        if ($senha.is(':valid') && $senha.val() != $confirmaSenha.val()) {
            $confirmaSenha.get(0).setCustomValidity(
                'A senha digita não confere'
            );
        } else {
            $confirmaSenha.get(0).setCustomValidity(null);
        }
    };

    $('.input-email-format')
        .find('input')
        .bind(blockedCommands, function(){
            return false;
        });

    $("#submit").click(validate);
});
