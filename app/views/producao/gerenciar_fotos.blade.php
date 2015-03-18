@extends('layouts.default') 

@section('title') <i class="glyphicon glyphicon-film"></i> Gerenciar Fotos @stop

@section('content')

@if(count($solicitacoes))
<section class="jtable">


    <div data-section='header' style="padding:10px 0 30px 10px">
        <p>Fotos para aprovação</p>
        {{ $errors->first('message', '<div class="pull-right j-alert-error">:message</div>') }}

        @if(Session::has('message'))
            <div class="pull-right j-alert-error">{{ Session::get('message') }}</div>
        @endif

        <button type='button' id='select-all' class='wm-btn wm-btn-blue pull-right' style='margin:0px 10px 10px 0'>
            <i class='glyphicon glyphicon-ok'></i> Selecionar todos
        </button>
    </div>
    <div class="clearifx"></div>

    @if($solicitacoes->count())

    {{ Form::open(['url' => 'producao/gerenciar-fotos' ]) }}
    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                @foreach($fichaTecnica->camposVariaveis as $cabecalho)    
                    <th>{{ $cabecalho->nome }}</th>
                @endforeach
                <th></th>
                <th ></th>
            </tr>
        </thead>

        <tbody>

            @foreach($solicitacoes as $solicitacao)

            <tr class="selectable" data-id="{{ $solicitacao->id }}">
                <td>{{ zero_fill($solicitacao->id, 4) }}</td>
                <td style="position:relative" width="40">

                    {{

                        HTML::image(
                            $solicitacao->foto_link,
                            "",
                            [
                                'height'  => 70,
                                'width'   => 53,
                                'class'   => 'mini-image',
                                'data-id' => $solicitacao->id
                            ]
                        );
                    }}
                </td>
                
                    @foreach($solicitacao->camposVariaveis as $campo)
                        <td>{{{ $campo->pivot->valor }}}</td>
                    @endforeach
                <td class="text-center">

                    <button type='button' data-id='{{ $solicitacao->id }}' class='wm-btn wm-btn-blue btn-editar-foto' style="margin-right:10px">
                        <span class='glyphicon glyphicon-picture'></span>
                     </button>


                    <button type='button' data-id='{{ $solicitacao->id }}' class='wm-btn wm-btn-red btn-reprovar-foto'>
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
                <td class="text-center" width="20">
                    {{ 
                        Form::checkbox(
                            "solicitacoes[]",
                            $solicitacao->id
                        )
                    }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div data-section='footer'>
        {{ 
            Form::button(
                'Aprovar', 
                [
                    'class' => 'btn-conf-iza',
                    'name'  => 'action',
                    'value' => 'aprovar',
                    'type'  => 'submit',
                    'style' => 'margin:0 10px'
                ]
            ) 
        }}
        <div class='clear'></div>
    </div>
    {{ Form::close() }}
    @else
        <div class='j-alert-error'>Não existem solicitações a serem analisadas</div>
    @endif
</section><!-- . jtable -->
@else
    <div class='j-alert-error'>Nenhuma foto para conferir.</div>
@endif


<div id='imageShow'>
	<div class="box">
		<img width="280" height="370" id='imageShowImg' />
	</div>
</div>


@stop 

@include('elements.common-alert')


@section('styles') 
{{

    HTML::style('css/jtable.css'),
    HTML::style('css/producao/aprovar_foto.css'),
    HTML::style('css/jquery-ui.css'),
    HTML::style('css/wm-modal.css'),
    HTML::style('css/jquery.ui.rotatable.css'),
    HTML::style('css/crop.css'),
    HTML::style('css/wm-grid.css')

}}

@append 

@section('scripts') 
{{
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/jquery.ui.rotatable.js'),
    HTML::script('js/producao/aprovar_foto.js'),
    HTML::script('js/wm-modal.js'),
    HTML::script('js/crop.js')
}}

@append

