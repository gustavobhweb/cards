@extends('layouts.default')

@section('title') Editar Usuário @stop

@section('content')
@if(count($usuarios))
<div class="jtable">
	<table>
		<thead>
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Data Cadastro</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($usuarios as $usuario)
			<tr>
				<td>{{{ $usuario->nome }}}</td>
				<td>{{ $usuario->email }}</td>
				<td style="text-align:center">{{ (new DateTime($usuario->created_at))->format('d/m/Y') }}</td>
				<td style="text-align:center">
					<a 
						href="{{ URL::action('AdminClienteController@getEditarUsuario', [$usuario->id]) }}"
						class="wm-btn wm-btn-blue" >
						<i class="glyphicon glyphicon-pencil"></i>
						Editar
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div><!-- .jtable -->
@else
<div class='error'>Nenhuma remessa foi encontrada.</div>
@endif

@stop

@section('styles')
	{{ HTML::style('css/jtable.css') }}
@stop