@extends('layouts.default')

@section('topbar') 
	<h4><i class="halflings halflings-stats"></i> Relatórios</h4>
@stop

@section('content')
	
	{{ Form::open(['method' => 'get']) }}
		{{ Form::text('search', '', [
			'class' => 'medium',
			'placeholder' => 'Nº da remessa'
		]) }}
		{{ Form::button("Pesquisar", [
			'class' => 'btn medium blue',
			'type' => 'submit'
		]) }}
	{{ Form::close() }}

	@if($remessas->count())

		<div class="jtable" style="margin:10px 0 0 0">
			<table>
				<thead>
					<tr>
						<th>Nº da remessa</th>
						<th>Qtd. de solicitações</th>
						<th>Modelo</th>
						<th>Data da solicitação</th>
						<th>Responsável</th>
						<th>+ Info</th>
						<th colspan="2">Ações</th>
					</tr>
				</thead>
				<tbody>
					@foreach($remessas as $remessa)
					<tr class="text-center">
						<td class="center">{{ zero_fill($remessa->id, 4) }}</td>
						<td class="center">{{ $remessa->solicitacoes->count() }}</td>
						<td class="center">{{ $remessa->fichaTecnica->nome }}</td>
						<td class="center">{{ $remessa->created_at->format('d/m/Y \à\s H:i:s') }}</td>
						<td class="center">{{ $remessa->usuario->nome }}</td>
						<td class="center">
							<a class="btn blue" href="{{ URL::to('cliente/linha-tempo-remessa', [$remessa->id]) }}">
								<i class="halflings halflings-plus"></i> Info
							</a>
						</td>
						<td class="center">
							<a href="{{ URL::to('cliente/download-relatorio-remessa-pdf', [$remessa->id]) }}" type="button" class="btn blue">
								<i class="halflings halflings-arrow-down"></i> Download PDF
							</a>
						</td>
						<td>
							<a href="{{ URL::to('cliente/download-relatorio-remessa-excel', [$remessa->id]) }}" type="button" class="wm-btn wm-btn-excel"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div data-section="footer">
				{{ $remessas->links() }}
			</div>
		</div><!-- .jtable -->
	@else
		<div class="alert warning">
			Nenhuma remessa foi encontrada.
		</div>
	@endif

@stop

@section('styles')
{{ HTML::style('css/jtable.css') }}
@append