@extends('layouts.default')

@section('title') Criar Usuário @stop

@section('content')


<section class="wm-form">  

    <fieldset>

    {{ Form::model($usuario, ['autocomplete' => 'off', 'id' => 'form-meus-dados']) }}

        @if(Session::get('success'))
            <div class="j-alert-error">
                Seus dados foram salvos com sucesso
            </div>
        @endif

        {{ Session::get('message') }}

        <div class="wm-input-container">

            {{ Form::label('nome', 'Nome Completo', ['class' => 'label black']) }}

            {{ 
                Form::text(
                    'nome',
                    Input::old('nome'), 
                    [ 
                        'placeholder' => 'Nome Completo',
                        'required'    => 'required'
                    ] 
                )
            }}

            <div>{{ $errors->first('nome', '<div class="j-alert-error">:message</div>') }}</div>
        </div>

        <div class="wm-input-container">

            {{ Form::label('username', 'Login', ['class' => 'label black']) }}

            {{ 
                Form::text(
                    'username',
                    Input::old('username'), 
                    [ 
                        'placeholder' => 'meu_login',
                        'title'       => 'Os caracteres devem ser letras, numeros, _, - e @',
                        'pattern'     => '[\w\d@_-]+',
                        'required'    => 'required',
                    ] 
                )
            }}

            <div>{{ $errors->first('username', '<div class="j-alert-error">:message</div>') }}</div>
        </div>

        <div class="clearfix"></div>

        <div class="input-container">   

            <h4 class="text-muted">Alterar senha</h4>

            <div class="input-container">
                <input name="show_senha" type="radio" class="password-show" value="1" />
                <span>Sim</span>

                <input type="radio" name="show_senha" class="password-show" value="0">
                <span>Não</span>
            </div>

        </div>

        <div class="clearfix" id="box-password" style="display: {{ $errors->has('password') ? 'block' : 'none' }}">

            <div class="wm-input-container wm-grid wm-grid-6">

                {{ Form::label('senha', 'Senha', ['class' => 'label black']) }}

                {{ 
                    Form::password(
                        'password', 
                        [
                            'placeholder' => '******',
                            'id'       => 'senha'
                        ]
                    ) 
                }}

               
            </div> 

            <div class="wm-input-container wm-grid wm-grid-6">

                {{ Form::label('confirmaSenha', 'Confirma Senha', ['class' => 'label black']) }}

                {{ 
                    Form::password(
                        'confirmaSenha', 
                        [
                            'placeholder' => '******',
                            'id'          => 'confirmaSenha'
                        ]
                    ) 
                }}

            </div>

            <div class="clearfix">
            {{ 
                $errors->first(
                    'password',
                    '<div class="j-alert-error">:message</div>'
                )
            }}
            </div>
        </div>

        <div class='clearfix'></div>

        <div class="text-right" style="padding:0.625em;">
        {{ 
            Form::submit('Salvar', ['class' => 'btn-style', 'id' => 'submit']) 
        }}
        </div>

    {{ Form::close() }}

    </fieldset>

</section>

@stop


@section('styles') 
{{
    HTML::style('css/enviar-foto.css'), 
    HTML::style('css/wm-modal.css'),
    HTML::style('css/wm-grid.css'),
    HTML::style('css/auth/meus_dados.css')
}}
@stop 



@section('scripts')
{{ 
    HTML::script('js/auth/meus_dados.js'),
    HTML::script('js/jQueryObjectForm.js')
}}
@stop


