@extends('layouts.default')

@section('title') <i class="glyphicon glyphicon-search"></i> Pesquisar remessas @stop

@section('content')

<form method="POST" style="margin:0 0 20px 0">
	<select class="wm-input" name="txt-type-search" id="txt-type-search">
		<option value="1">Pesquisar por remessa única</option>
		<option value="2">Pesquisar por intervalo de remessa</option>
	</select>
	<input type="text" class="wm-input" placeholder="Número da remessa" id="txt-search" required name="txt-search" />
	<input type="text" style="display:none" class="wm-input" placeholder="Até a remessa" name="txt-search1" id="txt-search1" />
	<button type="submit" class="wm-btn wm-btn-blue">Pesquisar <i class="glyphicon glyphicon-search"></i></button>
</form>

@if(count($remessas))
<div class='jtable'>
	<table>
		<thead>
			<tr>
				<th>Remessa</th>
				<th>Criado Por</th>
				<th>Nº Solicitações</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($remessas as $remessa)
			<tr>
				<td>{{ zero_fill($remessa->id, 4) }}</td>
				<td>{{ $remessa->usuario->nome }}</td>
				<td>{{ $remessa->solicitacoes->count() }}</td>
				<td class="text-center">
					<a target="_blank" href="{{ URL::to('producao/pdf-relatorio-remessa/' . $remessa->id) }}" class="wm-btn wm-btn-pdf" style="font-size:16px"></a>
					<a target="_blank" href="{{ URL::to('producao/imprimir-protocolo-remessa/' . $remessa->id) }}" class="wm-btn" style="font-size:16px"><i class="glyphicon glyphicon-print" style="font-size:14px"></i></a>
					<a target="_blank" href="{{ URL::to('producao/download-fotos-remessa/' . $remessa->id) }}" class="wm-btn" style="font-size:16px"><i class="glyphicon glyphicon-picture" style="font-size:14px"></i></a>
					<a target="_blank" href="{{ URL::to('producao/download-excel-remessa/' . $remessa->id) }}" class="wm-btn" style="font-size:16px"><i class="glyphicon glyphicon-download-alt" style="font-size:14px"></i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div data-section="footer">
		{{ $remessas->links('elements.paginate') }}
	</div>
</div><!-- .jtable -->
@else
<div class='j-alert-error'>Nenhuma remessa foi encontrada.</div>
@endif

@stop

@section('styles')
{{ HTML::style('css/jtable.css') }}
@stop

@section('scripts')
<script type="text/javascript">
$(function(){
	var $txtTypeSearch = $('#txt-type-search');
	var $txtSearch = $('#txt-search');
	var $txtSearch1 = $('#txt-search1');

	$txtTypeSearch.on('change', function(){
		if ($(this).val() == 1) {
			$txtSearch.attr('placeholder', 'Número da remessa');
			$txtSearch.focus();
			$txtSearch1.hide();
			$txtSearch1.removeAttr('required');
		} else {
			$txtSearch.attr('placeholder', 'Da remessa');
			$txtSearch.focus();
			$txtSearch1.show();
			$txtSearch1.attr('required', 'required');
		}
	});
});
</script>
@stop