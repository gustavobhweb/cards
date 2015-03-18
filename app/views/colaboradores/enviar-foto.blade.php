@extends('layouts/default')

@section('title') Enviar foto @stop

@section('content')

{{ $errors->first('message', '<div class="pull-right j-alert-error">:message</div>') }}

<div class='modal-photo'>
    <div id="avisopermitir" style="width:100%;display:none;height:52px;background:#1558A7;position:fixed;top:0px;left:0">
        <img style="float:left; margin:4px 0 0 279px" src="{{ URL::to('img/permitirwebcam.png') }}" />
    </div>
    <div class='box-photo'>
        <div class='btn-close-box'></div>
        <div class='header-modal-photo'>
            Envio da foto
        </div><!--header-modal-photo-->
        <div class='content-modal-photo'>
            <div id='enviar-foto' style='float:left;width:430px;margin:50px 0 0 50px'>
                <p style='font:13px arial;margin:0 0 10px 0'>Selecione o tipo de envio da foto de sua preferência:</p>
                <button type='button' id='btn-take-photo' class='btn-take-photo'></button>
                <button type='button' onclick='$("#userfile").click();' class='btn-file-photo'></button>
                <button type='button' class='btn-fb-photo'></button>
            </div>

            <div id='webcam' style='display:none'>
                <div id="waitcam" style="width:374px;height:347px;background:url({{ URL::to('img/waitcam.jpg') }});margin:0 auto"></div>
                <div id="imgselect_container" style="display:none">
                    <button type="button" class="btn btn-success imgs-webcam" style="display:none">Webcam</button> <!-- .imgs-webcam -->

                    <div style="position:relative;width:287px;height:215px;margin:20px auto">
                        <div class="imgs-webcam-container"></div> <!-- .imgs-webcam-container -->
                        <div style="position:absolute;background:#EEEEEF;left:0;top:0;width:69px;height:215px"></div>
                        <div style="position:absolute;background:#EEEEEF;right:0;top:0;width:69px;height:215px"></div>
                    </div>

                    <div style="margin: 20px auto;position:relative;z-index:999999;width:190px">
                        <button class="btn-conf-iza imgs-capture btn-capture" onclick="onSnapClick()">Tirar foto</button>
                        <button class="btn-cancel-iza imgs-cancel btn-cancel-webcam return-modal-menu">Voltar</button>
                    </div>
                </div><!-- #imgselect_container -->
            </div><!-- #webcam -->

            <div class='loading' style='display:none;text-align:center;padding:30px 0 0 0'>
                <img src='{{ URL::to("img/loading.GIF") }}' width='60' />
            </div><!-- .loading -->

            <div id='flashcam' style='display:none;text-align:center;padding:30px 0 0 0'>
                <div id='flashbox'></div>
                <div id="btns-flash" style="margin: 20px auto;position:relative;z-index:999999;width:180px;display:none">
                    <button class="btn-conf-iza btn-capture-flash">Tirar foto</button>
                    <button class="btn-cancel-iza return-modal-menu">Voltar</button>
                </div>
            </div><!-- #flashcam -->

            <div id='crop' style='display:none;text-align:center;margin:20px auto 0 auto;width:320px;'>
                <div class="jcrop"></div>
                <button class="btn-cancel-iza return-modal-menu" style="float:none">Voltar</button>
                <button class="btn-conf-iza btn-make-crop" style="float:none">Salvar</button>
            </div><!-- #crop -->
            <div class='clear'></div>
        </div><!--content-modal-photo-->
    </div><!--box-photo-->
</div><!--modal-photo-->

