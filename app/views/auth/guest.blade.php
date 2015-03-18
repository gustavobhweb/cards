@extends('layouts.login')

@section('scripts')
{{ HTML::script('js/guest.js') }}
@append

@section('content')

<div class="login">

    <div class="left">
        <img src="{{ URL::to('img/security.png') }}" />
    </div><!-- .left -->

    <div class="right">
        <h1>Acesso ao sistema</h1>
        {{ Form::open(['id' => 'form-login', 'autocomplete' => 'off']) }}
            <p class="error">{{ $errors->first('login') }}</p>
            {{ 
                Form::text(
                    'username',
                    Input::old('username'), 
                    [
                        'id'       => 'txt-input-login', 
                        'required' => 'required',
                        'class'    => 'input input-email',
                        'tabindex' => '1',
                        'placeholder' => 'Login'
                    ]
                ) 
            }}

            {{ 
                Form::password(
                    'password',
                    [
                        'id'       => 'text-input-password',
                        'required' => 'required',
                        'class'    => 'input input-password',
                        'tabindex' => '2',
                        'placeholder' => 'Senha'
                    ]
                ) 
            }}

            {{ Form::submit('Entrar', ['class' => 'btn-login']) }}
            <a href="#">Esqueci minha senha</a>
        {{ Form::close() }}
    </div><!-- .right -->

</div><!-- .login -->

<div class="data-info">
    <h2><?=str_replace('-feira', '', utf8_encode(strftime("%A, %d de %B")));?></h2>
    <h1><?=date('H:i')?></h1>
</div><!-- .data-info -->

@stop
