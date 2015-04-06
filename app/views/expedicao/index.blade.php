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
				<th>Data da remessa</th>
				<th>Mais informações</th>
				<th>Liberação</th>
			</tr>
		</thead>
		<tbody>
			@foreach($entregas as $entrega)
			<tr>
				<td class='center'>{{ zero_fill($entrega->id, 4) }}</td>
				<td class='center'>
				@if(!$entrega->fichaTecnica->tem_dados)
				{{ $entrega->qtd }}
				@else
				{{ $entrega->solicitacoes->count() }}
				@endif
				</td>
				<td class='center' class='center'>{{ (new Datetime($entrega->data_criacao))->format('d/m/Y') }}</td>
				<td class='center'>
					@if(!$entrega->fichaTecnica->tem_dados)
					Não possui dados
					@else
					<a href='{{ URL::to("expedicao/info-remessa/$entrega->id/") }}'
					class='btn blue'><i class='glyphicon glyphicon-plus'></i>
						Informações</a>
					@endif
				</td>
				<td class='center'>
					<button data-remessa='{{ $entrega->id }}'
						class='btn green btn-liberar-remessa'>
						<i class='halflings halflings-share-alt'></i> Sair para entrega
					</button>
				</td>
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
