@extends('layouts.default')

@section('title') Editar ficha técnica @stop

@section('topbar')
<h4><i class="halflings halflings-list-alt"></i> Editar a ficha técnica <b>{{ $ficha->nome }}</b></h4>
<a href="{{ URL::previous() }}" class="btn medium right">
    <i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')

{{ Form::model($ficha, ['class' => 'wm-form', 'data-id' => $ficha->id, 'id' => 'form-cadastro']) }}

    @include('admin.elements.form-ficha-tecnica')

    <!-- <div id="box-submit">
        <a href="{{ URL::previous() }}" type="button" class="btn medium">
            <i class="halflings halflings-remove"></i> Cancelar
        </a>

        <button type="submit" class="btn medium green" id="btn-send" style="margin-left:5px">
            <i class="halflings halflings-ok"></i> Salvar
        </button>
    </div> -->

{{ Form::close() }}

@include('elements.common-alert')

@stop

@section('scripts')
{{ HTML::script('js/admin/editar-ficha-tecnica.js') }}

@append