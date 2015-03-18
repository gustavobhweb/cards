@extends('layouts.default')

@section('title') Aviso @stop

@section('content')

<div class="assunto">
	<div class="header">
		<div class="left">
			<i class="glyphicon glyphicon-inbox" style="font-size:12px;margin-right:2px"></i> Assunto:
		</div><!-- .left -->
		<div class="right">
			{{{ $aviso->assunto }}}
		</div><!-- .right -->
		<div class="clearfix"></div>
	</div><!-- .header -->
	<div class="content">
		<a class="wm-btn pull-right btn-back" href="{{ URL::previous() }}"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
		<div class="remetente">
			<h5><i class="glyphicon glyphicon-user"></i> REMETENTE</h5>
			<p>{{{ $aviso->remetente }}}</p>
			<div class="clearfix"></div>
		</div><!-- .remetente -->
		<div class="mensagem">
			<h5><i class="glyphicon glyphicon-envelope"></i> MENSAGEM</h5>
			<p>{{{ $aviso->mensagem }}}</p>
		</div><!-- .mensagem -->
	</div><!-- .content -->
</div>
@stop

@section('styles')
	{{ HTML::style('css/aviso/ler.css') }}
@stop
