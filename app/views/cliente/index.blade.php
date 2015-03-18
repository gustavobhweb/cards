@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-stats"></i> Gerenciamento</h4>
@stop

@section('content')

    <div class="jtable">
        <table>
            <thead>
                <tr>
                    <th>Modelo</th>
                    <th>Imagem</th>
                    <th>Status do modelo</th>
                    <th>Selecionar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fichas_tecnicas as $ficha)
                <tr class="clickable {{ (!$ficha->aprovado) ? 'red' : '' }}">
                    <td>{{ $ficha->nome }}</td>
                    <td class="fotos-modelos center">
                        <img src="{{ URL::to($ficha->foto_frente_link) }}" />
                        <img src="{{ URL::to($ficha->foto_verso_link) }}" />
                    </td>
                    <td class="aprovacao center">{{ ($ficha->aprovado) ? '<i class="halflings halflings-ok"></i> Aprovado' : '<i class="halflings halflings-remove"></i> Aguardando sua aprovação' }}</td>
                    <td class="center">


                        @if($ficha->aprovado)
                        
                        {{
                            HTML::link(
                                "cliente/enviar-remessa/{$ficha->id}",
                                'Enviar carga',
                                ['class' => 'btn large green continuar link-url']
                            )
                        }}
                        
                        @else
                            
                        {{
                            HTML::link(
                                "cliente/aprovar-ficha-tecnica/{$ficha->id}",
                                'Analisar',
                                ['class' => 'btn large orange link-url']
                            )
                        }}
                            
                        @endif
                    </td>
                </tr>
                <tr class="normalize">
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- .gerenciamento-table -->
@stop

@section('styles')
{{ HTML::style('css/cliente/index.css') }}
@append


@section('scripts')
{{ HTML::script('js/cliente/index.js') }}
@append
