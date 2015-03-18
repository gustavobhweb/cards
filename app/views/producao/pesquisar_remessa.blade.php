@extends('layouts.default')

@section('title') Pesquisar por Remessa @stop

@section('content')

<div>
    {{
        Form::open(['method' => 'get']) 
    }}

    {{
        Form::text(
            'remessa_id', 
            Input::get('remessa_id'),
            [
                'class' => 'wm-input',
                'placeholder' => 'Pesquisar Remessa',
                'id'    => 'pesquisar-remessa'
            ]
        ) 
    }}

    {{ 
        Form::button(
            'Pesquisar', 
            ['class' => 'wm-btn', 'type' => 'submit']
        ) 
    }}

    {{
        Form::close() 
    }}

</div>

<br />

<div class="jtable">
    @if (isset($solicitacoes) && $solicitacoes->count())
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Matrícula</th>
                <th>Código W</th>
                <th>Data</th>
            </tr>
        </thead>    
        <tbody>
            @foreach($solicitacoes as $solicitacao)
                <?php
                    $foto = URL::to(
                        "imagens/{$solicitacao->usuario->matricula}/{$solicitacao->foto}"
                    );
                ?>
                <tr class='text-center'>
                    <td>
                        <div 
                            data-src="{{ $foto }}" class='mini-image img-aluno' 
                            style='background-image:url({{ $foto }})'
                            title=""
                        ></div>
                    </td>
                    <td>{{ $solicitacao->usuario->nome }}</td>
                    <td>{{ $solicitacao->usuario->email }}</td>
                    <td>{{ $solicitacao->usuario->matricula }}</td>
                    <td>{{ $solicitacao->codigo_w  }}</td>
                    <td>
                    @if($solicitacao->created_at)
                    {{
                        (new Datetime($solicitacao->created_at))->format('d/m/Y H:i') 
                    }}
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else

        @unless($errors->has('message'))
            <div class='j-alert-error'>Selecione uma remessa</div>
        @else
            <div class='j-alert-error'>{{ $errors->first('message') }}</div>
        @endif
        
    @endif
</div>

@stop


@section('scripts')
{{ 
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/producao/pesquisar_remessa.js')
}}
@stop


@section('styles')
{{
    HTML::style('css/jquery-ui.css'),
    HTML::style('css/jtable.css'),
    HTML::style('css/producao/pesquisar_remessa.css')
}}
@stop