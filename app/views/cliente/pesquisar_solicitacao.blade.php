@extends('layouts.default')

@section('title') Histórico de solicitação @stop

@section('content')

{{ Form::open(['id' => 'buscar-aluno', 'autocomplete' => 'off', 'method' => 'GET']) }}

{{ 
	Form::text(
		'solicitacao_id',
		Input::get('solicitacao_id'),
		[
			'class'     => 'wm-input input-large',
			'autofocus' => 'autofocus'
		]
	)
}}

{{ Form::button('Buscar Solicitação', ['class' => 'wm-btn wm-btn-blue', 'type' => 'submit'])}}

{{ Form::close() }}

@if(isset($error))
	<div class='j-alert-error'>
		{{ $error }}
	</div>
@endif

@if(isset($solicitacoes))
	
	@foreach($solicitacoes as $solicitacao)
		<h2 class='historico-title'>
			Histórico de {{ $solicitacoes->count() > 1 ? 'solicitações' : 'solicitação' }}
		</h2>

		<div class='situacao-box'>
			
			@if($solicitacao->remessa->status_atual_id == 8)
			<div class='reprovada'>
				<h1>FOTO REPROVADA</h1>
			</div>
			@endif

			<h2 style="margin-bottom: 10px">Solicitação {{ zero_fill($solicitacao->id, 4) }}</h2>
			<h2 style="margin-bottom: 10px">Remessa {{ zero_fill($solicitacao->remessa_id, 4) }}</h2>

			<div class='left-infos'></div>
			<div class='infos'>
				<div style="float: left; width: 75%">
					<h3 class='via'>1ª VIA(S)</h3>
					<div class='modelos'>
						<div class='modelo frente'>
							<img width='71' height='95'
							src='{{ URL::to($solicitacao->foto_link) }}' />
						</div>
						<!-- .frente -->
						<div class='modelo verso'></div>
					</div>
					<!-- .modelos -->
					<div class='regua' data-status="{{ $solicitacao->remessa->status_atual_id }}">

						<div
							data-not-in="[8]" 
							data-greater-than="2"
							data-class="orange"
							class='passo'
							data-step='1'
						>
							<p>Análise da foto</p>
						</div>
						<div
							data-class="steelblue"
							data-greater-than="3"
							data-not-in="[8]"
							class='passo'
							data-step='2'>
							<p>Fabricação</p>
						</div>
						<div
							data-not-in="[8, 9]"
							data-greater-than="4"
							data-class="blue"
							data-step="3"
							class="passo"

						>
						<p>Conferência</p>
						</div>
						<div

							data-not-in="[8, 9, 10]"
							data-greater-than="6"
							data-class="steelgreen"
							data-step="4"
							class="passo"

							class='passo {{ ($solicitacao->status_atual >= 4 && $solicitacao->status_atual != 8 && $solicitacao->status_atual != 9) ? "blue" : "" }}'
						>
							
							
							<p>Disponível para entrega</p>
						</div>
						<div

							data-not-in="[8, 9, 10]"
							data-greater-than="7"
							data-class="green"
							data-step="5"
							class="passo"
						>
							<p>Entregue</p>
						</div>
					</div>
					<!-- .regua -->
				</div>
				<div class="status-list">
					<div class='title'></div>
					<div class='content'>

						<?php $letter = "A" ?>

						@foreach($solicitacao->remessa->status as $status)
						
						@if($status->id != 9)

						<div class='item'>
							<h3>{{ $letter }}</h3>
							<div class='right'>
								<h4>{{ $status->nome }}</h4>
								<p>{{ $status->created_at->format('d/m/Y H:i')  }}</p>
								<!-- 
								@if($solicitacao->remessa->status_atual_id > 2)
								<div class='add'>
									<h4>Aprovado</h4>
									<p>
									{{ 
										$solicitacao->remessa->status_atual->created_at->format('d/m/Y H:i') 
									}}
									</p>
								</div>
								
								@endif
								-->
							</div>
							<!-- .right -->
						</div>
						<!-- .item -->
						<?php $letter++ ?>

						@endif
						@endforeach
					</div>
					<!-- .content -->
				</div>
				<!-- .status-list -->
			</div>
			<!-- .infos -->
		</div><!-- .situacao-box -->


	@endforeach

@else
	<div class="j-alert-error">Nenhuma solicitação encontrada</div>
@endif

@include('elements.common-alert')

@stop

@section('styles')
	{{ HTML::style('css/cliente/pesquisar_solicitacao.css') }}

@append

@section('scripts')
{{ 
	HTML::script('js/jquery-ui.js'),
	HTML::script('js/cliente/pesquisar_solicitacao.js')
}}
@append