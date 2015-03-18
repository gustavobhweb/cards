@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-list-alt"></i> Ficha Técnica - {{{ $ficha->nome }}}</h4>
@stop

@section('content')

{{ 
    $message->first(
        'message',
        '<div class="alert success"><i class="halflings halflings-ok"></i> :message</div>'
    ) 
}}

<div id="box-imagens" class="clearfix gray-box">
    <div class='wm-grid wm-grid-6 text-center'>
    <h4>Foto da Frente</h4>
    {{ 
        HTML::image(
            $ficha->foto_frente_link,
            "Foto da frente do modelo do cartão",
            ['class' => 'img-ficha']
        )
    }}
    </div>

    <div class='wm-grid wm-grid-6 text-center'>
    <h4>Foto da Verso</h4>
    {{ 
        HTML::image(
            $ficha->foto_verso_link,
            "Foto da frente do modelo do cartão",
            ['class' => 'img-ficha']
        )
    }}
    </div>
</div>

<div  id="box-campos" class="clearfix gray-box">

    <h1 class="text-center">Descrição da Ficha Técnica</h1>

    <div class='wm-grid wm-grid-4'>

        <section class="jtable">

            <table>
                <thead>
                    <tr>
                        <th>Campo Chave</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr class="text-center">
                        <td>{{{ $ficha->campo_chave }}}</td>
                    </tr>
                    
                </tbody>
            </table>

        </section><!-- .jtable -->

    </div><!-- .wm-grid.wm-grid-4 -->

    <div class='wm-grid wm-grid-4'>

        <section class="jtable">

            <table>
                <thead>
                    <tr>
                        <th>Nome dos Campos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ficha->camposVariaveis as $campo)
                    <tr>
                        <td>{{{ $campo->nome }}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </section><!-- .jtable -->

    </div>

    

    <div class='wm-grid wm-grid-4'>

        <section class="jtable">
            <table>
                <thead>
                    <tr>
                        <th>Descrição do Cartão</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ficha->tiposCartao as $tipo)
                    <tr>
                        <td>{{{ $tipo->nome }}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section> <!-- .jtable -->

    </div> <!-- .wm-grid.wm-grid-4 -->
</div>

<div class="total" style="float:left;">
    {{ Form::open() }}
    <button type="submit" class="btn large green">
        <i class="halflings halflings-ok"></i> Aprovar Ficha Técnica
    </button>
    {{ Form::close() }}
</div>

@stop


@section('styles')
{{ 
    HTML::style('css/jtable.css'),
    HTML::style('css/cliente/aprovar_ficha_tecnica.css'),
    HTML::style('css/wm-grid.css')
}}

@append