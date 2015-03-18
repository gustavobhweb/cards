@extends('layouts.default') @section('title') Pesquisar Alunos @stop

@section('content')


<div class='clear'></div>
<div style="margin: 30px">
	{{ Form::open(['method' => 'get']) }} 
    
    {{ Form::select( 'filtro',
	$filters, filter_var(Input::get('filtro')), ['class' => 'wm-input',
	'id' => 'selecionar-filtro'] ) }}
    
    {{ Form::text( 'valor',
	filter_var(Input::get('valor')), [ 'class' => 'wm-input input-large',
	'placeholder' => 'Entre com uma palavra-chave', 'id' =>
	'pesquisa-input' ] ) }}
    
    {{ Form::button('Pesquisar', ['class' =>
	'wm-btn wm-btn-blue', 'type' => 'submit']) }}
    
    {{ Form::close() }}

	<div>{{ $errors->first('errorDetail') }}</div>
	<br /> 
    
    @if(!empty($filtro))
    
        @if(isset($usuarios) && $usuarios->count())
            {{ Form::open(), Form::hidden('download') }} 
            {{ Form::button('Baixar', ['class' => 'wm-btn', 'type' => 'submit']) }}
            {{ Form::close() }}

            <table style="width: 100%" class='wm-table'>
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Matrícula</th>
                        <th>CPF</th>
                        <th>Curso</th>
                        <th>Status</th>
                        <th>Remessa</th>
                        <th>Código W</th>
                        <th>Instituição</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{{ $usuario->nome }}}</td>
                        <td>{{{ $usuario->matricula }}}</td>
                        <td>{{{ $usuario->cpf }}}</td>
                        <td>{{{ $usuario->curso }}}</td>
                        <td>{{ $usuario->ultimaSolicitacao->status->titulo or '--' }}</td>
                        <td>{{ isset($usuario->remessa) ? zero_fill($usuario->remessa, 4) :
                            '--' }}</td>
                        <td>{{ $usuario->ultimaSolicitacao->codigo_w or '--' }}</td>
                        <td>{{ $usuario->instituicao }}</td>
                        <td>
                            <!--<button data-image-path="{{ URL::to('/imagens/') }}" data-object="{{{ $usuario }}}" class="wm-btn wm-btn-blue show-info">
                                            <strong>+</strong>
                                        </button>
                                        -->
                        </td>
                    </tr>

                    @endforeach
                </tbody>

            </table>
            
            <div class="pull-right wm-paginator-container">{{ $usuarios->links() }}</div>
        @else
            <div class='wm-text-warning'>
                @if(!$valor) Sua pesquisa é inválida para o filtro "<strong>{{
                    $filters[$filtro] }}</strong>" @else Não há nenhum resultado para "<strong>{{
                    $valor }}</strong>" @endif
            </div>
        @endif
    @endif
</div>

<script type="text/template" id="tpl-more-info">
    <div class="infouser-modal">
       <div style="width:50%" class="pull-left">
       <% if (usuario.ultima_solicitacao){  %>
        <img src="<%= imagePath + '/' + usuario.ultima_solicitacao.foto %>" height="300" width="225">
      <% } %>
      </div>
       <table>
          <tbody>
             <tr>
                <td>Nome</td>
                <td><%= usuario.nome %></td>
             </tr>
             <tr>
                <td>Matrícula</td>
                <td><%= usuario.matricula %></td>
             </tr>
             <tr>
                <td>CPF</td>
                <td><%= usuario.cpf %></td>
             </tr>
             <tr>
                <td>Curso</td>
                <td><%= usuario.curso %></td>
             </tr>
             <tr>
                <td>Status</td>
                <td><%= usuario.ultima_solicitacao.status.titulo%></td>
             </tr>
          </tbody>
       </table>
       <div style="clear:both"></div>
    </div>
</script>

@include('elements.common-alert') 

@stop

@section('scripts') 

{{ 
    HTML::script('js/cliente/pesquisar_alunos.js'),  
    HTML::script('js/wm-modal.js'), HTML::script('js/jquery-ui.js'),
    HTML::script('js/underscore-min.js') 
}}

@stop 

@section('styles')

{{ HTML::style('css/wm-modal.css'), HTML::style('css/jquery-ui.css') }}

@stop
