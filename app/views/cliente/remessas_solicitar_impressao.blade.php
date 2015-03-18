@extends('layouts.default')

@section('topbar')
	<h4><i class="halflings halflings-print"></i> Solicitar impressão</h4>
@stop

@section('content')

@include('elements.cliente.submenu-remessas')

<div class="content-remessas">
@if(count($remessas))
<div class="jtable">
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nº de Solicitações</th>
				<th>Informações</th>
				<th>Enviar fotos</th>
			</tr>
		</thead>
		<tbody>
			@foreach($remessas as $remessa)
			<tr class="text-center">
				<td class="center">{{ $remessa->id }}</td>
				<td class="count-total center">{{ $remessa->solicitacoes->count() }}</td>
				<td class="center">
					
					{{
						HTML::link(
							URL::to('cliente/linha-tempo-remessa', [$remessa->id]),
							'Mais Informações',
							['class' => 'btn medium blue']
						)

					}}
				</td>
				<td class="center container-input-file" data-id="{{ $remessa->id }}">
					{{
						Form::button(
							'Solicitar impressão do lote <i class="glyphicon glyphicon-arrow-right"></i>',
							['class' => 'btn medium green send-print']
						)
					}}
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
		Não há remessas para solicitar impressão
	</div>
@endif
</div><!-- .content-remessas -->

@include('elements.common-alert')

@stop

@section('styles')
{{ 
	HTML::style('css/jtable.css'),
	HTML::style('css/cliente/remessas.css')
}}
@append

@section('scripts')
{{ 
	HTML::script('js/cliente/remessas.js'),
	HTML::script('js/jquery-ui.js'),
	HTML::script('js/underscore-min.js')
}}
@append