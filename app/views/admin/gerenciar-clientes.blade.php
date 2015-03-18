@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-user"></i> Gerenciar Clientes ({{ $clientes->count() }})</h4>
@stop

@section('content')

{{ Form::open(['method' => 'get']) }}

	{{ Form::text('search', Input::old('search'), [
		'class' => 'medium',
		'style' => 'width:300px',
		'placeholder' => 'Pesquise pelo nome da empresa'
	]) }}

	@if(Input::has('search'))
	<a href="{{ URL::to('admin/gerenciar-clientes') }}" class="btn medium">{{{ Input::get('search') }}} <i class="halflings halflings-remove"></i></a>
	@endif

	{{ Form::submit('Enviar', [
		'class' => 'btn medium blue'
	]) }}
	
{{ Form::close() }}

@if($clientes->count())
<div class="jtable" style="margin: 10px 0 0 0">
	<table>
		<thead>
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Telefone</th>
				<th>Cadastrado em</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($clientes as $cliente)
			<tr>
				<td class="center">{{{ $cliente->nome }}}</td>
				<td class="center">{{{ $cliente->email }}}</td>
				<td class="center">{{{ $cliente->telefone }}}</td>
				<td class="center">{{{ $cliente->created_at->format('d/m/Y \à\s H:i:s') }}}</td>
				<td class="center">
					<button class="btn medium blue">
						<i class="halflings halflings-edit"></i>
					</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div><!-- .jtable -->
@else
	<div class="alert warning">
		Nenhum cliente foi encontrado.
	</div>
@endif
@stop