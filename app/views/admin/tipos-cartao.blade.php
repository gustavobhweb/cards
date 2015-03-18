@extends('layouts.default')


@section('title') Tipos de Cartão @stop

@section('topbar')
<h4><i class="glyphicons glyphicons-credit-card" style="margin:-2px 3px 0 0"></i> Gerenciar tipos de cartão</h4>
<div class="list-menu right small">
	<button class="btn medium orange"><i class="halflings halflings-cog"></i> Gerenciar <span class="caret"></span></button>
	<div class="box">
		<ul>
			<li>
				<a href="{{ URL::to('admin/cadastrar-tipo-cartao') }}">
					<i class="halflings halflings-plus"></i>
					Cadastrar tipo
				</a>
			</li>
			<li>
				<a href="{{ URL::previous() }}">
					<i class="halflings halflings-remove"></i>
					Cancelar
				</a>
			</li>
		</ul>
	</div><!-- .box -->
</div>
@stop

@section('content')

<a class="wm-btn wm-btn-blue" href="{{ URL::to('admin/cadastrar-tipo-cartao') }}">
	<span class="glyphicon glyphicon-plus"></span>
	
</a>

<section class="jtable">
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Ativo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($tiposCartao as $tipo)
			<tr>
				<td class="center">{{ $tipo->id }}</td>
				<td>{{{ $tipo->nome }}}</td>
				<td class="center">{{ $tipo->status ? 'Sim' : 'Não' }}</td>
				<td class="center">

					<a class="wm-btn wm-btn-blue" href="{{ URL::to('admin/editar-tipo-cartao', [$tipo->id]) }}">
						<span class="glyphicon glyphicon-edit"></span>
					</a>

					@if($tipo->status)
					    <a data-id="{{ $tipo->id }}" class="change-status desativar btn" href='#'>Desativar</a>
					@else
					    <a data-id="{{ $tipo->id }}" class="change-status ativar btn blue" href='#'>Ativar</a>
					@endif

				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{{ $tiposCartao->links() }}
</section>

@include('elements.common-alert')
@stop


@section('styles')
{{
	HTML::style('css/jtable.css'),
	HTML::style('css/admin/tipos-cartao.css')
}}
@append


@section('scripts')
{{ HTML::script('js/admin/tipos-cartao.js')}}
@append