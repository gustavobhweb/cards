@extends('layouts.default')

@section('title') Gerenciar fichas técnicas @stop

@section('topbar')
<h4><i class="halflings halflings-list-alt"></i> Gerenciar fichas técnicas</h4>
<div class="list-menu right small">
    <button class="btn medium orange"><i class="halflings halflings-cog"></i> Gerenciar <span class="caret"></span></button>
    <div class="box">
        <ul>
            <li>
                <a href="{{ URL::to('admin/cadastrar-ficha-tecnica') }}">
                    <i class="halflings halflings-plus"></i>
                    Nova ficha técnica
                </a>
            </li>
            <li>
                <a href="{{ URL::to('admin/lixeira-fichas-tecnicas') }}">
                    <i class="halflings halflings-trash"></i>
                    Lixeira ({{ $fichas_tecnicas_lixeira_num }})
                </a>
            </li>
        </ul>
    </div><!-- .box -->
</div>
@stop

@section('content')

    {{ $errors->first('ficha_tecnica', '<div class="alert warning">:message</div>') }}


    @if($fichas_tecnicas->count())
    <div class="jtable" style="margin: 20px 0 0 0">
        <table>
            <thead>
                <tr>
                    <th>Ficha técnica</th>
                    <th>Foto Frente</th>
                    <th>Foto Verso</th>
                    <th>Número de campos</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fichas_tecnicas as $ficha_tecnica)
                <tr>
                    <td class="center">{{{ $ficha_tecnica->nome }}}</td>
                    <td class="center">
                        <img src="{{ $ficha_tecnica->foto_frente_link }}" height="50" width="50" />
                    </td>
                    <td class="center">
                        <img src="{{ $ficha_tecnica->foto_verso_link }}" height="50" width="50" />
                    </td>
                    <td class="center">{{{ $ficha_tecnica->camposVariaveis->count() }}}</td>
                    <td class="center">

                        @unless($ficha_tecnica->aprovado)
                            <a href='{{ URL::to("admin/editar-ficha-tecnica", [$ficha_tecnica->id]) }}' class="btn medium blue">
                                <i class="halflings halflings-edit"></i>
                            </a>
                        @else
                            <a href='#' class="btn medium disabled" title="Ficha técnica já foi aprovada pelo cliente">
                                <i class="halflings halflings-edit"></i>
                            </a>
                        @endif
                        <button type="button" class="btn medium red btn-del" style="margin-left:5px" data-id="{{ $ficha_tecnica->id }}">
                            <i class="halflings halflings-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- .jtable -->
    @else
    <div class="alert warning">Ainda não existem fichas técnicas cadastradas. Clique em Gerenciar > Nova ficha técnica</div>
    @endif

@stop

@section('styles')
{{
    HTML::style('css/jtable.css')
}}
@append

@section('scripts')
{{
    HTML::script('js/admin/gerenciar-fichas-tecnicas.js')
}}
@append