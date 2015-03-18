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
});