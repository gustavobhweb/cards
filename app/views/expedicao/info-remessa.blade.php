@extends('layouts.default') @section('title') Remessa {{ $remessa_id }}
@endsection @section('content')

<div class='jtable'>
	<div data-section='header'>
		<a href='{{ URL::previous() }}' class='wm-btn'>Voltar</a>
	</div>
	<!-- section="header" -->

	<table>
		<thead>
			<tr>
				@foreach($remessa->fichaTecnica->camposVariaveis as $cabecalho)
					<th>{{ humanize($cabecalho->nome) }}</th>
				@endforeach
			</tr>
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

@endsection @section('styles') {{ HTML::style('css/jtable.css') }}
@endsection
