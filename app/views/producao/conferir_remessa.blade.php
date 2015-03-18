@extends('layouts.default') @section('title') Conferência da remessa
@stop @section('content') @if($count = $solicitacoes->count())
<h3 class='pull-right'>Remessa {{ zero_fill($remessa->id, 4) }}</h3>
<h3>Número de solicitações: {{ zero_fill($count, 2) }}</h3>
<div class="jtable">
<table>
    <thead>
        <tr>
            <th></th>
            <th>Foto</th>
            @foreach($remessa->fichaTecnica->camposVariaveis as $ficha)
                <th>{{ ucfirst(str_replace('_', ' ', $ficha->nome)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($solicitacoes as $solicitacao)
        <tr class="text-center">
            <td>
                @if($solicitacao->conferido)
                    <span
                        class="status-indicator ok glyphicon glyphicon-ok-sign">
                    </span>
                @else
                    <span
                        class="status-indicator waiting glyphicon glyphicon-minus">
                    </span>
                @endif
            </td>

            <td>
                <img 
                    title="Solicitação: {{ zero_fill($solicitacao->id, 4) }}"
                    width="50" height="70"
                    src="{{ URL::to('solicitacoes', [$remessa->id, $solicitacao->foto]) }}"
                />
            </td>
            @foreach($solicitacao->camposVariaveis as $campo)
                <td>{{ $campo->pivot->valor }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@else
<div class="j-alert-error">Não há solicitações para produção</div>
@endif

<section>
    <div class="clearfix">
        {{ Form::open(['files' => true]) }}
        <div class="wm-input-container">
            <div class="warning">
                <p>
                    Selecione o seu arquivo <strong>XLS</strong> ou <strong>XLSX</strong>
                    contendo a coluna <strong>{{ $remessa->fichaTecnica->campo_chave }}</strong>
                    e clique no botão <strong>Enviar</strong>
                </p>
                <p>
                    Os arquivos deverão ter todos os campos de acordo com o <a
                        target="_blank" class="link"
                        href="{{ URL::to('xls/modelo/conferencia.xls') }}">modelo</a>
                </p>
            </div>

            <div class='text-right'>{{ Form::file('excel', ['style' =>
                'display:none', 'id' => 'hidden-excel-file-input']) }} {{
                Form::button( 'Selecione um arquivo ...', [ 'id' =>
                'fake-file-excel', 'class' => 'wm-btn', ] ) }} {{
                Form::button('Enviar', ['class' => 'wm-btn', 'type' => 'submit']) }}
            </div>
        </div>


        @if($errors->has('message'))
        <div class="j-alert-error">{{ $errors->first('message') }}</div>
        @endif @if(Session::has('successMessage')) {{
        Session::get('successMessage') }} @endif {{ Form::close() }}
    </div>
</section>
@stop @section('scripts') {{
HTML::script('js/producao/conferir_remessa.js') }} @stop


@section('styles') 
{{ 
    HTML::style('css/producao/conferir_remessa.css'),
    HTML::style('css/jtable.css')
}} 
@stop
