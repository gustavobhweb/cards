@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-glyph-briefcase"></i> Enviar carga</h4>
@stop

@section('content')

    @include('elements.cliente.submenu-remessas')

    @if($errors->has('message'))
        <div class="alert warning">{{ $errors->first('message') }}</div>
    @endif 

    <div class="pull-left total">
    {{ Form::open(['files' => true]) }}

        <div class="fc-section">
            <div class="title">
                <span>1</span>
                <h4>Download do arquivo XLS modelo</h4>
            </div>

            <div class="content-section">
                <a id="btn-download-model" style="float:left;margin-top:10px" target="_blank" href="{{ URL::to('cliente/download-modelo-excel/' . $ficha_tecnica_id) }}" class="btn medium blue"><i class="halflings halflings-arrow-down"></i> Baixar modelo</a>
            </div>
        </div>

        <div class="fc-section">
            <div class="title">
                <span>2</span>
                <h4>Enviar dados</h4>
            </div>
            <div class="content-section" style="margin:10px 0 0 0">
                {{ Form::label('fake-file-excel', 'Envie um arquivo XLS ou XLSX com os dados:') }}
                <input type="hidden" name="ficha_tecnica_id" value="{{ $ficha_tecnica_id }}" />
                {{ 
                    Form::button(
                        'Selecione um arquivo ...', 
                        ['id' => 'fake-file-excel', 'type' => 'button', 'class' => 'btn medium total', 'style' => 'margin:10px 0 0 0']
                    ) 
                }}
                {{ Form::file('excel', ['style' => 'display:none']) }}
                {{ 
                    Form::button(
                        'Enviar', 
                        ['id' => 'fake-send-button', 'class' => 'btn medium blue total', 'type' => 'button', 'style' => 'margin:10px 0 0 0']
                    )
                }}
                {{  
                    Form::button(
                        'Enviar',
                        ['id' => 'send-form-button', 'type' => 'submit', 'style' => 'display:none']
                    )
                }}
            </div>
        </div>
        
    {{ Form::close() }}
    </div>


@if(Session::has('messageSuccess'))
    <div class="alert success">{{ Session::get('messageSuccess') }}</div>
@endif

@if($excelData = Session::get('uploadedData'))

    <?php

        $countYes = count($excelData['yes']);

        $countEmpty = count($excelData['hasEmpty']);

        $countAll = $countYes + $countEmpty;
    ?>

    <div class="alert success" style="font-size: 14px">
    	<table class="table">
    		<tr>
    			<td>Número de linhas do arquivo</td>
    			<th>{{ $countAll }}</th>
    		</tr>
    		<tr>
    			<td>Funcionários cadastrados</td>
    			<th>{{ $countYes }}</th>
    		</tr>
    		<tr>
    			<td>Número de registro não inseridos (dados em branco)</td>
    			<th>{{ $countEmpty }}</th>
    		</tr>
    	</table>
    </div>

    @if(!empty($excelData['yes']))
        <div class="jtable">
            <div data-section="header">
                <h4 style="color: #0077EE">Dados inseridos</h4>
            </div>
            <table>
                <thead>
                    <tr>
                        @foreach(Session::get('requiredFields') as $field)
                            <th>{{{ $field }}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($excelData['yes'] as $values)
                    <tr>
                        @foreach($values as $value)
                            <td>{{{ $value }}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- .jtable -->
    @endif
   
   @if(!empty($excelData['hasEmpty']))

    <div class="jtable">
        <div data-section="header">
            <h4 style="color: #CC181E">Registro com campos em branco</h4>
        </div>

        <table class="wm-table big error">
            <thead>
                <tr>
                    @foreach(Session::get('requiredFields') as $field)
                        <th>{{{ $field }}}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach($excelData['hasEmpty'] as $values)
            <tr>
                @foreach($values as $value)
                    <td>{{{ $value }}}</td>
                @endforeach
            </tr>
            @endforeach
        </table>

    </div>


    <div class="text-right">
        {{ 
            HTML::link(
                Session::get('errorFile'),
                'Baixar registros  não inseridos',
                [
                    'class' => 'btn medium orange',
                    'style' => 'margin: 30px 0;float:left'
                ]

            )
        }}
    </div>

    @endif 

@endif

<div class="modal-alternative">
    <div class="modal-box">
        <div class="modal-header">
            <p>Termo de responsabilidade</p>
            <button type="button" class="close"><i class="halflings halflings-remove"></i></button>
        </div><!-- .modal-header -->
        <div class="modal-content">
            <p>1ª Cláusula - Todos os dados enviados são de responsabilidade do cliente, tal como qualquer incorreção dos dados, serão produzidos sem responsabilidade da Let´scom.</p>
            <p>2ª Cláusula - Todas as fotos enviadas são de responsabilidade do cliente, devendo ser enviadas com a resolução mínima de 300dpi, foto proporcional e com tamanho mínimo de 225px x 300px, juntamente com contraste, brilho e enquadramento corretos. A Let´scom não trata ou altera as fotos.</p>
        </div><!-- .modal-content -->
        <div class="modal-footer">
                <input type="text" id="nome" class="medium total" placeholder="Seu nome completo" />
                    <input type="text" id="cpf" class="medium total" placeholder="Seu CPF" />
                </div>

                <img src="{{ Captcha::img() }}" />
                <input type="text" id="captcha" autocomplete="off" />

                <button type="button" class="btn medium close">
                    <i class="halflings halflings-remove"></i> Cancelar
                </button>
                <button type="button" class="confirm btn medium green">
                    <i class="halflings halflings-ok"></i> Concordar e Enviar
                </button>
            <div class='clearfix'></div>
        </div><!-- .modal-footer -->
    </div><!-- .modal-box -->
</div><!-- .modal-alternative -->

@stop 

@section('scripts') 
{{ HTML::script('js/cliente/enviar_carga.js') }} 
@stop

@section('styles')
{{ 
    HTML::style('css/wm-grid.css'),
    HTML::style('css/cliente/remessas.css')
}}
@append