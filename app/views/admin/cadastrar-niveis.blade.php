@extends('layouts.default')

@section('title') Cadastrar níveis @stop

@section('topbar')
<h4><i class="halflings halflings-tower"></i> Cadastrar novo nível</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')

@if(isset($alert))
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

<form method="post">
	<input type="text" name="titulo" id="titulo" class="medium" placeholder="Título do nível" />
	<button type="submit" class="btn medium green">
		<i class="halflings halflings-ok"></i> Salvar
	</button>
</form>

@stop