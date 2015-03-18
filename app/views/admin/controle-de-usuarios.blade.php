@extends('layouts.default')

@section('title') <i class="glyphicon glyphicon-user"></i> Controle de usuários @stop

@section('topbar')
<h4><i class="halflings halflings-user"></i> Controle de usuários</h4>
<div class="list-menu right small">
	<button class="btn medium orange"><i class="halflings halflings-cog"></i> Gerenciar <span class="caret"></span></button>
	<div class="box">
		<ul>
			<li>
				<a href="{{ URL::to('admin/cadastrar-usuarios') }}">
					<i class="halflings halflings-plus"></i>
					Novo usuário
				</a>
			</li>
			<li>
				<a href="{{ URL::to('admin/cadastrar-niveis') }}">
					<i class="halflings halflings-tower"></i>
					Novo nível
				</a>
			</li>
		</ul>
	</div><!-- .box -->
</div>
@stop

@section('content')

	@foreach($niveis as $nivel)
	<div class="section-nivel" data-id="{{ $nivel->id }}" style="margin: 20px 0 0 0">
		<div class="title">
			Nível {{ $nivel->titulo }} - {{ $nivel->usuarios->count() }} usuário(s)
		</div><!-- .title -->
		<div class="users">
		@if($nivel->usuarios->count())
			@foreach($nivel->usuarios as $usuario)
			<div class="user" data-id="{{ $usuario->id }}">
				<i class="glyphicon glyphicon-user"></i> {{{ $usuario->nome }}}
			</div><!-- .user -->
			@endforeach
		@else
			<!-- <button class="wm-btn wm-btn-red" style="margin:5px 0 0 0;width:100%"><i class="glyphicon glyphicon-trash"></i> Deletar nível</button> -->
		@endif
		</div><!-- .users -->
	</div><!-- .section-nivel -->
	@endforeach
@stop

@section('styles')
	{{ HTML::style('css/admin/controle-de-usuarios.css') }}
@stop

@section('scripts')
	{{ 
		HTML::script('js/jquery-ui.js'),
		HTML::script('js/admin/controle-de-usuarios.js')
	}}
@stop