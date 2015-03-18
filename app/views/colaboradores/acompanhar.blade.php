@extends('layouts/default')

@section('title') Acompanhar minhas
    solicitações
    <div class='num' style='float: right; margin: 5px 5px 0 12px;'> {{ count($solicitacoes) }}</div>
@stop

@section('content')
    @if (!count($solicitacoes))
    <div class='j-alert-error' style="float: left; margin: 25px 0 0 15px">
        Nenhuma solicitação foi enviada. <a href='<?=URL::to("colaboradores")?>'>
            <button class="btn-conf-iza">Enviar solicitação</button>
        </a>
    </div>
    @else
    
        <?php $via = $solicitacoes->count(); ?>
        
        @foreach ($solicitacoes as $solicitacao)
            @if ($via == count($solicitacoes) - 1)
            
                @if (count($solicitacoes) > 2)
                    <h2 class='historico-title'>Histórico de solicitações</h2>
                @elseif(count($solicitacoes) > 1)
                    <h2 class='historico-title'>Histórico de solicitação</h2>
                @endif

            @endif

            <div class='situacao-box'>
                
                @if($solicitacao->status->id == 8)
                <div class='reprovada'>
                    <h1>FOTO REPROVADA</h1>
                </div>
                @endif

                <h2 style="margin-bottom: 10px">Situação</h2>
                <div class='left-infos'></div>
                <div class='infos'>
                    <div style="float: left; width: 75%">
                        <h3 class='via'>{{ $via }} VIA(S)</h3>
                        <div class='modelos'>
                            <div class='modelo frente'>
                                <img width='71' height='95'
                                src='{{ URL::to("imagens/" . Auth::user()->matricula . "/" . $solicitacao->foto) }}' />
                            </div>
                            <!-- .frente -->
                            <div class='modelo verso'></div>
                        </div>
                        <!-- .modelos -->
                        <div class='regua'>
                            <div
                                class='passo {{ ($solicitacao->status_atual >= 2 && $solicitacao->status_atual != 8) ? "orange" : "" }}'
                                data-step='1'>
                                <p>Análise da foto</p>
                            </div>
                            <div
                                class='passo {{ ($solicitacao->status_atual >= 3 && $solicitacao->status_atual != 8) ? "steelblue" : "" }}'
                                data-step='2'>
                                <p>Fabricação</p>
                            </div>
                            <div
                                class='passo {{ ($solicitacao->status_atual >= 4 && $solicitacao->status_atual != 8 && $solicitacao->status_atual != 9) ? "blue" : "" }}'
                                data-step='3'>
                                <p>Conferência</p>
                            </div>
                            <div
                                class='passo {{ ($solicitacao->status_atual >= 6 && $solicitacao->status_atual != 8 && $solicitacao->status_atual != 9 && $solicitacao->status_atual != 10) ? "steelgreen" : "" }}'
                                data-step='4'>
                                <p>Disponível para entrega</p>
                            </div>
                            <div
                                class='passo {{ ($solicitacao->status_atual >= 7 && $solicitacao->status_atual != 8 && $solicitacao->status_atual != 9 && $solicitacao->status_atual != 10) ? "green" : "" }}'
                                data-step='5'>
                                <p>Entregue</p>
                            </div>
                        </div>
                        <!-- .regua -->
                    </div>
                    <div class="status-list">
                        <div class='title'></div>
                        <div class='content'>

                            @foreach($solicitacao->solicitacoesStatus as $key => $val)
                            
                                @if($solicitacao->solicitacoesStatus[$key]->status->id != 9)
                                <div class='item'>
                                    <h3>{{ $letters[$key] }}</h3>
                                    <div class='right'>
                                        <h4>{{ $solicitacao->solicitacoesStatus[$key]->status->titulo }}</h4>
                                        <p>
                                        {{ 
                                            $solicitacao->solicitacoesStatus[$key]
                                                        ->created_at
                                                        ->format('d/m/Y à\s H:i')
                                        }}
                                        </p>
                                        
                                        @if($solicitacao->status_atual > 2 && $key == 0)
                                            <div class='add'>
                                                <h4>Aprovado</h4>
                                                <p>
                                                {{ 
                                                    $solicitacao->solicitacoesStatus[$key]
                                                                ->created_at
                                                                ->format('d/m/Y à\s H:i')
                                                }}
                                                </p>
                                            </div>
                                        @endif
                                </div>
                                <!-- .right -->
                            </div>
                            <!-- .item -->
                            @endif
                            @endforeach
                        </div>
                        <!-- .content -->
                    </div>
                    <!-- .status-list -->
                </div>
                <!-- .infos -->
            </div><!-- .situacao-box -->
        <?php $via--;?>
        @endforeach
    @endif
@stop

@section('scripts')
{{ 
    HTML::script('js/nicescroll.js'),
    HTML::script('js/aluno/acompanhar_solicitacao.js')
}}
@stop

@section('styles')
    {{ HTML::style('css/aluno/acompanhar_solicitacao.css') }}
@stop
