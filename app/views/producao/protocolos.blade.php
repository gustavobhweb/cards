@extends('layouts.default')


@section('title') <i class="glyphicon glyphicon-print"></i> Meu Histórico de  Protocolos @stop


@section('content')

@if ($protocolos->count())
	<table class="wm-table big">
		<thead>
			<tr>
				<th>Remessa</th>
				<th>Data</th>
				<th>Responsável</th>
				<th>Ver</th>
			</tr>
		</thead>
		<tbody>
			@foreach($protocolos as $protocolo)
			<tr>
				<td>{{ zero_fill($protocolo->remessa_id, 4) }}</td>
				<td>{{ (new Datetime($protocolo->created_at))->format('d/m/Y H:i') }}</td>
				<td>{{ $protocolo->usuario->nome }}</td>
				<td>
					<a href="{{ URL::action('ProducaoController@getImprimirProtocolo', [$protocolo->remessa_id]) }}" class="link">Ver Protocolo</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

<div>{{ $protocolos->links() }}</div>
@else
	<div class="j-alert-error">Você não imprimiu nenhum protocolo</div>
@endif



@stop 