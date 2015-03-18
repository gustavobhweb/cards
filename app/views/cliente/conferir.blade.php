@extends('layouts.default')

@section('title') Conferir remessa {{{ $remessa }}} @stop

@section('content')
<div class='jtable'>
	<div data-section='header'>
		<a href='{{ URL::to("cliente/entregas?page=" . $pageBack) }}' class='wm-btn'>Voltar</a>
		<input type="text" class='wm-input pull-right input-conferir' placeholder='Digite a matrícula' autofocus />
	</div><!-- section="header" -->

	<table>
		<thead>
			<tr>
				<th colspan="2">Aluno</th>
				<th>Matrícula</th>
				<th>Curso</th>
				<th>Solicitado em</th>
				<th>Conferência</th>
			</tr>
		</thead>
		<tbody>
			@foreach($solicitacoes as $solicitacao)
			<tr data-matricula='{{ $solicitacao->matricula }}' {{ ($solicitacao->status_atual == 6) ? 'style="background:rgb(205, 230, 155)"' : '' }} >
				<td style="width:45px"><img src='{{ URL::to("imagens/" . $solicitacao->matricula . "/" . $solicitacao->foto) }}' width='48' height='70'></td>
				<td>{{ $solicitacao->nome }}</td>
				<td style="text-align:center">{{ $solicitacao->matricula }}</td>
				<td style="text-align:center">{{ $solicitacao->curso }}</td>
				<td style="text-align:center">{{ (new Datetime($solicitacao->created_at))->format('d/m/Y à\s H:i:s') }}</td>
				<td data-matricula='{{ $solicitacao->matricula }}' style="text-align:center">
					@if($solicitacao->status_atual == 5)
						<i class='glyphicon glyphicon-minus'></i>
					@elseif($solicitacao->status_atual == 6)
						<i class='glyphicon glyphicon-ok' style='color:rgb(111, 147, 36)'></i>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div data-section='footer'>
		
	</div><!-- section="footer" -->
</div><!-- .jtable -->
@stop

@include('elements.common-alert')

@section('scripts')
	{{ 
		HTML::script('js/jquery-ui.js'),
		HTML::script('js/wm-modal.js'),
		HTML::script('js/cliente/conferir.js') 
	}}
@stop

@section('styles')
	{{ HTML::style('css/jtable.css') }}
	{{ HTML::style('css/wm-modal.css') }}
@stop