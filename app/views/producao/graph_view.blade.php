@extends('layouts.default')

@section('title') Página inicial @stop

@section('content')
<div class='jtable'>
	<table>
		<thead>
			<tr>
				<th colspan="2">Solicitacao</th>
				<th>Matrícula</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($solicitacoes as $solicitacao)
				<tr>
					<td style="width:75px"><img src="{{ URL::to('imagens/' . $solicitacao->usuario->matricula . '/' . $solicitacao->foto) }}" width="65" /></td>
					<td style='text-align:left'>{{{ $solicitacao->usuario->nome }}}</td>
					<td style='text-align:center'>{{{ $solicitacao->usuario->matricula }}}</td>
					<td style='text-align:center'><a href="{{{ URL::to('producao/graph-info/' . $solicitacao->id) }}}" class="wm-btn wm-btn-blue"><i class="glyphicon glyphicon-plus"></i> Informações</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div><!-- .jtable -->
@stop

@section('styles')
	{{ HTML::style('css/jtable.css') }}
@stop