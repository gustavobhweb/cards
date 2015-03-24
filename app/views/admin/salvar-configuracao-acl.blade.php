@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-cog"></i> Salvar configuração da ACL</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
	<i class="halflings halflings-remove"></i>
	Cancelar
</a>
@stop

@section('content')

{{ Form::open() }}
	
	<div class="fc-section">
		<div class="title">
			<h4>Quais configurações você deseja salvar?</h4>
		</div>
		<div class="content-section" style="margin: 10px 0 0 0">
			<input type="checkbox" name="niveis" id="niveis" />
			<label for="niveis">Níveis</label>

			<input type="checkbox" name="permissoes" id="permissoes" />
			<label for="permissoes">Permissões</label>

			<input type="checkbox" name="niveis_permissoes" id="niveis_permissoes" />
			<label for="niveis_permissoes">Níveis - Permissões</label>

			<input type="checkbox" name="usuarios" id="usuarios" />
			<label for="usuarios">Usuários</label>

			<button type="submit" class="btn medium right blue">
				<i class="halflings halflings-download-alt"></i> Salvar e baixar
			</button>
		</div>
	</div>

{{ Form::close() }}

@stop