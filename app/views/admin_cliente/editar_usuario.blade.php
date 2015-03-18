@extends('layouts.default')


@section('title') Criar Usuário @stop


@section('content')

{{ Form::model($usuario, ['id' => 'form-cadastrar-usuario', 'autocomplete' => 'off']) }}

<div class="conteudo-form">

    {{ Form::open() }}

    <fieldset>
        <h5>Dados do usuário:</h5>

        {{ Session::get('message') }}

        <div class="wm-input-container per-2 icon-status">

            {{ Form::label('nome', 'Nome') }}

            {{ 
                Form::text(
                    'nome',
                    Input::old('nome'), 
                    [ 
                        'placeholder' => 'Nome Completo',
                        'required' => 'required',
                        'pattern'   => "([\s\u00c0-\u01ffa-zA-Z'\-])+"
                    ] 
                )
            }}

            <div>{{ $errors->first('nome', '<div class="j-alert-error">:message</div>') }}</div>
        </div>


        <div class="wm-input-container per-2 icon-status">

            {{ Form::label('username', 'Login') }}

            {{ 
                Form::text(
                    'username',
                    Input::old('username'), 
                    [ 
                        'placeholder' => 'meu_login',
                        'title' => 'e-mail não confere',
                        'pattern'   => '[0-9a-zA-Z_@\.]+',
                        'required'  => 'required'
                    ] 
                )
            }}

            <div>{{ $errors->first('username', '<div class="j-alert-error">:message</div>') }}</div>
        </div>

        <div class="clearfix"></div>

        <div class="wm-input-container per-2 icon-status input-email-format">
            <label>E-mail:</label> 

            {{ 
                Form::email(
                    'email', 
                    Input::old('email'),
                    [
                        'placeholder' => 'nome@dominio.com',
                        'id' => 'email',
                        'required' => 'required'
                    ]
                ) 
            }}

            <div class="glif">
                <div class="glyphicon glifEmail glyphicon-ok"></div>
            </div>

            <div>{{ $errors->first('email', '<div class="j-alert-error">:message</div>') }}</div>
        </div>

        <div class="wm-input-container per-2 icon-status input-email-format">
            <label>Confirmação e-mail:</label> 

            {{ 
                Form::email(
                    'confirmaEmail',
                    Input::old('confirmaEmail'), 
                    [ 
                        'placeholder' => 'nome@dominio.com',
                        'id' => 'confirmaEmail',
                        'required' => 'required'
                    ] 
                )
            }}

            <div class="glif">
                <div class="glyphicon glifEmail glyphicon-ok"></div>
            </div>

        </div>


        <div class="clearfix"></div>


        <div class="wm-input-container per-2 icon-status">
            <label>Senha:</label> 

            {{ 
                Form::password(
                    'password', 
                    [
                        'placeholder' => '******',
                        'required' => 'required',
                        'id'       => 'senha'
                    ]
                ) 
            }}

            <div class="glif">
                <div class="glyphicon glifEmail glyphicon-ok"></div>
            </div>

            <div>{{ $errors->first('senha', '<div class="j-alert-error">:message</div>') }}</div>
        </div> 



        <div class="wm-input-container per-2 icon-status">
            <label>Confirmação Senha:</label> 

            {{ 
                Form::password(
                    'confirmaSenha', 
                    [
                        'placeholder' => '******',
                        'required' => 'required',
                        'id'    => 'confirmaSenha'
                    ]
                ) 
            }}

            <div class="glif">
                <div class="glyphicon glifEmail glyphicon-ok"></div>
            </div>
        </div> 


        <div class='clearfix'></div>

        <div class="pull-right wm-input-container" >
        {{ Form::submit('Salvar', ['class' => 'btn-conf-iza', 'id' => 'submit']) }}
        <a href="{{ URL::to('admin-cliente/editar-usuario') }}"><button type="button" class="btn-cancel-iza">Cancelar</button></a>
        </div>

        
    </fieldset>
    {{ Form::close() }}

</div>

{{ Form::close() }}

@stop


@section('styles') 
{{
    HTML::style('css/admin_cliente/index.css'),
    HTML::style('css/wm-modal.css')
}} 
@stop 

@section('scripts') 
{{
    HTML::script('js/admin_cliente/index.js'),
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/jQueryObjectForm.js')
}}
@stop