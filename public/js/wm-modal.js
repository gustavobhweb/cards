function wmDialog(text, options)
{

    // inverte os attributos dinamicamente

    if ($.isPlainObject(text)) {

        options = text;
        delete text;
    }

    var $modal     = $('#wm-alert').closest('.wm-modal').clone();
    var $body      = $modal.find('.wm-modal-body');
    var $container = $modal.find('#wm-alert');
    var $cancel    = $modal.find('.wm-modal-btn-cancel');
    var $confirm   = $modal.find('.wm-modal-btn-confirm');
    var $close     = $modal.find('.wm-modal-close');

    var defaults = {
        title: 'Alerta',
        btnOkEnabled: true
    };

    var options = $.extend(defaults, options || {})
    // initalize data
    function init()
    {

        this.html(text, options.isHTML);

        this.title(options.title)

        $modal.find('.wm-modal-box').draggable({
            handle: '.wm-modal-title'
        });

        $confirm.click(function(){
            
            if ($.isFunction(options.onConfirm)) {
                options.onConfirm($modal);
            } else {
                $modal.fadeOut();
            }
            
        });

        $cancel.add($close).click(function(){

            if ($.isFunction(this.onCancel)) {

                this.onCancel(this);

            } else {

                $modal.fadeOut();
            }
        });

    }

    this.title = function(title) {

        $container.find('.wm-modal-title').html(title);

        return this;
    }


    this.html = function(text, isHTML){

        if (! isHTML) {
            $body.text(text);
        } else {
            $body.html(text);
        }

        return this;
    }


    this.open = function(callback) {

        if (!options.btnCancelEnabled) {
            $cancel.remove();
        }

        if (!options.btnOkEnabled) {
            $confirm.remove();
        }

        $body.fadeIn(500, callback);


        $container.height(options.height).width(options.width);


        if ($.isFunction(options.btnConfirm)) {
            options.btnConfirm($confirm)
        }

        if ($.isFunction(options.btnCancel)) {

            options.btnCancel($cancel);
        }

        $modal.appendTo($('body')).fadeIn();
    }

    this.close = function(){
        $modal.fadeOut(500);

        return this;
    }

    this.attr = function(options){

        $container.attr(options);

        return this;
    }

    this.css = function(options) {

        $container.css(options);

        return this;
    }

    this.$container = function () {

        return $container;
    }


    return init.call(this);

}