<div class='content-box'>
        <div style='width:100%;float:left'>
            <section id="solicitacao-carteirinha">
        
                    <div id="mensagem-confeccao">
                        <img src="{{ URL::to('img/aluno/icon-atencao.png') }}" alt="" title="">
                        <p>Faça abaixo o upload da foto para confecção do documento. 
                        A carteirinha de identificação acadêmica te acompanhará durante todo o curso, 
                        por isso é importante o upload de uma foto recente e que essa siga as especificações abaixo.</p>
                    </div>
                    <div id="conteudo-passos">
                        <div class="passo"><h3>1</h3><br/><h4>Cadastrar Foto</h4></div>
                        <div class="passo"><h3>2</h3><br/><h4>Cadastrar Dados</h4></div>
                        <div class="passo passo3"><h3>3</h3><br/><h4>Local de entrega</h4></div>
                    </div>
                        <div class="conteudo-form">
                            <div style='width:100%'>
                                <div id="foto">
                                    <p>Nenhuma foto cadastrada</p>

                                
                                    {{
                                        HTML::image(
                                            "imagens/colaboradores/{$user->id}/temp.png",
                                            "Imagem",
                                            [
                                                'data-selected' => 'false',
                                                'class'         => 'userPhoto after-choice',
                                                'data-src'      => URL::to('img/aluno/foto.png'),
                                                'width'         => 161,
                                               	'height'        => 215,
                                                'data-id'       => $user->id
                                            ]

                                        );
                                    }}
                                    <button class='btn-img-pessoa'>Enviar foto</button>
                                </div><!-- Foto -->
                                <div id="especificacoes">
                                    <p>Especificações para foto:</p>
                                    <img ondragstart='return false;' oncontextmenu='return false' src="{{ URL::to('img/aluno/especificacoes.png') }}" title="" alt="" />
                                </div>
                            </div>
                            
                            {{ Form::model($user, ['files' => true, 'id' => 'form-cadastrar-solicitacao']) }}
                                <input type='file' name='userfile' id='userfile' style='display:none' />
                                <input type='hidden' name='webcam-upload' value='<?=$user->matricula.".png"?>' />
                                <input type="hidden" name='tmp_image' value="{{ Input::get('tmp_image') }}" />
                                <input type="hidden" name="sended" value="sended" />

                                <fieldset>
                                    <h5>E-mail principal:</h5>
                                    <div class="icon-status emailPrincipal">
                                        <span>E-mail:</span>
             

                                        {{

                                            Form::email(
                                                'email',
                                                Input::old('email'),
                                                [
                                                    'id'          => 'email',
                                                    'placeholder' => 'Nome@dominio.com',
                                                    'required'    => 'required',
                                                    'title'       => 'Informe um e-mail válido'
                                                ] 
                                            )
                                        }}

                                        <div class="glif"><div class="glyphicon glifEmail glyphicon-ok"></div></div>
                                    </div>
                                    <div class="icon-status emailPrincipal">
                                        <span>Confirmação e-mail:</span>'   '

                                        {{

                                            Form::email(
                                                'confirmaEmail',
                                                Input::old('confirmaEmail'),
                                                [
                                                    'id'          => 'confirmaEmail',
                                                    'placeholder' => 'Nome@dominio.com',
                                                    'required'    => 'required',
                                                    'title'       => 'E-mail não confere'
                                                ] 
                                            )
                                        }}


                                        <div class="glif"><div class="glyphicon glifEmail glyphicon-ok"></div></div>
                                    </div>
                                    <label id="infoEmailPrincipal">
                                        <p>Obs.:Digite seu e-mail com atenção, caso ocorra algum problema após envio dos dados você receberá um comunicado.</p>
                                    </label>
                                    
                                    <h5 id="titulo-endereco">Endereço residencial:</h5>
                                    <div class="icon-status dadosEndereco cep">
                                        <span>Cep:</span>

                                        {{
                                            Form::text(
                                                'cep',
                                                Input::old('cep'),
                                                [
                                                    'id'          => 'cep',
                                                    'class'       => 'cepInput',
                                                    'placeholder' => '00000-000',
                                                    'pattern'     => '\d{5}-\d{3}',
                                                    'required'    => 'required'
                                                ]
                                            )
                                        }}



                                        <div class="glif"><div class="glyphicon glyphicon-ok"></div></div>
                                        <button type="button" class="btn-conf-iza btn-verificar-cep" style="float:left;height:47px">VERIFICAR</button>
                                        <a href='http://www.buscacep.correios.com.br/' target='_blank'><span class="btn_nao_sabe">Não sei meu cep</span></a>
                                    </div>
                                    <div>
                                    <div class="icon-status dadosEndereco uf">

                                        <span>UF:</span>

                                        <div class="glif"><div class="glyphicon glifSelect glyphicon-ok"></div></div>

                                            {{ 
                                            	Form::select(
                                            		'uf',
                                            		$ufs,
                                            		Input::old('uf'),
                                            		['id' => 'uf', 'required' => 'required']
                                            	) 
                                            }}
                                        </select>
                                    </div>
                                    <div class="icon-status dadosEndereco cidade">
                                            <span>Cidade:</span>
                                            <div class="glif">
                                            	<div class="glyphicon glifSelect glyphicon-ok" style="margin-left: 207px !important;"></div>
                                            </div>

                                            <select name="cidade" id="cidade" required="required">
                                                <option value>(Selecione)</option>
                                                @if(!is_null($user->cidade))
                                                    <option selected="selected">{{ $user->cidade }}</option>
                                                @endif
                                            </select>


                                    </div>
                                    <div class="icon-status dadosEndereco endereco">
                                        <span>Endereço:</span>

                                        {{
                                        	Form::text(
                                        		'endereco',
                                        		Input::old('endereco'),
                                        		[
													'required'    => 'required',
													'id'          => 'endereco',
													'placeholder' => 'Endereço'
                                        		]
                                        	)
                                        }}

                                        <div class="glif">
                                        	<div class="glyphicon glyphicon-ok"></div>
                                        </div>
                                    </div>
                                    <div class="icon-status dadosEndereco numero">
                                        <span>Número:</span>

                                        {{ 
                                        	Form::text(
                                        		'numero',
                                        		Input::old('numero'),
                                        		[
													'required'    => 'required',
													'id'          => 'numero',
													'placeholder' => 'Número'
                                        		]
                                        	) 
                                        }}
                                        <div class="glif">
                                        	<div class="glyphicon glifNumero glyphicon-ok"></div>
                                        </div>
                                    </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="icon-status dadosEndereco bairro">
                                        <span>Bairro:</span>
                                        <input value="{{{ $user->bairro }}}" type="text" name="bairro" pattern=".{3,}"  required="required" id="bairro" placeholder="Bairro"/><div class="glif"><div class="glyphicon glyphicon-ok"></div></div>
                                    </div>
                                    <div class="icon-status dadosEndereco complemento">
                                        <span>Complemento:</span>
                                        <input value="{{{ $user->complemento }}}" type="text" name="complemento" pattern=".{2,}" id="complemento" placeholder="Ex.: Bloco 5, Aptº 204..."/><div class="glif"><div class="glyphicon glifComplemeno glyphicon-ok"></div></div>
                                    </div>
                                </fieldset>
                                
                        

                                <div id="captcha-wrap">
                                    <div class="captcha-box">
                                        <img src="{{ URL::to('captcha') }}" alt="" id="captcha" style="width:100px; height: 30px; margin-top:3px;" />
                                    </div>
                                    <div class="text-box">
                                        <label><strong style="float:left; margin-left:10px; font-size:11px;">Digite o código acima:</strong></label>
                                        <input name="captcha-code" type="text" id="captcha-code" style="height:27px !important;" autocomplete="off">
                                    </div>
                                    <div class="captcha-action" style="width:10px !important; float:left;">
                                        <img src="{{ URL::to('recaptcha/refresh.jpg') }}"  alt="" id="captcha-refresh" />
                                    </div>
                                </div>

                                <div class='send-buttons'>
                                    <label id="privacidade">
                                        {{ 
                                        	Form::checkbox(
                                        		'privacidade',
                                        		'',
                                        		Input::old('privacidade'),
                                        		['id' => 'privacidade-ckb']
                                        	) 
                                        }}
                                        <p>Declaro que todas as informações prestadas no presente cadastro são <b>verídicas</b> 
                                        e condordo com os <b>termos de uso</b> e <b>políticas de privacidade.</b></p>
                                    </label>
                                    <div style="width:100%;float:left">
                                        <button style='float:none' type='submit' name='btn-submit' class='btn-conf-iza'>ENVIAR SOLICITAÇÃO DA CARTEIRA</button>
                                        <button style='float:none' type='button' onclick='document.location.href="{{ URL::previous() }}"' class='btn-cancel-iza'>CANCELAR</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    
                </section>
        </div>
    <div class='clear'></div>
</div><!--content-box-->
<div class='clearfix'></div>


@include('elements/common-alert')

@stop

@section('scripts')
    {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('js/crop.js') }}
    {{ HTML::script('js/colaboradores/img_select.js') }}
    {{ HTML::script('js/fb.js') }}
    {{ HTML::script('js/colaboradores/enviar_foto.js') }}
    {{ HTML::script('js/aluno/jquery.webcam.js') }}
    {{ HTML::script('js/colaboradores/webcam.js') }}
    {{ HTML::script('js/wm-modal.js') }}
    {{ HTML::script('js/colaboradores/valida_form_solicitacao.js') }}
    {{ HTML::script('js/jQueryObjectForm.js') }}
@stop

@section('styles')
    {{ HTML::style('css/wm-modal.css') }}
    {{ HTML::style('css/crop.css') }}
    {{ HTML::style('css/imgSelect.css') }}
    {{ HTML::style('css/enviar-foto.css') }}
@stop