@extends('layouts.default')

@section('title') Stats @stop

@section('content')
	<div id="pieChartContainer"></div>
	<div id="chartContainer"></div>
@stop

@section('styles')
{{
	HTML::style('css/financeiro/stats.css')
}}
@stop

@section('scripts')
{{
	HTML::script('js/globalize.min.js'),
    HTML::script('js/dx.chartjs.js'),
    HTML::script('js/financeiro/stats.js')
}}
@stop