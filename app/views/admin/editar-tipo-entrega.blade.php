@extends('layouts.default')


@section('title') 

    @unless($tipoEntrega)
        Editar Tipo de entrega
    @else
        Cadastrar Tipo de Entrega
    @endif
    
@stop


@section('content')

<section class="wm-form">
    {{ Form::model($tipoEntrega) }}

    <div class="clearfix">
        {{ Form::label('nome', 'Nome', ['class' => 'label black']) }}

        <div class="wm-grid wm-grid-8">
        {{ Form::text('nome', Input::old('nome'), ['placeholder' => 'nome']) }}
        </div>
        <div class="wm-grid wm-grid-4">
        {{ Form::submit('Salvar', ['class' => 'wm-btn wm-btn-blue']) }}
        </div>
    </div>

    {{ Form::close() }}

    <div>
        {{ $errors->first('nome', '<div class="j-alert-error">:message</div>') }}

        {{ $message->first('message', '<div class="j-alert-error">:message</div>') }}
    </div>


</section>

@stop

@section('styles')
{{ HTML::style('css/wm-grid.css') }}
@append