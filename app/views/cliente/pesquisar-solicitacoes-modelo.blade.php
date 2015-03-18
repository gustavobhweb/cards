@extends('layouts.default')

@section('title') Solicitacoes de {{{ $ficha->nome }}} @stop

@section('content') 

	{{ Form::open(['method'=>'GET']) }}
		{{ Form::text('search', '', [
			'class' => 'wm-input',
			'placeholder' => 'Pesquisar por ' . ucfirst($ficha->campo_chave)
		]) }}
		{{ Form::button("<i class='glyphicon glyphicon-search'></i>", [
			'class' => 'wm-btn wm-btn-blue',
			'type' => 'submit'
		]) }}
	{{ Form::close() }}

	@if($solicitacoes->count())
	<div class="jtable">
		<table>
			<thead>
				<th>{{{ ucfirst($ficha->campo_chave) }}}</th>
				@foreach($ficha->camposVariaveis as $cabecalho)
					<th>{{ humanize($cabecalho->nome) }}</th>
				@endforeach
				<th>Via</th>
				<th>Remessa</th>
				<th>Foto</th>
			</thead>
			<tbody>
				@foreach($solicitacoes as $solicitacao)
					<tr class="text-center">
						<td>{{ $solicitacao->codigo }}</td>
						@foreach($solicitacao->camposVariaveis as $campo)
							<td>{{ $campo->pivot->valor }}</td>
						@endforeach
						<td>{{ $solicitacao->via }}ª</td>
						<td>
							<a class="wm-btn wm-btn-blue" href="{{ URL::to('cliente/relatorios/?search=' . $solicitacao->remessa->id) }}">
							Relatório da remessa
							</a>
						</td>
						<td><img height="90" src="{{ URL::to($solicitacao->foto_link) }}" /></td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div data-section="footer">
			{{ $solicitacoes->links() }}
		</div>
	</div><!-- .jtable -->
	@else
		<div class="j-alert-error">
			Nenhuma solicitação encontrada.
		</div>
	@endif
@stop

@section('styles')
{{ HTML::style('css/jtable.css') }}
@append