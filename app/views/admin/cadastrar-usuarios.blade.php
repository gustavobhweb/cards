@extends('layouts.default')

@section('title') Cadastrar usuários @stop

@section('topbar')
<h4><i class="glyphicons glyphicons-user-add" style="margin:-2px 3px 0 0"></i> Cadastrar novo usuário</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')

@if(isset($alert) && is_array($alert))
	@if(!$alert['status'])
	<div class="alert warning">
		<i class="halflings halflings-warning-sign"></i> 
		{{ $alert['message'] }}
	</div>
	@else
	<div class="alert success">
		<i class="halflings halflings-ok"></i> 
		{{ $alert['message'] }}
	</div>
	@endif
@endif

<form method="post" class="frm-cadastro">
	<input type="text" class="medium" name="username" id="username" placeholder="Usuário" required /><br>
	<input type="password" class="medium" name="password" id="password" placeholder="Senha" required /><br>
	<input type="text" required class="medium" name="nome" placeholder="Nome" /><br>
	<select name="nivel_id" class="medium" required>
		<option value="">Selecione o nível</option>
		@foreach($niveis as $nivel)
			<option value="{{ $nivel->id }}">{{ $nivel->titulo }}</option>
		@endforeach
	</select>
	<select name="cliente_id" class="medium">
		<option value="">Selecione o cliente</option>
		@foreach($clientes as $cliente)
			<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
		@endforeach
	</select>
	<br>
	<button type="submit" class="btn medium green right">
		<i class="halflings halflings-ok"></i> Salvar
	</button>
</form>

@stop

@section('styles')
{{ HTML::style('css/admin/cadastrar-usuarios.css') }}
@stop