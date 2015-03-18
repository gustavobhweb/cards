@extends('layouts.default')

@section('title') Sortable @stop

@section('content')
    
    @foreach($colunas as $coluna)
    <div class="column" data-titulo="{{ $coluna->nome }}" data-id="{{ $coluna->id }}">
        @foreach($coluna->portlets as $portlet)
        <div class="portlet" data-id="{{ $portlet->id }}" data-ordem="{{ $portlet->ordem }}">
            <p>{{ $portlet->conteudo }}</p>
        </div><!-- .portlet -->
        @endforeach
    </div><!-- .column -->
    @endforeach
    
@stop

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<style>
    .column {
        width: 220px;
        float: left;
        padding: 10px;
        background:#EEEEEE;
        box-sizing: border-box;
        margin: 0 20px 0 0;
        border-radius: 3px;
    }
    .portlet {
        margin: 0 0 10px 0;
        padding: 0.3em;
        background: #FFFFFF;
        border:none;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }
    .column:before{
        content: attr(data-titulo);
        display:block;
        font: 18px Calibri;
        font-weight: bold;
        margin: 0 0 5px 0;
        color: #333333;
    }
    .portlet p{
        font: 14px Calibri;
        color: #333333;
    }
    .portlet-header {
        padding: 0.2em 0.3em;
        margin-bottom: 0.5em;
        position: relative;
    }
    .portlet-toggle {
        position: absolute;
        top: 50%;
        right: 0;
        margin-top: -8px;
    }
    .portlet-content {
        padding: 0.4em;
    }
    .portlet-placeholder {
        background: #dddddd;
        margin: 0 1em 1em 0;
        height: 50px;
        width: 100%;
    }
</style>
@stop

@section('scripts')
{{ HTML::script('js/jquery-ui.js') }}
<script type="text/javascript">
    $(function() {
        $( ".column" ).sortable({
            connectWith: ".column",
            cancel: ".portlet-toggle",
            placeholder: "portlet-placeholder ui-corner-all",
            start: function (event, ui)
            {
                ui.item.css({
                    transform: 'rotate(6deg)'
                });
            },
            stop: function (event, ui)
            {
                var portlet_prev = ui.item.prev();
                var portlet_next = ui.item.next();
                var portlet_id = ui.item.data('id');
                var coluna_id = ui.item.parent().data('id');

                var media = (portlet_prev.data('ordem') + portlet_next.data('ordem')) / 2;

                $.ajax({
                    url: '/admin/update-portlet-pos',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        portlet_id: portlet_id,
                        ordem: media,
                        coluna_id: coluna_id
                    },
                    success: function(response)
                    {

                    },
                    error: function()
                    {
                        console.error('Problemas na conexão!');
                    }
                });

                ui.item.css({
                    transform: 'rotate(0deg)'
                });
            }
        });
     
        $( ".portlet" )
        .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
        .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
     
        $( ".portlet-toggle" ).click(function() {
            var icon = $( this );
            icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
            icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
        });
    });
</script>
@stop