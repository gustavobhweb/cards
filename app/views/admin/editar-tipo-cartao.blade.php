@extends('layouts.default')


@section('topbar')
	<h4>
	<i class="halflings halflings-credit-card"></i>
	@if(!$tipoCartao)
		Cadastrar Tipo de Cartão
	@else
		Editar Tipo de Cartão
	@endif
	</h4>
	<a href="{{ URL::previous() }}" class="btn medium right">
		<i class="halflings halflings-remove"></i> Cancelar
	</a>
@stop


@section('content')
<section class="wm-form clearfix">
{{ Form::model($tipoCartao, ['id' => 'form-tipo-cartao']) }}
		
		{{ $errors->first('nome',  '<div class="alert warning">:message</div>') }}

		{{ $message->first('message',  '<div class="alert warning">:message</div>') }}
	
		{{ 
			Form::text(
				'nome',
				Input::old('nome'),
				[
					'placeholder' => 'Nome do Tipo de Cartão',
					'class' => 'medium'
				]
			)
		}}

		<button type="submit" class="btn medium green">
			<i class="halflings halflings-ok"></i> Salvar
		</button> 
	</div>

{{ Form::close() }}
</section>
@stop


@section('styles')
{{ HTML::style('css/wm-grid.css') }}
@append


@section('scripts')
{{ HTML::script('js/admin/editar-tipo-cartao.js') }}
@append
