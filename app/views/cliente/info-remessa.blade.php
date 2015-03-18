@extends('layouts.default')


@section('title') 
	Remessa {{ zero_fill($remessa->id, 4) }} 
@stop


@section('content')

<div class='jtable'>
	<div data-section='header'>
		<a href='{{ URL::previous() }}'
			class='wm-btn'>Voltar</a>
	</div>
	<!-- section="header" -->

	<table>
		<thead>
			<!-- <tr>
				<th colspan="2">Aluno</th>
				<th>Matrícula</th>
				<th>CPF</th>
				<th>Solicitado em</th>
			</tr> -->
		</thead>
		<tbody>
			@foreach($solicitacoes as $solicitacao)
			<tr>
				@foreach($solicitacao->camposVariaveis as $campo)
					<td>{{ $campo->pivot->valor }}</td>
				@endforeach()
			</tr>
			@endforeach
		</tbody>
	</table>

	<div data-section='footer'>{{ $solicitacoes->links('elements.paginate')
		}}</div>
	<!-- section="footer" -->
</div>
<!-- .jtable -->

@stop 

@section('styles')
    {{ HTML::style('css/jtable.css') }}
@append

@section('script')
{{ HTML::script('js/') }}
@append
