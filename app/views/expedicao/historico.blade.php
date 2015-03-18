@extends('layouts.default')

@section('title') <i class="glyphicon glyphicon-dashboard"></i> Histórico de expedição @endsection

@section('content')

@if(count($entregas))
<div class='jtable'>
	<table>
		<thead>
			<tr>
				<th>Nº da remessa</th>
				<th>Qtd. de cartões</th>
				<th>Responsável</th>
				<th>Data da remessa</th>
				<th>Status</th>
				<th>Mais informações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($entregas as $entrega)
			<tr>
				<td>{{ zero_fill($entrega->id, 4) }}</td>
				<td>{{ $entrega->solicitacoes->count() }}</td>
				<td>{{ $entrega->nome }}</td>
				<td>{{ (new Datetime($entrega->data_criacao))->format('d/m/Y') }}</td>
				<td style="text-align:center"><?php 
					switch ($entrega->status_atual_id) {
						default:
						case 5:
							echo 'Saiu para entrega';
							break;
						case 5:
							echo 'Disponível para';
							break;
						case 5:
							echo 'Entregue';
							break;
					}
				?></td>
				<td style='text-align:center'><a href='{{ URL::to("expedicao/info-remessa/$entrega->id") }}' class='wm-btn wm-btn-blue'><i class='glyphicon glyphicon-plus'></i> Informações</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div data-section='footer'>
		{{ $entregas->links('elements.paginate') }}
	</div><!-- section="footer" -->
</div><!-- .jtable -->
@else
<div class='j-alert-error'>Nenhum dado foi encontrado.</div>
@endif

@stop

@include('elements.common-alert')

@section('scripts')
{{ HTML::script('js/wm-modal.js') }}
{{ HTML::script('js/expedicao/index.js') }}
@append

@section('styles')
{{ HTML::style('css/wm-modal.css') }}
{{ HTML::style('css/jtable.css') }}
@append