@extends('layouts.default')

@section('title') {{{ $title }}} @endsection

@section('content')

	<div class='jtable'>
		<div data-section='header'>
			<a href='{{ URL::to("cliente/inicial") }}' class='wm-btn'>Voltar</a>
		</div><!-- section="header" -->

		<table>
			<thead>
				<tr>
					<th colspan="2">Aluno</th>
					<th>Matrícula</th>
					<th>Curso</th>
					<th>Solicitado em</th>
				</tr>
			</thead>
			<tbody>
				@foreach($solicitacoes as $solicitacao)
				<tr>
					<td style="width:45px"><img src='{{ URL::to("imagens/" . $solicitacao->usuario->matricula . "/" . $solicitacao->foto) }}' title='a' class='mini-image' width='48' height='70'></td>
					<td>{{ $solicitacao->usuario->nome }}</td>
					<td style="text-align:center">{{ $solicitacao->usuario->matricula }}</td>
					<td style="text-align:center">{{ $solicitacao->usuario->curso }}</td>
					<td style="text-align:center">{{ (new Datetime($solicitacao->created_at))->format('d/m/Y à\s H:i:s') }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<div data-section='footer'>
			{{ $solicitacoes->links('elements.paginate') }}
		</div><!-- section="footer" -->
	</div><!-- .jtable -->

@endsection

@section('scripts')
	{{ HTML::script('js/jquery-ui.js'),
	   HTML::script('js/cliente/relatorio.js') }}
@endsection

@section('styles')
	{{ HTML::style('css/jtable.css'),
	   HTML::style('css/jquery-ui.css') }}
@endsection