@extends('layouts.default')

@section('title') Histórico de remessas liberadas @stop

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
				<th>Mais informações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($remessas as $remessa)
			<tr>
				<td>{{ zero_fill($remessa->id, 4) }}</td>
				<td>{{ $remessa->solicitacoes->count() }}</td>
				<td>{{{ $remessa->usuario->nome }}}</td>
				<td>{{ $remessa->created_at->format('d/m/Y') }}</td>
				<td style='text-align: center'>
                    <a href='{{ URL::to("financeiro/info-remessa/$remessa->id") }}' class='wm-btn wm-btn-blue'>
                        <i class='glyphicon glyphicon-plus'></i>
                        Informações
                    </a>
                </td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div data-section='footer'>
		{{ $remessas->links('elements.paginate') }}
	</div><!-- section="footer" -->
</div><!-- .jtable -->
@else
    <div class='j-alert-error'>Nenhuma remessa foi liberada.</div>
@endif 

@include('elements/common-alert') 

@stop



@section('styles')

{{ HTML::style('css/jtable.css') }}

@append

@section('scripts') 

{{ HTML::script('js/financeiro/historico.js') }} 

@append
