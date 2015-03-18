@extends('layouts.default')

@section('title') Página inicial @endsection

@section('content')
<div style="margin:0 0 0 10px">
    <div style="float:left;margin:20px 0 0 30px">
        <div id="pieChartContainer"></div>
    </div>
    <div style="float:left;margin:40px 0 0 30px">
        <div id="chartContainer"></div>
        <dl class="dl-horizontal labelsCharts" style='display:none'>
            <a href='<?=URL::to("cliente/relatorio/analise")?>'>
                <dt id="-analise"></dt>
                    <dd>análise da foto</dd>
            </a>
            <a href='<?=URL::to("cliente/relatorio/fabricacao")?>'>
                <dt id="-fabricacao"></dt>
                    <dd>fabricação</dd>
            </a>
            <a href='<?=URL::to("cliente/relatorio/expedido")?>'>
                <dt id="-expedido"></dt>
                    <dd>expedido</dd>
            </a>
            <a href='<?=URL::to("cliente/relatorio/disponivel")?>'>
                <dt id="-disponivel"></dt>
                    <dd>disponível para entrega</dd>
            </a>
            <a href='<?=URL::to("cliente/relatorio/entregue")?>'>
                <dt id="-entregue"></dt>
                    <dd>entregue</dd>
            </a>
            <a href='<?=URL::to("cliente/relatorio/reprovada")?>'>
                <dt id="-reprovada"></dt>
                    <dd>foto reprovada</dd>
            </a>
        </dl>
    </div>
</div>
@endsection

@section('scripts')
{{ 
    HTML::script('js/globalize.min.js'),
    HTML::script('js/dx.chartjs.js'),
    HTML::script('js/cliente/inicial.js') 
}}
@endsection

@section('styles')
	{{ HTML::style('css/cliente/inicial.css') }}
@endsection