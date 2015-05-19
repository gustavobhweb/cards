@extends('layouts.default')

@section('content')

@if(!isset($_GET['id']))
<div class="jtable" style="width:400px">
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($niveis as $nivel)
			<tr>
				<td>{{ $nivel->id }}</td>
				<td>{{ $nivel->titulo }}</td>
				<td><a href="{{ URL::to('admin/niveis?id=' . $nivel->id) }}" class="btn medium blue"><i class="halflings halflings-ok"></i> Abrir</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@else
<h1>Nivel {{ $niveis->titulo }}</h1>
@endif

@stop

@section('styles')
{{ HTML::style('css/jtable.css') }}
@stop