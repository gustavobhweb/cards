<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		*{
			margin:0;
			padding:0;
			box-sizing: border-box;
		}
		@page{
			border:1px solid #333;
			margin:0;
			size:a4 portrait;
			/*size:a4 landscape;*/
		}
		.page{
			page-break-after: always;
		}
		.page:last-of-type{
			page-break-after: auto;	
		}
	</style>
	{{ HTML::style('css/jtable.css'); }}
</head>
<body>
	<div class="page">
		<div class="jtable">
			<table>
				<thead>
					<tr>
						<th>{{ $remessa->fichaTecnica->campo_chave}}</th>
						@foreach($remessa->fichaTecnica->camposVariaveis as $cabecalho)
							<th>{{ humanize($cabecalho->nome) }}</th>
						@endforeach
						<th>Via</th>
					</tr>
				</thead>
				<tbody>
					@foreach($solicitacoes as $solicitacao)
					<tr>
						<td>{{ $solicitacao->codigo }}</td>
						@foreach($solicitacao->camposVariaveis as $campo)
							<td>{{ $campo->pivot->valor }}</td>
						@endforeach
						<td>{{ $solicitacao->via }}ª</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div><!-- .jtable -->
	</div><!-- .page -->
</body>
</html>