@extends('layouts.default')

@section('title') Avisos @stop

@section('content')
<div class="avisos-table">
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Assunto</th>
                <th>Remetente</th>
                <th>Mensagem</th>
                <th>Selecionar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($avisos as $aviso)
            <tr class="clickable">
                <td>   
                    @unless($aviso->lido)
                        <h4>Não lido</h4>
                    @else
                        <h4>Lido</h4>
                    @endif

                    <img src="{{ URL::to('img/msg.png') }}" />
                </td>
                <td>{{{ $aviso->assunto }}}</td>
                <td>{{{ $aviso->remetente }}}</td>
                <td>{{{ Str::limit($aviso->mensagem, 40, '...') }}}</td>
                <td>
                    {{
                        HTML::link(
                            "aviso/ler/{$aviso->id}",
                            'LER',
                            ['class' => 'btn-style arrow-right link-url']
                        )
                    }}
                </td>
            </tr>
            <tr class="normalize">
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right"> {{ $avisos->links('elements.wm-paginator') }} </div>
</div><!-- .avisos-table -->
@stop


@section('styles')
{{ 
    HTML::style('css/aviso/index.css'),
    HTML::style('css/jtable.css')
}}
@append