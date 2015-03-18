@extends('layouts.default') 


@section('title') Gerenciar Fotos - Ficha Técnica @stop


@section('content')

<section class='jtable'>

	<table>
		<thead>
			<tr>
				<th width="30">Foto</th>
				<th>Nome</th>
				<th></th>
			</tr>
		</thead>
		@foreach($fichasTecnicas as $ficha)
		<tr class="text-center">
			<td>
				<img src="{{$ficha->foto_frente_link }}" height="50" width="70"  />
			</td>
			<td>{{ $ficha->nome }}</td>
			<td>
				<a href='{{ URL::to("producao/gerenciar-fotos/{$ficha->id}") }}' class="wm-btn wm-btn-blue" >
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</td>
		</tr>
		@endforeach
	</table>
</section>

@stop


@section('styles')
{{ HTML::style('css/jtable.css') }}
@append

