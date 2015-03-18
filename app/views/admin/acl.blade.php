@extends('layouts.default')

@section('title') ACL @stop

@section('topbar')
<h4><i class="halflings halflings-glyph-lock"></i> Access Control List</h4>
<div class="list-menu right small">
	<button class="btn medium orange"><i class="halflings halflings-cog"></i> Gerenciar <span class="caret"></span></button>
	<div class="box">
		<ul>
			<li>
				<a href="{{ URL::to('admin/cadastrar-permissoes') }}">
					<i class="halflings halflings-plus"></i>
					Nova permissão
				</a>
			</li>
		</ul>
	</div><!-- .box -->
</div>
@stop

@section('content')

	@if(isset($message))
		<div class="j-alert-error">
			{{ $message }}
		</div>
	@endif
	
	<form method="post" style="margin:20px 0 0 0">
		<label>O nível</label>
		<select class="medium" required name="nivel_id">
			<option value="">-</option>
			@foreach($niveis as $nivel)
			<option value="{{ $nivel->id }}">{{ $nivel->titulo }}</option>
			@endforeach
		</select>
		<label>deverá acessar</label>
		<select class="medium" required name="permissao_id">
			<option value="">-</option>
			@foreach($permissoes as $permissao)
			<option value="{{ $permissao->id }}">{{ "{$permissao->name} ({$permissao->type})" }}</option>
			@endforeach
		</select>
		<button type="submit" class="btn medium blue">Salvar</button>
	</form>

	<div class="jtable" style="margin:20px 0 0 0">
		<table>
			<thead>
				<tr>
					<th>Nível</th>
					<th>Qtd. permissões</th>
					<th>Qtd. de usuários</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				@foreach($niveis as $nivel)
				<tr>
					<td>{{ $nivel->titulo }}</td>
					<td style="text-align:center">{{ $nivel->permissoes->count() }}</td>
					<td style="text-align:center">{{ Usuario::whereNivelId($nivel->id)->count() }}</td>
					<td style="text-align:center">
						<a 
							href="{{ URL::to('admin/permissoes/' . $nivel->id) }}" 
							class="btn blue">
							<i class="halflings halflings-edit"></i> Permissões
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- .jtable -->

@stop

@section('styles')
{{ HTML::style('css/jtable.css') }}
@stop