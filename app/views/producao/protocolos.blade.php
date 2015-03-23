@extends('layouts.default')


@section('topbar') 
	<h4><i class="glyphicon glyphicon-print"></i> Meu Histórico de  Protocolos</h4>
@stop


@section('content')

@if ($protocolos->count())
	<div class="jtable">
		<table>
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
					<td class="center">{{ zero_fill($protocolo->remessa_id, 4) }}</td>
					<td class="center">{{ (new Datetime($protocolo->created_at))->format('d/m/Y H:i') }}</td>
					<td class="center">{{ $protocolo->usuario->nome }}</td>
					<td class="center">
						<a href="{{ URL::action('ProducaoController@getImprimirProtocolo', [$protocolo->remessa_id]) }}" class="btn medium" target="_blank">
							<i class="halflings halflings-list-alt"></i> Ver Protocolo
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- .jtable -->

<div>{{ $protocolos->links() }}</div>
@else
	<div class="j-alert-error">Você não imprimiu nenhum protocolo</div>
@endif



@stop 