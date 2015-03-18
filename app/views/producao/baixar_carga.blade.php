@extends('layouts.default') 

@section('title') <i class="glyphicon glyphicon-download-alt"></i> Baixar Carga @stop

@section('content')

<div class="wm-btn-group not-print">
	<a id="btn-tab-remessas" class="wm-btn change-tab active"
		data-target="tab-remessas">Remessas</a> <a class="wm-btn change-tab"
		data-target="tab-tarefas">Minhas Tarefas</a>
</div>

<section class="not-print">

    <input type='hidden' id="user-data" data-nome="{{{ $user->nome }}}" />

    {{ $errors->first('message', '<div class="j-alert-error">:message</div>') }}

    @if($remessas->count())
    
    <table class="wm-table" id="tabela-baixar-carga">
        <thead>
            <tr>
                <th width="12%">Remessa</th>
                <th>Data de Criação</th>
                <th>Responsável financeiro</th>
                <th width="10%">Nº de Solicitações</th>
                <th>Iniciou a produção</th>
                
                <th width="10%">Baixar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($remessas as $remessa)

                @if( !($temProtocolo = ! is_null($remessa->protocolo)) || $remessa->protocolo->usuario_id == $user->id) 

                    <tr class="{{ $temProtocolo ? 'tab-tarefas' : 'tab-remessas' }}">
                        <td>{{ zero_fill($remessa->id, 4) }}</td>
                        <td>{{ $remessa->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{{ $remessa->usuario->nome }}}</td>
                        <td>{{ $remessa->solicitacoes->count() }}</td>
                        <td class='responsavel-producao'>
                            {{ $remessa->protocolo->usuario->nome or '--' }}
                        </td>
                        <td width="25%" class="links-actions-groups">

                            @if(! $temProtocolo || $remessa->protocolo->usuario_id == $user->id)
                                
                                <a data-id="{{ $remessa->id }}" class="wm-btn imprimir-remessa" href="#">
                                    <span class="glyphicon glyphicon-print"></span>
                                </a>

                                <a  class="{{ !$temProtocolo ?  'disabled' : ''  }} download-xls wm-btn" href="{{ URL::to('producao/download-excel-remessa', $remessa->id) }}">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                </a>

                                <a class="{{ !$temProtocolo ? 'disabled' : ''  }} download-zip wm-btn" href="{{ URL::to('producao/download-fotos-remessa', $remessa->id) }}">
                                    <span class="glyphicon glyphicon-picture"></span>
                                </a>

                                <button data-id="{{ $remessa->id }}" class="{{ !$temProtocolo ? 'disabled' : '' }} wm-btn wm-btn-green btn-enviar-conferencia ">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>

                            @endif
                        </td>
                    </tr> 

                @endif   

            @endforeach
            <tr id="sem-resultados" style="display:none">
                <td colspan='6'>Não existem tarefas</td>
            </tr>
        </tbody>
    </table>

    @else
        <div class="j-alert-error">Não há solicitações para produção</div>
    @endif

</section>

<div class='clearfix'></div>
<iframe id='only-print-container'></iframe>

@include('elements.common-alert')

@stop

@section('styles') 
{{
	HTML::style('css/producao/baixar_carga.css'),	
	HTMl::style('css/wm-modal.css') 
}} 
@append

@section('scripts')
{{
	HTML::script('js/producao/baixar_carga.js'),
	HTML::script('js/jquery-ui.js'), 
	HTML::script('js/underscore-min.js'),
	HTMl::script('js/wm-modal.js')
}} 
@append
