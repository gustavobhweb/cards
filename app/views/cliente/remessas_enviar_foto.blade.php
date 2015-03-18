@extends('layouts.default')

@section('topbar')
    <h4><i class="halflings halflings-picture"></i> Enviar fotos</h4>
@stop

@section('content')

@include('elements.cliente.submenu-remessas')

<div class="content-remessas">
@if(count($remessas))
<div class="jtable">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nº de Solicitações</th>
                <th>Fotos enviadas</th>
                <th>Fotos restantes</th>
                <th>Enviar fotos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($remessas as $remessa)
            <tr>
                <td class="center">{{ $remessa->id }}</td>
                <td class="count-total center">{{ $remessa->solicitacoes->count() }}</td>
                <td class="count-incompletes center">
                    <?php 
                        $total = $remessa->solicitacoes->count();
                        $cur = $remessa->solicitacoes->filter($callbackHasPhoto)->count();
                    ?>
                    <progress 
                        value="{{ $cur }}" 
                        max="{{ $total }}"
                        class="progress-bar" 
                        data-id="{{ $remessa->id }}"></progress>
                        <p data-id="{{ $remessa->id }}" class="progress-desc">{{ $cur . '/' . $total }}</p>
                </td>
                <td class="center">
                    <button type="button" class='btn-info btn medium blue' value="{{ $remessa->id }}">
                        <span class='halflings halflings-plus'></span>
                    </button>
                </td>
                <td class="center container-input-file" data-id="{{ $remessa->id }}">
                    {{
                        Form::button(
                            '<i class="halflings halflings-picture"></i> Selecionar arquivo ...',
                            ['class' => 'btn medium fake-file-zip', 'style' => 'width:200px']
                        )
                    }}
                    {{ 
                        Form::file(
                            'zip',
                            [
                                'style' => 'display:none',
                                'class' => 'file-zip-upload'
                            ]
                        )
                     }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div data-section="footer">
        {{ $remessas->links() }}
    </div>
</div><!-- .jtable -->
@else
    <div class="alert warning">
        Não há remessas para o envio de fotos
    </div>
@endif
</div><!-- .content-remessas -->

@include('elements.common-alert')

@stop

@section('styles')
{{ 
    HTML::style('css/jtable.css'),
    HTML::style('css/cliente/remessas.css')
}}
@append

@section('scripts')

{{ 
    HTML::script('js/cliente/remessas.js'),
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/underscore-min.js')
}}

<script type="text/template" id="tpl-msg">
<li>Foram enviados <%= data.included_files.length %> arquivos</li>
<li>Foram atualizados <%= data.row_count %> registros</li>
</script>

<script type="text/template" id="tpl-more-info">
<section class='jtable'>
<div data-section="header">Solicitações pendentes</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Foto</th>
        </tr>
    </thead>
    <% _.each(solicitacoes, function (solicitacao){ %>
        <tr>
            <td><%= solicitacao.id %></td>
            <td><%= solicitacao.codigo %>.jpg</td>
        </tr>
    <% }) %>
</table>
</section>
</script>
@append