@extends('layouts.default')


@section('title') <i class="glyphicon glyphicon-barcode"></i> Lista de Remessas para conferir @stop 

@section('content')

<section>

    {{ $errors->first('message', '<div class="j-alert-error">:message</div>') }}

    @if($remessas->count())
    <div class="jtable">
        <table>
            <thead>
                <tr>
                    <th width="12%">Remessa</th>
                    <th>Data de Criação</th>
                    <th>Baixou a carga</th>
                    <th width="10%">Nº de Solicitações</th>
                    
                    <th width="10%">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($remessas as $remessa)
                <tr>
                    <td>{{ zero_fill($remessa->id, 4) }}</td>
                    <td>{{ $remessa->created_at->format('d/m/Y') }}</td>
                    <td>
                    {{
                        $remessa->statusAtual->usuario
                    }}
                    </td>
                    <td>{{ $remessa->solicitacoes->count() }}</td>
                    <td width="20%" class="links-actions-groups">
                        <a href="{{ URL::to('producao/conferir-remessa', $remessa->id) }}" class="wm-btn">
                            <span class="glyphicon glyphicon-circle-arrow-right"></span>
                        </a>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        <div data-section="footer">
            {{ $remessas->links('elements.paginate') }}
        </div><!-- .footer -->
    </div><!-- .jtable -->
    @else
        <div class="j-alert-error">Não há solicitações para produção</div>
    @endif
</section>
@stop

@section('styles')
    {{ HTML::style('css/jtable.css') }}
@stop
