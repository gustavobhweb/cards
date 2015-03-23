@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-user"></i> Gerenciar Clientes ({{ $clientes->count() }})</h4>
<div class="list-menu right small">
    <button class="btn medium orange"><i class="halflings halflings-cog"></i> Gerenciar <span class="caret"></span></button>
    <div class="box">
        <ul>
            <li>
                <a href="{{ URL::to('admin/clientes-operacao') }}">
                    <i class="halflings halflings-plus"></i>
                    Novo cliente
                </a>
            </li>
        </ul>
    </div><!-- .box -->
</div>
@stop

@section('content')

{{ Form::open(['method' => 'get']) }}

	{{ Form::text('search', Input::old('search'), [
		'class' => 'medium',
		'style' => 'width:300px',
		'placeholder' => 'Pesquise pelo nome da empresa'
	]) }}

	@if(Input::has('search'))
	<a href="{{ URL::to('admin/gerenciar-clientes') }}" class="btn medium">{{{ Input::get('search') }}} <i class="halflings halflings-remove"></i></a>
	@endif

	{{ Form::submit('Enviar', [
		'class' => 'btn medium blue'
	]) }}
	
{{ Form::close() }}

@if($clientes->count())
<div class="jtable" style="margin: 10px 0 0 0">
	<table>
		<thead>
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Telefone</th>
				<th>Cadastrado em</th>
				<th colspan="2">Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($clientes as $cliente)
			<tr>
				<td class="nome-cliente">{{{ $cliente->nome }}}</td>
				<td class="center">{{{ $cliente->email }}}</td>
				<td class="center">{{{ $cliente->telefone }}}</td>
				<td class="center">{{{ $cliente->created_at->format('d/m/Y \à\s H:i:s') }}}</td>
				<td class="center">
					<button class="btn medium blue">
						<i class="halflings halflings-edit"></i>
					</button>
				</td>
				<td class="center">
					@if($cliente->usuarios->count())
					<button class="btn medium blue btn-usuarios" data-id="{{ $cliente->id }}">
						<i class="halflings halflings-user"></i> {{ $cliente->usuarios->count() }}
					</button>
					@else
					<button class="btn medium red btn-usuarios" data-id="{{ $cliente->id }}">
						<i class="halflings halflings-user"></i> Cadastrar
					</button>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div data-section="footer">
		{{ $clientes->links() }}
	</div>
</div><!-- .jtable -->
@else
	<div class="alert warning">
		Nenhum cliente foi encontrado. 
		<a class="btn" href="{{ URL::to('admin/clientes-operacao') }}">
			<i class="halflings halflings-plus"></i>
			Cadastrar cliente
		</a>
	</div>
@endif
@stop

@section('styles')
{{ HTML::style('css/admin/gerenciar-clientes.css') }}
@append

@section('scripts')
<script type="text/javascript">
$(function()
{
	@if(Input::has('search'))
	var search = "{{{ Input::get('search') }}}".toLowerCase();
	
	$('.nome-cliente').each(function()
	{
		var nome = $(this).html().toLowerCase();
		nome = nome.replace(search, search.bold());
		$(this).html(nome.toUpperCase());
	});
	@endif

	$('.btn-usuarios').showModal({
		title: 'Gerenciar usuários do cliente',
		template: '#cadastrar-usuarios'
	});
});
</script>

<script type="text/template" id="cadastrar-usuarios">
	<form method="post" style="width:50%;margin: 0 auto">
		<input type="hidden" name="cliente_id" value="<%= id %>" />

		<div class="fc-section">
			<div class="title">
				<span>1</span>
				<h4>Usuário:</h4>
			</div>
			<div class="content-section" style="margin:10px 0 0 0">
				<input required type="text" id="usuario" name="username" class="medium total" autofocus />
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>2</span>
				<h4>Senha:</h4>
			</div>
			<div class="content-section" style="margin:10px 0 0 0">
				<input required type="password" id="senha" name="password" class="medium total" />
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>3</span>
				<h4>Confirmar Senha:</h4>
			</div>
			<div class="content-section" style="margin:10px 0 0 0">
				<input required type="password" id="conf-senha" name="conf-senha" class="medium total" />
			</div>
		</div>

		<div class="fc-section">
			<div class="title">
				<span>4</span>
				<h4>Nome:</h4>
			</div>
			<div class="content-section" style="margin:10px 0 0 0">
				<input required type="text" id="nome" name="nome" class="medium total" />
			</div>
		</div>

		<button type="submit" class="btn medium green right" style="margin: 10px 0 0 5px">
			<i class="halflings halflings-ok"></i> Salvar
		</button>

		<button type="button" class="btn medium right close" style="margin: 10px 0 0 0">
			<i class="halflings halflings-remove"></i> Cancelar
		</button>
	</form>
</script>

@append