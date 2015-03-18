@extends('layouts.default')


@section('title') Remessa {{ zero_fill($remessa->id, 4) }} @stop

@section('content')

<div class='jtable'>
    <div data-section='header'>
        <a href='{{ URL::previous() }}'
            class='wm-btn'>Voltar</a>
    </div>
    <!-- section="header" -->

    @if($solicitacoes->count())
        <table>
            <thead>
                <tr>
                    @foreach($remessa->fichaTecnica->camposVariaveis as $ficha)
                        <th>{{ ucfirst(str_replace('_', ' ', $ficha->nome)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($solicitacoes as $solicitacao)
                <tr>
                    @foreach($solicitacao->camposVariaveis as $campo)
                        <td>{{ $campo->pivot->valor }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>



        <div data-section='footer'>
            {{ $solicitacoes->links('elements.paginate') }}
        </div>
    @else
        <div data-section='footer'>Não há solicitações nessa remessa</div>
    @endif
    <!-- section="footer" -->
</div>
<!-- .jtable -->

@stop

@section('styles') 
    {{ HTML::style('css/jtable.css') }}
@append
