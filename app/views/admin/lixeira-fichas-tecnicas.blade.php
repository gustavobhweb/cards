@extends('layouts.default')

@section('title') Lixeira de fichas técnicas @stop

@section('topbar')
<h4>
	<i class="halflings halflings-trash"></i> 
	Lixeira de fichas técnicas ({{ $fichas_tecnicas->count() }})
</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')
	
	@if($fichas_tecnicas->count())
	<div class="jtable">
		<table>
			<thead>
				<tr>
					<th>Ficha técnica</th>
					<th>Número de campos</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($fichas_tecnicas as $ficha_tecnica)
				<tr>
					<td class="center">{{ $ficha_tecnica->nome }}</td>
					<td class="center">{{ $ficha_tecnica->camposVariaveis->count() }}</td>
					<td class="center">
						<button type="button" class="btn medium blue btn-restaurar" data-id="{{ $ficha_tecnica->id }}">
							<i class="halflings halflings-hand-left"></i> Restaurar
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- .jtable -->
	 @else
    <div class="alert warning">A lixeira de fichas técnicas está vazia</div>
    @endif

@include('elements.common-alert')


<script type="text/template" id="tpl-info">
<section class="jtable">
	<table>
		<thead>
			<tr>
				<th>ID Campo</th>
				<th>Nome</th>
			</tr>
		</thead>
		<tbody>
			<% _.each(ficha.campos_variaveis, function(campo) { %>
			<tr>
				<td><%= campo.id %></td>
				
				<td><%= campo.nome %></td>
			</tr>
			<% }); %>
		</tbody>
	</table>
</section>
</script>

@stop

@section('styles')
{{
	HTML::style('css/jtable.css')
}}
@append

@section('scripts')
{{ 
	HTML::script('js/underscore-min.js'),
	HTML::script('js/admin/lixeira-fichas-tecnicas.js'),
	HTML::script('js/jquery-ui.js')

}}
@append