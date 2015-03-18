@extends('layouts/default')

@section('title') Página Inicial @endsection

@section('content')

<div style='float:left;margin:20px 0 0 20px'>

    @if($avisos->count())
        <h2 style='margin:20px 0 0 0;font:26px Arial;color:black'>Avisos</h2>

        <div style='margin:10px 0 0 0'>
            <div class='head-item' style='width:100px'>Status</div>
            <div class='head-item' style='width:180px'>Assunto</div>
            <div class='head-item' style='width:90px'>Remetente</div>
            <div class='head-item' style='width:180px'>Mensagem</div>
            <div class='head-item' style='width:150px'>Selecionar</div>
            <div class='clearG'></div>
        </div>
        <br />

        <div style='overflow-y:auto;max-height:350px;'>
        @foreach($avisos as $aviso)
        <a href='{{ URL::to("aluno/ler-aviso/{$aviso->id}") }}'>
            <div class='item-aviso'>
                <div class='item-line-aviso' style='width:100px'>
                    @if($aviso->lido)
                        <p class="read">Lido</p>
                    @else
                        <p class='unread'>Não lido</p>
                    @endif
                    <img src='{{ URL::to("img/msg.png") }}' />
                </div>
                <div class='item-line-aviso' style='width:180px'>
                    <p style='font:14px Arial;color:black;font-weight:bold;width:180px;margin:30px 0 0 0'>
                    {{{ $aviso->assunto }}}
                    </p>
                </div>
                <div class='item-line-aviso' style='width:90px'>
                    <p style='font:14px Arial;color:black;font-weight:bold;max-width:180px;margin:30px 0 0 0'>
                    {{{ $aviso->remetente }}}
                    </p>
                </div> 
                <div class='item-line-aviso' style='width:180px'>
                    <p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;width:180px;font-style:italic'>
                        {{{ Str::limit($aviso->mensagem, 30, '...') }}}
                    </p>
                </div>
                <div class='item-line-aviso' style='border:none;width:150px'>
                    <button style='margin:24px 0 0 6px' class='btn-conf-iza'>CONTINUAR ></button>
                </div>

                <div class='clearfix'></div>
            </div>
        </a>
       @endforeach
       @if($avisosCount > 2)
       <a class="wm-btn pull-right" href="{{ URL::to('aluno/avisos') }}"><i class="glyphicon glyphicon-eye-open"></i> Ver todos</a>
       @endif
       </div>  

    @endif
    
    <div class='clearfix'></div>

    <h2 style='margin:40px 0 0 0;font:26px Arial;color:black'>Solicitação da carteira de identidade acadêmica</h2>

    <div style='margin:10px 0 0 0'>
        <div class='head-item' style='width:180px'>Produto</div>
        <div class='head-item' style='width:80px'>Modelo</div>
        <div class='head-item' style='width:240px'>Imagem</div>
        <div class='head-item' style='width:100px'>Situação</div>
        <div class='head-item' style='width:100px'>Selecionar</div>
        <div class='clearG'></div>
    </div><br>

        <a id='lnk-enviar-foto' href='{{ URL::to("colaboradores/enviar-foto") }}'><div class='item-solics'>
            <div class='item-line-aviso' style='width:180px'>
                <p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;width:180px'>Carteira de identidade acadêmica</p>
            </div>
            <div class='item-line-aviso' style='width:80px'>
                <p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0'>Crachá</p>
            </div>
            <div class='item-line-aviso' style='width:240px'>
                <img src='{{ URL::to("img/carteira_1.png") }}' style='margin:-6px 0 0 0' />
            </div>
            <div class='item-line-aviso' style='width:100px'>
                <p style='font:14px Arial;color:#0060B2;font-weight:bold;margin:20px 0 0 0;font-style:italic'>
                    {{ ($emandamento) ? $statusAtual->titulo : (($creditos) ? 1 : 0) . " crédito(s) disponível(eis)" }} 
                </p>
            </div>
            <div class='item-line-aviso' style='border:none' style='width:100px'>
                <button style='margin:24px 0 0 0' class='btn-conf-iza' href="{{ URL::to('aluno/acompanhar') }}" >CONTINUAR >
                </button>
            </div>
            
            <div class='clearG'></div>
        </div></a>
</div>

@include('elements/common-alert')

@stop

@section('scripts')
    {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('js/wm-modal.js') }}
    @if(!$creditos && !$emandamento)
        <script type="text/javascript">
        $(function(){
            $('#lnk-enviar-foto').on('click', function(e){
                e.preventDefault();
                new wmDialog('Você não tem créditos suficientes para fazer a solicitação. Solicite na sua instituição de ensino.', {
                    height:230,
                    width: 330,
                    btnCancelEnabled: false
                }).open();
            });
        });
        </script>
    @endif
@endsection

@section('styles')
    {{ HTML::style('css/wm-modal.css') }}
@stop