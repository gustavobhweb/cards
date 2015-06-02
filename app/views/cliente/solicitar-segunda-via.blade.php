@extends('layouts.default')

@section('topbar')
	<h4>Solicitar segunda via</h4>
@stop

@section('content')

@if($ficha->solicitacoes->count())
<div class="jtable">
	<table>
		<thead>
			<tr>
				<th>{{ $ficha->campo_chave }}</th>
				@foreach($ficha->camposVariaveis as $campo)
					<th>{{ $campo->nome }}</th>
				@endforeach
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($ficha->solicitacoes as $solicitacao)
			<tr>
				<td>{{ $solicitacao->codigo }}</td>
				@foreach($solicitacao->camposVariaveis as $campo)
					<td>{{ $campo->pivot->valor }}</td>
				@endforeach
				<td class="center">
					<button class="btn medium blue btn-solicitar-2-via" data-id="{{ $solicitacao->id }}">
						Solicitar 2ª via
					</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div data-section="footer">
		{{ $ficha->solicitacoes->links() }}
	</div>
</div>
@else
	<div class="alert">Nenhuma solicitação foi encontrada!</div>
@endif
	
@stop

@section('scripts')
	{{ HTML::script('js/cliente/solicitar-segunda-via.js') }}
@stop