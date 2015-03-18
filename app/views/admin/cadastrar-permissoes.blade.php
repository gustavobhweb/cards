@extends('layouts.default')

@section('title') Cadastrar permissões @stop

@section('topbar')
<h4><i class="halflings halflings-plus"></i> Cadastrar nova permissão</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')
@if(isset($message))
<div class="j-alert-error">
	{{ $message }}
</div>
@endif

<form method="post" class="frm-cadastro">
	<input type="text" id="debug" required class="medium" name="name" placeholder="Name" /><br>
	<div style="position:relative">
		<input type="text" autocomplete="off" required class="medium" id="input-action" name="action" placeholder="Action" /><br>
		<div class="box-search-action">
			<!-- <div class="item">Controller@method</div> -->
		</div><!-- .box-search-action -->
	</div>
	<input type="text" required class="medium" id="input-url" name="url" placeholder="URL" /><br>
	<input type="text" class="medium" name="glyphicon" placeholder="Glyphicon" /><br>
	<select id="select-type" class="medium" name="type" required>
		<option value="">Tipo da requisição</option>
		<option value="any">ANY</option>
		<option value="get">GET</option>
		<option value="post">POST</option>
		<option value="put">PUT</option>
		<option value="delete">DELETE</option>
	</select><br>
	<select name="in_menu" class="medium" required>
		<option value="">No menu</option>
		<option value="1">Sim</option>
		<option value="0">Não</option>
	</select>
	
	<a href="{{ URL::to('admin/acl') }}" type="button" class="btn medium">
		<i class="halflings halflings-remove"></i> Cancelar
	</a>
	<button type="submit" class="btn medium green" style="margin:0 0 0 5px">
		<i class="halflings halflings-ok"></i> Salvar
	</button>
</form>
@stop

@section('styles')
{{ HTML::style('css/admin/cadastrar-permissoes.css') }}
@stop

@section('scripts')
{{ HTML::script('js/admin/cadastrar-permissoes.js') }}
@stop