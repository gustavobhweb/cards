@extends('layouts.default') 

@section('title') Baixar Carga @stop

@section('content')

<div class="clearfix">
	<div class="wm-input-container">
        {{ Form::open() }} 
        
        {{ 
            Form::text(
                'remessa_id',
                filter_var(Input::get('remessa_id')),
                ['class' => 'wm-input', 'id' => 'search-input']
            ) 
        }}
        
        {{ Form::submit('Pesquisar', ['class' => 'wm-btn wm-btn-blue']) }} 
        
        {{ Form::close() }}
    </div>
</div>


@if(count($remessas))

<div>
	{{ $errors->first('message', '<div class="j-alert-error">:message</div>') }}
	<table class="wm-table">
		<thead>
			<tr>
				<th width="12%">Nº da Remessa</th>
				<th>Data de Criação</th>
				<th>Responsável pelo Cadastro</th>
				<th width="10%">Nº de Solicitações</th>
				<th width="10%">Baixar</th>
			</tr>
		</thead>
		<tbody>
			@foreach($remessas as $remessa)
			<tr>
				<td>{{ zero_fill($remessa->id, 4) }}</td>
				<td>{{ $remessa->created_at->format('d/m/Y') }}</td>
				<td>{{ $remessa->usuario->nome }}</td>
				<td>{{ $remessa->solicitacoes->count() }}</td>
				<td>
                    @if(!$remessa->baixado) 
                    <a class="link not-downloaded" hef='{{ URL::to("cliente/download-carga-remessa/{$remessa->id}") }}'>
						<span class="glyphicon glyphicon-download-alt"></span>
                    </a> 
                    @else 
                    <a class="link downloaded" href='{{ URL::to("cliente/download-carga-remessa/{$remessa->id}") }}'>
						<span class="glyphicon glyphicon-ok-sign"></span>
                    </a>
                    @endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif 


{{ $remessas->links() }} 

@stop

@section('styles')

{{ 
    HTML::style('css/cliente/baixar_carga.css'),
    HTML::style('css/jquery-ui.css') 
}} 

@append 

@section('scripts') 

{{ 
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/cliente/baixar_carga.js') 
}}

@append
