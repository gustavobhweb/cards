@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-dashboard"></i> Histórico de remessas</h4>
@stop

@section('content')

{{ Form::open(['method' => 'get']) }}
    {{ Form::text('remessa_id', '', [
        'class' => 'medium ',
        'placeholder' => 'Nº da remessa'
    ]) }}
    {{ Form::button("Pesquisar", [
        'class' => 'btn medium blue',
        'type' => 'submit'
    ]) }}
{{ Form::close() }}

<div class="content-remessas">
@if($remessas->count())
<div class="jtable" style="margin:10px 0 0 0">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nº de Solicitações</th>
                <th>Status</th>
                <th>Enviar fotos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($remessas as $remessa)
            <tr>
                <td class="center">{{ zero_fill($remessa->id, 4) }}</td>
                <td class="count-total center">{{ $remessa->solicitacoes->count() }}</td>
                <td class="center">{{{ $remessa->status_atual->titulo }}}</td>

                <td class="container-input-file center" data-id="{{ $remessa->id }}">
                    <a 
                        href="{{ URL::to('cliente/linha-tempo-remessa', [$remessa->id]) }}" 
                        class="btn medium blue more-info">

                        <i class="halflings halflings-plus"></i> Mais informações
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div data-section="footer">
        {{ $remessas->links() }}
    </div>
</div><!-- .jtable -->
@else
    <div class="alert warning">
        Nenhuma remessa encontrada 
        <a href="{{ URL::previous() }}" class="btn">Voltar</a>
    </div>
@endif
</div><!-- .content-remessas -->

@include('elements.common-alert')

@stop

@section('styles')
{{ 
    HTML::style('css/jtable.css')
}}
@append

@section('scripts')
{{ 
    HTML::script('js/cliente/remessas.js'),
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/underscore-min.js')
}}
@append