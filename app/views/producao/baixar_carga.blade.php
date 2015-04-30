@extends('layouts.default') 

@section('topbar') 
    <h4><i class="halflings halflings-download-alt"></i> Baixar Carga </h4>
@stop

@section('content')

<div class="wm-btn-group not-print">
	<a id="btn-tab-remessas" class="btn medium change-tab active"
		data-target="tab-remessas">Remessas</a> 

    <a class="change-tab btn medium"
		data-target="tab-tarefas">Minhas Tarefas</a>
</div>

<section class="not-print">

    <input type='hidden' id="user-data" data-nome="{{{ $user->nome }}}" />

    {{ $errors->first('message', '<div class="alert warning">:message</div>') }}

    @if($remessas->count())
    
    <div class="jtable" style="margin:20px 0 0 0">
        <table id="tabela-baixar-carga">
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

                    @if(!($temProtocolo = ! is_null($remessa->protocolo)) || $remessa->protocolo->usuario_id == $user->id)

                        <tr class="{{ $temProtocolo ? 'tab-tarefas' : 'tab-remessas' }}">
                            <td class="center">{{ zero_fill($remessa->id, 4) }}</td>
                            <td class="center"></td>
                            <td class="center">{{{ $remessa->usuario->nome }}}</td>
                            <td class="center">
                            @if(!$remessa->fichaTecnica->tem_dados)
                            {{ $remessa->qtd }}
                            @else
                            {{ $remessa->solicitacoes->count() }}
                            @endif
                            </td>
                            <td class='responsavel-producao center'>
                                {{ $remessa->protocolo->usuario->nome or '--' }}
                            </td>
                            <td width="25%" class="links-actions-groups center">

                                @if(! $temProtocolo || $remessa->protocolo->usuario_id == $user->id)
                                    
                                    <a data-id="{{ $remessa->id }}" class="btn medium imprimir-remessa" href="#">
                                        <span class="halflings halflings-print"></span>
                                    </a>

                                    @if($remessa->fichaTecnica->tem_dados)
                                    <a  class="{{ !$temProtocolo ?  'disabled' : ''  }} download-xls btn medium" href="{{ URL::to('producao/download-excel-remessa', $remessa->id) }}">
                                        <span class="halflings halflings-download-alt"></span>
                                    </a>
                                    @endif

                                    @if($remessa->fichaTecnica->tem_foto)
                                    <a class="{{ !$temProtocolo ? 'disabled' : ''  }} download-zip btn medium" href="{{ URL::to('producao/download-fotos-remessa', $remessa->id) }}">
                                        <span class="halflings halflings-picture"></span>
                                    </a>
                                    @endif

                                    <button data-id="{{ $remessa->id }}" class="{{ !$temProtocolo ? 'disabled' : '' }} btn medium green btn-enviar-conferencia ">
                                        <span class="halflings halflings-ok"></span>
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
    </div><!-- .jtable -->

    @else
        <div class="alert warning">Não há solicitações para produção</div>
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
