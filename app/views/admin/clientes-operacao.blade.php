@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-user"></i> Gerenciar Cliente</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')
	{{ Form::open() }}
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
				<h4>E-mail de contato</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::text('email', (isset($cliente->email) ? $cliente->email : ''), [
				'class' => 'medium total',
				'required' => 'required'
			]) }}
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>3</span>
				<h4>Telefone de contato</h4>
			</div>
			<div class="content-section" style="margin: 10px 0 0 0">
			{{ Form::text('telefone', (isset($cliente->telefone) ? $cliente->telefone : ''), [
				'class' => 'medium total',
				'required' => 'required'
			]) }}
			</div>
		</div>

		<button type="submit" class="btn medium green right" style="margin: 10px 0 0 0">
			<i class="halflings halflings-ok"></i> Salvar
		</button>

	{{ Form::close() }}
@stop
