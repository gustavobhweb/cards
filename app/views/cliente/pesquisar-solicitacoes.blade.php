@extends('layouts.default')

@section('topbar')
	<h4><i class="halflings halflings-search"></i> Pesquisar solicitações</h4>
@stop

@section('content')

@if($fichas_tecnicas->count())
<div class="jtable">
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
					<td class="center">{{ $ficha_tecnica->nome }}</td>
					<td class="fotos-modelos center">
						<img src="{{ URL::to($ficha_tecnica->foto_frente_link) }}" />
						<img src="{{ URL::to($ficha_tecnica->foto_verso_link) }}" />
					</td>
					<td class="center">{{ $ficha_tecnica->solicitacoes->count() }}</td>
					<td class="center">
						<a href="{{ URL::to('cliente/pesquisar-solicitacoes-modelo/' . $ficha_tecnica->id) }}" class="btn medium blue continuar">CONTINUAR</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- .jtable -->
	@else
    <div class="alert warning">Ainda não existem fichas técnicas cadastradas. Entre em contato conosco e solicite uma proposta.</div>
    @endif

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