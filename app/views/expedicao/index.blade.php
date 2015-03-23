@extends('layouts.default') 

@section('topbar') 
	<h4><i class="halflings halflings-arrow-up"></i> Expedição</h4>
@endsection

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
				<th>Mais informações</th>
				<th>Liberação</th>
			</tr>
		</thead>
		<tbody>
			@foreach($entregas as $entrega)
			<tr>
				<td>{{ zero_fill($entrega->id, 4) }}</td>
				<td>{{ $entrega->solicitacoes->count() }}</td>
				<td>{{ $entrega->nome }}</td>
				<td>{{ (new Datetime($entrega->data_criacao))->format('d/m/Y') }}</td>
				<td style='text-align: center'><a
					href='{{ URL::to("expedicao/info-remessa/$entrega->id/") }}'
					class='wm-btn wm-btn-blue'><i class='glyphicon glyphicon-plus'></i>
						Informações</a></td>
				<td style='text-align: center'><button
						data-remessa='{{ $entrega->id }}'
						class='wm-btn wm-btn-green btn-liberar-remessa'>
						<i class='glyphicon glyphicon-share-alt'></i> Sair para entrega
					</button></td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div data-section='footer'>
		{{ $entregas->links('elements.paginate') }}
	</div><!-- section="footer" -->
</div><!-- .jtable -->
@else
    <div class='alert warning'>Nenhuma remessa foi encontrada.</div>
@endif
<!-- .jtable -->

@include('elements.common-alert') 

@stop


@section('scripts') 
{{ 
    HTML::script('js/wm-modal.js'),
    HTML::script('js/expedicao/index.js')
}} 
@append


@section('styles')
{{ 
    HTML::style('css/wm-modal.css'),
    HTML::style('css/jtable.css') 
}}
@append
