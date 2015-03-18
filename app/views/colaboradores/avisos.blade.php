@extends('layouts.default')

@section('content')

@section('title')
<div class='num' style="margin: 5px">{{ count($avisos) }}</div>
<h1>Avisos</h1>
@stop

<div class="clearfix">

	@if(!$avisos->count())
	<div class='j-alert-error'>Nenhum aviso foi encontrado.</div>
	@else
	<div style='margin: 10px 0 0 0'>
		<div class='head-item' style='width: 100px'>Status</div>
		<div class='head-item' style='width: 180px'>Assunto</div>
		<div class='head-item' style='width: 90px'>Remetente</div>
		<div class='head-item' style='width: 180px'>Mensagem</div>
		<div class='head-item' style='width: 150px'>Selecionar</div>
		<div class='clearG'></div>
	</div>
	<br /> @foreach($avisos as $aviso) <a
		href='{{ URL::to("aluno/ler-aviso/{$aviso->id}") }}'>
		<div class='item-aviso'>
			<div class='item-line-aviso' style='width: 100px'>
				@if($aviso->lido)
				<p class="read">Lido</p>
				@else
				<p class="unread">Não lido</p>
				@endif <img src='{{ URL::to("img/msg.png") }}' />
			</div>
			<div class='item-line-aviso' style='width: 180px'>
				<p>{{{ $aviso->assunto }}}</p>
			</div>
			<div class='item-line-aviso' style='width: 90px'>
				<p>{{{ $aviso->remetente }}}</p>
			</div>
			<div class='item-line-aviso' style='width: 180px'>
				<p>{{ Str::limit($aviso->mensagem, 30, '...') }}</p>
			</div>
			<div class='item-line-aviso' style='border: none; width: 150px'>
				<button style='margin: 24px 0 0 6px' class='btn-conf-iza'>CONTINUAR
					></button>
			</div>
			<div class='clearG'></div>
		</div>
	</a> @endforeach @endif

</div>

@endsection
