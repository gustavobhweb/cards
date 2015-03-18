@extends('layouts.default')

@section('title') Histórico de solicitação @stop

@section('content')

<a href="{{ URL::previous() }}" class="btn medium">Voltar</a>

<div class='situacao-box'>
    
    <div class='left-infos'></div>
    <div class='infos'>
        <div style="float: left; width: 75%">
            <h3 class='via'>Remessa {{ zero_fill($remessa->id, 4) }}</h3>
            <div class='modelos'>
                
                <div 
                    class='modelo frente'
                    style="background-image:url({{$remessa->fichaTecnica->foto_frente_link}})"
                >
                </div>

                <div
                    class='modelo verso'
                    style="background-image:url({{$remessa->fichaTecnica->foto_verso_link}})"
                >
                </div>
            </div>
            <!-- .modelos -->
            <div class='regua' data-status="{{ $remessa->status_atual_id }}">
                @foreach($status as $k => $stat)
                <div class='passo {{{ (in_array($stat->id, $meusStatus)) ? $stat->cor : '' }}}' data-step='{{ $k+1 }}'>
                    <p>{{{ $stat->titulo }}}</p>
                </div>    
                @endforeach
            </div><!-- .regua -->
        </div>
        <div class="status-list">
            <div class='title'></div>
            <div class='content'>

                <?php $letter = 'A' ?>

                @foreach($remessa->status as $status)
                
                <div class='item'>
                    <h3>{{ $letter }}</h3>
                    <div class='right'>
                        <h4>{{ $status->titulo }}</h4>
                        <p>{{ $status->pivot->created_at->format('d/m/Y à\s H:i')  }}</p>
                    </div>
                    <!-- .right -->
                </div>
                <!-- .item -->
                <?php $letter++ ?>

                @endforeach
            </div>
            <!-- .content -->
        </div>
        <!-- .status-list -->
    </div>
    <!-- .infos -->
</div><!-- .situacao-box -->

<section class="jtable">
    <table>
        <thead>
            <tr>
                <th>{{ ucfirst($remessa->fichaTecnica->campo_chave) }}</th>
                @foreach($remessa->fichaTecnica->camposVariaveis as $cabecalho)
                    <th>{{ humanize($cabecalho->nome) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($remessa->solicitacoes as $solicitacao)
            <tr class="text-center">
                <td>{{ zero_fill($solicitacao->codigo, 4) }}</td> 

                @foreach($solicitacao->camposVariaveis as $campo)
                    <td>{{{ $campo->pivot->valor }}}</td>
                @endforeach
            </tr>  
            @endforeach
        </tbody>
    </table>
</section>



@include('elements.common-alert')

@stop

@section('styles')
{{ 
    HTML::style('css/jtable.css'),
    HTML::style('css/cliente/pesquisar_solicitacao.css') 
}}
@append

@section('scripts')
{{ 
    HTML::script('js/jquery-ui.js')
}}
@append