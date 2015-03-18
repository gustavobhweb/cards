@extends('layouts.default')


@section('topbar')
<h4><i class="halflings halflings-cog"></i> Tipos de Entrega</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
    <i class="halflings halflings-remove"></i> Cancelar
</a>
@stop


@section('content')
    {{ Form::open(['method' => 'GET']) }}
    <div class="clearfix" style="margin:0 0 15px 0 ">
        {{ 
            Form::text(
                'nome',
                Input::get('nome'),
                [
                    'class' => 'medium',
                    'placeholder' => 'Nome do tipo de entrega'
                ]
            ) 
        }}

        @if(Input::has('nome'))

        {{ 
            HTML::link(
                URL::current(),
                'Voltar',
                ['class' => 'btn medium']
            )
        }}
        
        @endif

        {{ 
            Form::button(
                'Pesquisar',
                [
                    'class' => 'btn medium blue',
                    'type'  => 'submit'
                ]
            )
        }}
    </div>
    {{ Form::close() }}

    <section class="jtable">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ativa</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach($tiposEntrega as $tipo)
            <tr class="text-center">
                <td>{{ $tipo->id }}</td>
                <td>{{{ $tipo->nome }}}</td>
                <td>{{ $tipo->status ? 'Sim' : 'Não'}}</td>
                <td class='center'>
                    <a 
                        href="{{ URL::to('admin/editar-tipo-entrega', [$tipo->id]) }}" class="wm-btn"
                    >
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>

                    @if($tipo->status)
                        <a data-id="{{ $tipo->id }}" class="change-status desativar btn medium" href='#'>Desativar</a>
                    @else
                        <a data-id="{{ $tipo->id }}" class="change-status ativar btn medium blue" href='#'>Ativar</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    {{ $tiposEntrega->links() }}

@include('elements.common-alert')

</section>
@stop


@section('styles')
{{
    HTML::style('css/jtable.css'),
    HTML::style('css/admin/tipos-entrega.css'),
    HTML::style('css/wm-grid.css')
}}
@append


@section('scripts')
{{ HTML::script('js/admin/tipos-entrega.js') }}
@append