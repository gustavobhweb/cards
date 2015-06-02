@extends('layouts.default')

@section('topbar') 
	<h4><i class="halflings halflings-plus"></i> {{{ $ficha->nome }}}</h4>
@stop

@section('content')

{{ Form::open(['method' => 'post', 'class' => 'left', 'style' => 'width: 40%', 'files' => true]) }}

	{{ Form::text('campo_chave', Input::old('campo_chave'), [
		'placeholder' => ucfirst($ficha->campo_chave),
		'class' 	  => 'medium total',
		'style'  	  => 'margin: 0 0 10px 0',
		'required'
	]) }}

	@foreach($ficha->camposVariaveis as $campo)
	{{ Form::text($campo->nome, Input::old($campo->nome), [
		($campo->obrigatorio) ? 'required' : '',
		'placeholder' => ucfirst($campo->nome),
		'class'		  => 'medium total',
		'style' 	  => 'margin: 0 0 10px 0'
	]) }}
	@endforeach

	@if($ficha->tem_foto)
	<button type="button" style="margin-bottom:10px" id="btn-fake-file" class="btn medium total">Selecione um arquivo...</button>

	{{ Form::file('imagem', [
		'id' 	=> 'imagem',
		'style' => 'display:none',
		'required' => 'required'
	]) }}
	@endif

	<a class="btn medium" href="{{ URL::previous() }}">
		<i class="halflings halflings-remove"></i>
		Cancelar
	</a>

	<button class="btn medium green" style="margin: 0 0 0 5px">
		<i class="halflings halflings-ok"></i>
		Enviar solicitação
	</button>
{{ Form::close() }}

<img id="preview" style="display:none;margin:0 0 0 20px" width="130" />

@stop

@section('scripts')
{{ HTML::script('js/cliente/cadastro-unitario.js') }}
@stop