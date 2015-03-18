@extends('layouts.default')

@section('topbar') 
    <h4><i class="halflings halflings-cog"></i> Configurações da minha conta</h4>
@stop

@section('content')


<section class="wm-form" style="width:60%">  

    <fieldset>

    {{ Form::model($usuario, ['autocomplete' => 'off', 'id' => 'form-meus-dados']) }}

        @if(Session::get('success'))
            <div class="alert success"><i class="halflings halflings-ok"></i> Seus dados foram salvos com sucesso</div>
        @endif

        {{ Session::get('message') }}

        <div class="fc-section">
            <div class="title">
                <span>1</span>
                <h4>Nome completo</h4>
            </div>

            <div class="content-section" style="margin:10px 0 0 0">
                {{ 
                    Form::text(
                        'nome',
                        Input::old('nome'), 
                        [ 
                            'placeholder' => 'Nome Completo',
                            'required'    => 'required',
                            'class'       => 'medium total'
                        ] 
                    )
                }}

                {{ $errors->first('nome', '<div class="alert warning">:message</div>') }}
            </div>
        </div><!-- .fc-section -->

        <div class="fc-section">
            <div class="title">
                <span>2</span>
                <h4>Nome de usuário</h4>
            </div>

            <div class="content-section" style="margin:10px 0 0 0">
                {{ 
                    Form::text(
                        'username',
                        Input::old('username'), 
                        [ 
                            'placeholder' => 'meu_login',
                            'title'       => 'Os caracteres devem ser letras, numeros, _, - e @',
                            'pattern'     => '[\w\d@_-]+',
                            'required'    => 'required',
                            'class'       => 'medium total'
                        ] 
                    )
                }}

                {{ $errors->first('username', '<div class="alert warning">:message</div>') }}
            </div>
        </div><!-- .fc-section -->

        <div class="fc-section">
            <div class="title">
                <span>3</span>
                <h4>Alterar a senha</h4>
            </div>

            <div class="content-section" style="margin:10px 0 0 0">
                <div class="input-container">
                    <input id="show_senha" name="show_senha" type="radio" class="password-show" value="1" />
                    <label for="show_senha">Sim</label>

                    <input id="hide_senha" type="radio" name="show_senha" class="password-show" value="0">
                    <label for="hide_senha">Não</label>
                </div>
            </div>
        </div><!-- .fc-section -->

        <div class="fc-section" id="box-password" style="display: {{ $errors->has('password') ? 'block' : 'none' }}">

            {{ Form::label('senha', 'Senha', ['class' => 'label black']) }}

            {{ 
                Form::password(
                    'password', 
                    [
                        'placeholder' => '******',
                        'id'       => 'senha',
                        'class' => 'medium'
                    ]
                ) 
            }}

            {{ Form::label('confirmaSenha', 'Confirma Senha', ['class' => 'label black']) }}

            {{ 
                Form::password(
                    'confirmaSenha', 
                    [
                        'placeholder' => '******',
                        'id'          => 'confirmaSenha',
                        'class' => 'medium'
                    ]
                ) 
            }}

            {{ 
                $errors->first(
                    'password',
                    '<div class="alert warning">:message</div>'
                )
            }}
        </div><!-- .fc-section -->

        <button type="submit" class="btn medium green right" id="submit" style="margin: 10px 0 0 0">
            <i class="halflings halflings-ok"></i> Salvar
        </button>

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


