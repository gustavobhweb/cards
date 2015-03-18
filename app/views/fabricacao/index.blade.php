@extends('layouts.default') 

@section('title') Remessas para conferir @stop

@section('content') 
@if(count($remessas))
<div class='jtable'>
	<table>
		<thead>
			<tr>
				<th>Nº da remessa</th>
				<th>Qtd. de cartões</th>
				<th>Responsável</th>
				<th>Data da remessa</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($remessas as $remessa)
			<tr>
				<td>{{ zero_fill($remessa->id, 4) }}</td>
				<td>{{ $remessa->solicitacoes->count() }}</td>
				<td>{{ $remessa->nome }}</td>
				<td>{{ (new Datetime($remessa->data_criacao))->format('d/m/Y') }}</td>
				<td style='text-align: center'><button
						data-remessa='{{ $remessa->id }}'
						class='wm-btn wm-btn-green btn-liberar-remessa'>
						<i class='glyphicon glyphicon-ok'></i> Controle de qualidade
					</button></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div data-section='footer'>{{ $remessas->links('elements.paginate') }}
	</div>
	<!-- section="footer" -->
</div>
<!-- .jtable -->
@else
<div class='error'>Nenhuma remessa foi encontrada.</div>
@endif

@include('elements/common-alert') 

@endsection 

@section('styles')
	{{ HTML::style('css/jtable.css') }} 
	{{ HTML::style('css/wm-modal.css') }} 
@stop
@section('scripts') 
	{{ HTML::script('js/wm-modal.js') }}
	{{ HTML::script('js/financeiro/index.js') }} 
@stop
