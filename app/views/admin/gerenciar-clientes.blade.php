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
		'placeholder' => 'Cliente / CNPJ / Telefone / Contato / E-mail'
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
				<th>Cliente</th>
				<th>CNPJ</th>
				<th>Telefone</th>
				<th>Contato</th>
				<th>E-mail</th>
				<th colspan="4" width="17%">Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($clientes as $cliente)
			<tr>
				<td class="nome-cliente mark-search">{{{ $cliente->nome }}}</td>
				<td class="cnpj-cliente mark-search center">{{{ $cliente->cnpj }}}</td>
				<td class="telefone-cliente mark-search center">{{{ $cliente->telefone }}}</td>
				<td class="contato-cliente mark-search center">{{{ $cliente->pessoa_contato }}}</td>
				<td class="email-cliente mark-search center">{{{ $cliente->email }}}</td>
				<td class="center">
					<a href="{{ URL::to('admin/clientes-operacao', $cliente->id) }}" class="btn medium blue">
						<i class="halflings halflings-edit"></i>
					</a>
				</td>
				<td class="center">
					<button class="btn medium red btn-delete" data-id="{{ $cliente->id }}">
						<i class="halflings halflings-trash"></i>
					</button>
				</td>
				<td class="center">
					@if($cliente->usuarios()->whereStatus(1)->count())
					<button class="btn medium blue btn-usuarios" data-id="{{ $cliente->id }}">
						<i class="halflings halflings-user"></i> {{ $cliente->usuarios()->whereStatus(1)->count() }}
					</button>
					@else
					<button class="btn medium red btn-usuarios" data-id="{{ $cliente->id }}">
						<i class="halflings halflings-user"></i> 0
					</button>
					@endif
				</td>
				<td class="center">
					<!-- <a href="{{ URL::to('admin/produtos') }}" class="btn medium green">
						<i class="halflings halflings-shopping-cart"></i>
					</a> -->
					<a href="#" onclick="alert('Em desenvolvimento...')" class="btn medium green" title="Funcionalidade em desenvolviemnto...">
						<i class="halflings halflings-shopping-cart"></i>
					</a>
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

		$('.cnpj-cliente').each(function()
		{
			var cnpj = $(this).html().toLowerCase();
			cnpj = cnpj.replace(search, search.bold());
			$(this).html(cnpj.toUpperCase());
		});

		$('.telefone-cliente').each(function()
		{
			var telefone = $(this).html().toLowerCase();
			telefone = telefone.replace(search, search.bold());
			$(this).html(telefone.toUpperCase());
		});

		$('.contato-cliente').each(function()
		{
			var contato = $(this).html().toLowerCase();
			contato = contato.replace(search, search.bold());
			$(this).html(contato.toUpperCase());
		});

		$('.email-cliente').each(function()
		{
			var email = $(this).html().toLowerCase();
			email = email.replace(search, search.bold());
			$(this).html(email.toUpperCase());
		});
	@endif

	$('.btn-usuarios').showModal({
		title: 'Gerenciar usuários do cliente',
		template: '#cadastrar-usuarios',
		open: function(id)
		{
			getUsuariosCliente(id);

			var inputs, data;
			$('#submit-cliente-usuario').on('click', function()
			{
				inputs = {
					username: $('#usuario'),
					password: $('#senha'),
					conf_senha: $('#conf-senha'),
					nome: $('#nome'),
					cliente_id: $('#cliente_id')
				}

				data = {}
				for (key in inputs) {
					data[key] = inputs[key].val()
				}

				if (!data.username.length) {
					inputs.username.attr({
						'placeholder': 'O nome é obrigatório'
					}).focus();
				} else if (!data.password.length) {
					inputs.password.attr({
						'placeholder': 'A senha é obrigatória'
					}).focus();
				} else if (data.password != data.conf_senha) {
					inputs.conf_senha.attr({
						'placeholder': 'Senhas não conferem'
					}).val('');
					inputs.password.val('').focus();
				} else if (!data.nome.length) {
					inputs.nome.attr({
						'placeholder': 'O nome é obrigatório'
					}).focus();
				} else {
					var $alertClienteUsuario = $('#alert-cliente-usuario');
					$.ajax({
						url: '/admin/ajax-cadastrar-usuario-cliente',
						type: 'POST',
						dataType: 'json',
						data: data,
						beforeSend: function()
						{
							$('.loading-form').fadeIn();
						},
						success: function(response)
						{
							$('.loading-form').fadeOut();
							getUsuariosCliente(data.cliente_id);
							if (response.status) {
								$alertClienteUsuario.html('Usuário cadastrado com sucesso!').addClass('success').fadeOut().fadeIn();
							} else {
								$alertClienteUsuario.html(response.message).removeClass('success').fadeOut().fadeIn();
							}
						},
						error: function()
						{
							$('.loading-form').fadeIn();
							$alertClienteUsuario.html('Ocorreu um erro de conexão!').removeClass('success').fadeOut().fadeIn();
						}
					});
				}
			});
		}
	});

	$('.btn-delete').on('click', function()
	{
		var data = {
			cliente_id: $(this).data('id')
		}

		var $btn = $(this);

		$.ajax({
			url: '/admin/ajax-deletar-cliente',
			type: 'DELETE',
			dataType: 'json',
			data: data,
			success: function(response)
			{
				if (response.status) {
					$btn.closest('tr').fadeOut();
				} else {
					alert(response.message);
				}
			},
			error: function()
			{
				alert('Problemas na conexão!');
			}
		});
	});
});
function getUsuariosCliente(id)
{
	$.ajax({
		url: '/admin/ajax-usuarios-cliente/' + id,
		type: 'GET',
		dataType: 'json',
		success: function(response)
		{
			if (response.length) {
				var htmlUsers = '';
				for (key in response) {
					htmlUsers += '<tr>';
						htmlUsers += '<td>' + response[key].nome + '</td>';
						htmlUsers += '<td class="center">' + response[key].username + '</td>';
						htmlUsers += '<td class="center"><button class="btn medium red del-usuario-cliente" data-id="'+response[key].id+'"><i class="halflings halflings-trash"></i></button></td>';
					htmlUsers += '</tr>';
				}
				$('.default-modal').find('.jtable').find('tbody').html(htmlUsers);

				$('.del-usuario-cliente').on('click', function()
				{
					var $btn = $(this);
					$.ajax({
						url: '/admin/ajax-deletar-usuario-cliente',
						type: 'DELETE',
						data: {
							usuario_id: $btn.data('id')
						},
						success: function()
						{
							$btn.closest('tr').fadeOut('slow', function()
							{
								$(this).remove();
							})
						},
						error: function()
						{
							alert('Problemas na conexão!');
						}
					});
				});
			} else {
				$('.default-modal').find('.jtable').html('<div class="alert warning">Nenhum usuário cadastrado para esta empresa.</div>');
			}
		},
		error: function()
		{
			alert('Problemas na conexão! Atualize a página e tente novamente.');
		}
	});
}
</script>

<script type="text/template" id="cadastrar-usuarios">
	<form style="width:45%;position:relative" class="left">
		<div class="loading-form"></div>
		<input type="hidden" id="cliente_id" name="cliente_id" value="<%= id %>" />

		<div id="alert-cliente-usuario" class="alert" style="display:none"></div>

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

		<button type="button" id="submit-cliente-usuario" class="btn medium green right" style="margin: 10px 0 0 5px">
			<i class="halflings halflings-ok"></i> Salvar
		</button>

		<button type="button" class="btn medium right close" style="margin: 10px 0 0 0">
			<i class="halflings halflings-remove"></i> Cancelar
		</button>
	</form>
	<div class="jtable right" style="width:50%;margin:15px 0 0 0">
		<table>
			<thead>
				<tr>
					<th>Nome</th>
					<th>Usuário</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div><!-- .jtable -->
</script>

@append