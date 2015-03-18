@extends('layouts.default')

@section('title') Pesquisar solicitações @stop

@section('content')

<div class="gerenciamento-table">
		<table border="0">
			<thead>
				<tr>
					<th>Modelo</th>
					<th>Imagem</th>
					<th>Solicitações</th>
					<th>Selecionar</th>
				</tr>
			</thead>
			<tbody>
				@foreach($fichas_tecnicas as $ficha_tecnica)
				<tr data-solicitacoes="{{ $ficha_tecnica->solicitacoes->count() }}" 
					class="{{ (!$ficha_tecnica->aprovado) ? 'red' : '' }} clickable">
					<td>{{ $ficha_tecnica->nome }}</td>
					<td class="fotos-modelos">
						<img src="{{ URL::to($ficha_tecnica->foto_frente_link) }}" />
						<img src="{{ URL::to($ficha_tecnica->foto_verso_link) }}" />
					</td>
					<td>{{ $ficha_tecnica->solicitacoes->count() }}</td>
					<td>
						<a href="{{ URL::to('cliente/pesquisar-solicitacoes-modelo/' . $ficha_tecnica->id) }}" class="btn-style arrow-right continuar">CONTINUAR</a>
					</td>
				</tr>
				<tr class="normalize">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- .gerenciamento-table -->

@stop

@section('styles')
{{ 
	HTML::style('css/jtable.css'),
	HTML::style('css/cliente/pesquisar-solicitacoes.css')
}}
@append

@section('scripts')
{{
	HTML::script('js/cliente/pesquisar-solicitacoes.js')
}}
@append