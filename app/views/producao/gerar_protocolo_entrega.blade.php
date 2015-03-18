@extends('layouts.default') 

@section('title') Gerar Protocolo de Entrega @stop 


@section('content')

<section class='print-container'>
	{{ Form::open(['id' => 'form-buscar', 'method' => 'get']) }} 

	{{
		Form::text(
			'remessa_id',
			Input::get('remessa_id'), 
			[
				'class' => 'wm-input input-large',
				'placeholder' => 'Entre com uma palavra-chave',	
				'id' => 'search-input'
			]
		) 
	}}

	{{ 
		Form::button(
			'Pesquisar',
			[
				'class' => 'wm-btn wm-btn-blue', 'type' => 'submit'
			]
		) 
	}} 

	{{ Form::close() }}

	{{
		$errors->first('message', '<div class="j-alert-error">:message</div>')
	}}

	@if(!empty($remessa)) 

	{{ Form::open(['url' => URL::full(), 'id' => 'form-protocolo' ]) }}

	<div id="box-to" class="gray-box">
		<h3>Destinatário</h3>
		<table>
			<tr>
				<td>Pessoa para contato (A/C):</td>
				<td>?</td>
			</tr>
			<tr>
				<td>OS:</td>
				<td>{{ zero_fill($remessa->id, 4) }}</td>
			</tr>
			<tr>
				<td>Endereço:</td>
				<td>Rua Newton Paiva, 777 - Bairro Centro</td>
			</tr>
		</table>

		@if(isset($barCodeImage))
		<div class="text-center" id="barcode-box">
			<img src="{{ URL::to($barCodeImage) }}" />
			<div>{{ $remessaCodigoBarra }}</div>
		</div>
		@endif
	</div>


	<div class="container-lists-table">
		<h1 class='on-print'>Protocolo para Entrega de Cartões</h1>
		<table class="lists-table">
			<thead>
				<tr>
					<th>Matricula</th>
					<th>Nome</th>
					<th style="width: 150px">Data</th>
					<th>Assinatura</th>
				</tr>
			</thead>
			<tbody>
                    @foreach($remessa->solicitacoes as $solicitacao)
                    <?php $usuario = $solicitacao->usuario?>
                    <tr>
					<td>{{{ $usuario->matricula }}}</td>
					<td>{{{ $usuario->nome }}}</td>
					<td class="text-center">____ /____ /____</td>
					<td>&times;</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>


	<div class='gray-box'>
		<strong>Newton Paiva</strong> declara ter recebido da empresa TMT
		Soluções em Tecnologia LTDA (CNPJ: 11.720.787/0001-82) .
	</div>


	<div class="container-lists-table">
		<table class="lists-table" id="">
			<thead>
				<tr>
					<th class="text-left" colspan='2'>
					Belo Horizonte, 
					{{ 
						strftime('%d de %B de %Y ') 
					}}
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td rowspan='4' class='text-center text-muted'>Carimbo da Empresa</td>
				</tr>
				<tr>

					<th class='text-center'><br />
						<div>_____________________________________________________________________</div>
						<div>Responsável pelo recebimento (Nome Completo)</div> <br /></th>
				</tr>
				<tr>
					<th><br />
						<div>_____________________________________________________________________</div>
						<div>Assinatura</div> <br />
						<div class="text-left">DATA: ____/____/______</div> <br /></th>
				</tr>
			</tbody>
		</table>

		<br />

		@unless($protocoloExiste)

		<table class="lists-table">
			<thead>
				<tr>
					<th colspan="2" class='text-left'>Retirado e conferido por:
						________________________________________________</th>
					<th class="text-left">Data: <span>___/___/_____</span>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="vertical-align: top; width: 30%">
					@foreach($tipoEntrega as $id => $tipo) 
						<label> 
							{{ Form::radio( 'tipo_entrega_id', $id, false, ['required' => 'required'] ) }} {{ $tipo }} 
						</label> 
						<br />
					@endforeach
					</td>
					<td style="vertical-align: top; width: 40%">

					@foreach($tiposCartao as $id => $tipo)
						<label> 
						{{ Form::checkbox('cartoes[][tipo_cartao_id]', $id ) }} {{ $tipo }} 
						</label> 
						<br />
						@endforeach
					</td>
					<td style="vertical-align: top; width: 30%">

						<div>
							<strong>Cartão com furação?</strong>
						</div> <label> 

						{{ Form::radio('tem_furacao', '1', false, ['required' => 'required']) }} 

						Sim </label> <br /> <label> {{
							Form::radio('tem_furacao', '0', false, ['required' =>
							'required']) }} Não </label>

						<div>
							<strong>Impressão térmica?</strong>
						</div> <label> {{ Form::radio('impressao_termica', '1', false,
							['required' => 'required']) }} Sim </label> <br /> <label> {{
							Form::radio('impressao_termica', '0', false,['required' =>
							'required']) }} Não </label>

						<div>
							<strong>Tem Cardvantagens?</strong>
						</div> <label> {{ Form::radio('tem_cardvantagens', '1', false,
							['required' => 'required']) }} Sim </label> <br /> <label> {{
							Form::radio('tem_cardvantagens', '0', false, ['required' =>
							'required']) }} Não </label>
					</td>
				</tr>

			</tbody>
		</table>
	</div>
	@else
	<div class='j-alert-error not-printable'>Esse protocolo já foicadastrado</div>
	<br /> 
	@endunless

	<div>
		<table class="lists-table">
			<tbody>
				<tr>
					<th>Impressor responsável</th>
					<td>{{ $user->nome }}</td>
					<td>Gerado em: {{ (new DateTime)->format('d/m/Y - H:i:s') }}</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="text-right" style="padding: 5px">

		{{ Form::hidden('remessa_id', $remessa->id) }}

		@unless($protocoloExiste)		
			{{  Form::submit('Imprimir', ['class' => 'wm-btn', 'id' => 'btn-submit']) }}
		@else 
			{{ Form::button('Imprimir', ['class' =>'wm-btn', 'id' => 'btn-only-print']) }}
		@endunless
	</div>

	{{ Form::close() }}


	<div id="container-error"></div>

	@endif
</section>



<script type="text/template" id="tpl-errors">
    <div class="j-alert-error"><%- error %></div>
</script>

@stop

@section('styles') 

{{
	HTML::style('css/jquery-ui.css'),
	HTML::style('css/print.css'),
	HTML::style('css/protocolo.css') 
}} 

@stop

@section('scripts')

{{
	HTML::script('js/jquery-ui.js'),
	HTML::script('js/underscore-min.js'),
	HTML::script('js/producao/gerar_protocolo_entrega.js') 
}} 

@stop


