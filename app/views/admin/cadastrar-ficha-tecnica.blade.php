@extends('layouts.default')

@section('title') Nova ficha técnica @stop

@section('topbar')
<h4><i class="halflings halflings-list-alt"></i> Cadastrar ficha técnica</h4>
<a href="{{ URL::previous() }}" class="btn medium right">
    <i class="halflings halflings-remove"></i> Cancelar
</a>
@stop

@section('content')

{{ Form::open(['class' => 'wm-form', 'files' => true, 'id' => 'form-cadastro']) }}
    
    @include('admin.elements.form-ficha-tecnica')

    <!-- <div id="box-submit">

        <a href="{{ URL::previous() }}" type="button" class="btn medium">
            <i class="halflings halflings-remove"></i> Cancelar
        </a>
        
        <button type="submit" class="btn medium green" id="btn-send">
            <i class="halflings halflings-ok"></i> Salvar
        </button>
    </div> -->

{{ Form::close() }}

@include('elements.common-alert')

@stop

@section('scripts')
{{ HTML::script('js/admin/cadastrar-ficha-tecnica.js') }}
@append

