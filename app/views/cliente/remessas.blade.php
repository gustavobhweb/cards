@extends('layouts.default')


@section('title') Remessas - Carga das Imagens @stop


@section('content')

@if($remessas->count())
	<section class="jtable">
		<table>
			<thead>
				<tr>
					<th>Remessa</th>
					<th>Quantidade</th>
					<th>Fotos enviadas</th>
					<th>Informação</th>
					<th>Fotos da remessa</th>
				</tr>
			</thead>
			<tbody>
				@foreach($remessas as $remessa)
					<tr class="text-center">
						<td>{{ zero_fill($remessa->id, 4) }}</td>
						<td class="count-total">{{ $remessa->solicitacoes->count() }}</td>
						<td class="count-incompletes">
						<?php
							$sem_foto = $remessa->solicitacoes
											->filter(function($s){ 
												return $s->temp_foto == 0; 
											})
											->count();

							$total = $remessa->solicitacoes->count();
						?>
						<progress 
							value="{{ $sem_foto }}" 
							max="{{ $total }}"
							class="progress-bar" 
							data-id="{{ $remessa->id }}"></progress>
						<p data-id="{{ $remessa->id }}" class="progress-desc">
							{{ $sem_foto . '/' . $total }}</p>
						</td>
						<td>
							<button type="button" class='btn-info wm-btn wm-btn-blue' value="{{{ $remessa->id }}}">
								<span class='glyphicon glyphicon-plus'></span>
							</button>
						</td>
						<td class="container-input-file" data-id="{{{ $remessa->id }}}">
							
							@if($remessa->status_atual_id == 1 && $sem_foto)

							{{
								Form::button(
									'<i class="glyphicon glyphicon-picture"></i> Selecionar arquivo ...',
									['class' => 'wm-btn fake-file-zip', 'style' => 'width:200px']
								)
							}}

							@elseif($remessa->status_atual_id == 1 && !$sem_foto)

							{{
								Form::button(
									'Solicitar impressão do lote <i class="glyphicon glyphicon-arrow-right"></i>',
									['class' => 'wm-btn wm-btn-green send-print']
								)
							}}

							@else

							<a 
								href="{{ URL::to('cliente/linha-tempo-remessa', [$remessa->id]) }}" 
								class="wm-btn wm-btn-blue more-info">

								<i class="glyphicon glyphicon-plus"></i> Mais informações
							</a>

							@endif

							{{ 
								Form::file(
									'zip',
									[
										'style' => 'display:none',
										'class' => 'file-zip-upload'
									]
								)
							 }}

						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div data-section="footer">
			{{ $remessas->links('elements.paginate') }}
		</div><!-- data-section="footer" -->
	</section>

@else
	<div class="j-alert-error">
		Não há remessas para o envio de fotos
	</div>
@endif

@include('elements.common-alert')

@stop


@section('styles')

{{ HTML::style('css/jtable.css') }}

@append

@section('scripts')

{{ 
	HTML::script('js/cliente/remessas.js'),
	HTML::script('js/jquery-ui.js'),
	HTML::script('js/underscore-min.js')
}}

<script type="text/template" id="tpl-msg">
<li>Foram enviados <%= data.included_files.length %> arquivos</li>
<li>Foram atualizados <%= data.row_count %> registros</li>
</script>

<script type="text/template" id="tpl-more-info">
<section class='jtable'>
<div data-section="header">Solicitações pendentes</div>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Foto</th>
		</tr>
	</thead>
	<% _.each(solicitacoes, function(solicitacao) {%>
		<tr>
			<td><%= solicitacao.id %></td>
			<td><%= solicitacao.foto %></td>
		</tr>
	<% }) %>
</table>
</section>
</script>
@append