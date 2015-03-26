@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-user"></i> Gerenciar Cliente</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')
	{{ Form::open() }}
		@if(isset($message))
		<div class="alert {{ $message['status'] ? 'success' : '' }}">{{ $message['message'] }}</div>
		@endif
		<div class="fc-section">
			<div class="title">
				<span>1</span>
				<h4>Nome de identificação</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::text('nome', (isset($cliente->nome) ? $cliente->nome : ''), [
				'class' => 'medium total',
				'required' => 'required'
			]) }}
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>2</span>
				<h4>CNPJ</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::text('cnpj', (isset($cliente->cnpj) ? $cliente->cnpj : ''), [
				'class' => 'medium total',
				'id' => 'cnpj'
			]) }}
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>3</span>
				<h4>Pessoa de contato</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::text('pessoa_contato', (isset($cliente->pessoa_contato) ? $cliente->pessoa_contato : ''), [
				'class' => 'medium total'
			]) }}
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>4</span>
				<h4>E-mail de contato</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::email('email', (isset($cliente->email) ? $cliente->email : ''), [
				'class' => 'medium total'
			]) }}
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>5</span>
				<h4>Telefone de contato</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::text('telefone', (isset($cliente->telefone) ? $cliente->telefone : ''), [
				'class' => 'medium total',
				'id' => 'telefone'
			]) }}
			</div>
		</div>

		<button type="submit" class="btn medium green right" style="margin: 10px 0 0 0">
			<i class="halflings halflings-ok"></i> Salvar
		</button>

	{{ Form::close() }}
@stop

@section('scripts')
<script type="text/javascript">
$(function()
{
	$('#telefone').mask('(99) 9999-99999');
	$('#cnpj').mask('99.999.999/9999-99');
});
</script>
@stop