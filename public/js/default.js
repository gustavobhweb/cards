(function(String){

    String.prototype.format = function () {

        var args = arguments;

        return this.replace(/\{(\d+)\}/g, function(match, index){

            return args[index];

        }).toString();
    }

})(String);

var Captcha = (function () {

    var Captcha = new Function();

    var lastRequestSettings = {};

    var exceptions = [];


    /**
    * Envia uma requisição assincrona para o determinado url do captcha
    */

    Captcha.prototype.getRequest = function (captcha_value, object) {
            
        if (typeof captcha_value !== 'string') {

            throw new Error('Primeiro argumeto deve ser uma string');
        }

        var defaultSettings = {
            url: '/captcha-validate',
            type: 'POST',
            data: {captcha: captcha_value.trim(), _token: $('[name=_token]').val() }
        }

        var ajaxSettings = $.extend({}, defaultSettings, object)


        if (! ajaxSettings.data._token) {

            throw new Error(
                'Defina o token no formulário. Caso não tenha definido, utilize object["data"]["_token"]'
            );
        }

        if (! ajaxSettings.data.captcha) {

            throw new Error('Defina o valor "Captcha" para object["data"]')
        }

        lastRequestSettings = ajaxSettings;

        try{

            return $.ajax(ajaxSettings);

        } catch(e) {
            
            exceptions.push(e.message);

            return false;
        }


    };

    /*
        Simplifica o processo de verificação do Captcha
    */
    Captcha.prototype.isValid = function (Captcha)
    {   

        var options = {
            async: false
        }

        try {

            var response = $.parseJSON(this.getRequest(Captcha, options).responseText);

            return response['status'] || false;

        } catch (e) {

            exceptions.push(e.message);

            throw e

            return false;
        }

    }

    Captcha.prototype.debug = function ()
    {
        return {
            "last_request" : lastRequestSettings,
            "exceptions" : exceptions
        };
    }

    return function () {

        return new Captcha();
    }



}());

$(function(){
    var $btnMenuHeader = $('#btn-menu-header');
    var $rightTopMenu = $('#right-top-menu');
    $btnMenuHeader.on('click', function(){
        if ($rightTopMenu.data('open')) {
            $rightTopMenu.animate({
                width: '0px'
            }, function(){
                $(this).hide().data('open', false);
            });
        } else {
            $rightTopMenu.animate({
                width: '180px'
            }).show().data('open', true);
        }
    });

    $(window).setContextMenu({
        '<i class="halflings halflings-cog"></i> Minha conta': function()
        {
            $(location).attr('href', '/auth/meus-dados');
        },
        '<i class="halflings halflings-remove"></i> Sair': function()
        {
            $(location).attr('href', '/logout');
        }
    });

});

$.prototype.showModal = function()
{
    $(this).on('click', function()
    {
        var $modal = $("<div></div>");
        $modal.css({
            width: '50%',
            height: '50%',
            background: '#FFFFFF',
            position: 'fixed',
            left: '25%',
            top: '25%',
            zIndex: 1000,
            opacity: 0
        });

        $('body').append($modal);

        $modal.animate({
            opacity: 0.7,
            width: '100%',
            height: '100%',
            left: 0,
            top: 0,
            filter: 'blur(5px)'
        });

        $(window).on('keyup', function(event)
        {
            if (event.keyCode == 27) {
                $modal.animate({
                    width: '90%',
                    height: '90%',
                    left: '5%',
                    top: '5%',
                    opacity: 0
                }, function()
                {
                    $(this).remove();
                });
            }
        });
    });

    return $(this);
}