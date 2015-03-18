@extends('layouts.default')


@section('title') Registrar retirada @stop @section('content')

<form id='buscar-aluno' autocomplete="off">
	<input type='text' id='matricula' placeholder='Digite o RA do aluno'
		class='wm-input input-large' />
	<button type='button' id='btn-buscar-aluno' class='wm-btn wm-btn-blue'>Buscar
		Aluno</button>
</form>


<div class='situacao-box'>
	<h2 id="-nome" style="margin-bottom: 10px">Nome do aluno</h2>
	<div class='left-infos'></div>
	<div class='infos'>
		<div style="float: left; width: 75%">
			<div class='modelos'>
				<div class='modelo frente'>
					<img id='-foto' width='71' height='95'
						src='{{ URL::to("img/user.png") }}' />
				</div>
				<!-- .frente -->
				<div class='modelo verso'></div>
			</div>
			<!-- .modelos -->
		</div>
		<div style="float: left; margin: 25px 0 0 0; width: 20%">
			<button id='btn-confirmar-retirada' class='wm-btn wm-btn-green'
				style="width: 100%">
				<i class='glyphicon glyphicon-ok'></i> Confirmar retirada
			</button>
			<button id='btn-cancelar' class='wm-btn'
				style='margin: 8px 0 0 0; width: 100%'>
				<i class='glyphicon glyphicon-remove'></i> Cancelar
			</button>
		</div>
		<!-- .buttons-free -->
	</div>
	<!-- .infos -->
</div>
<!-- .situacao-box -->

@endsection

@include('elements.common-alert')


@section('styles')

{{ HTML::style('css/cliente/retirada.css'), HTML::style('css/wm-modal.css') }}

@stop


@section('scripts') 

{{ 
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/wm-modal.js'), 
    HTML::script('js/cliente/retirada.js')

}} 

@stop
