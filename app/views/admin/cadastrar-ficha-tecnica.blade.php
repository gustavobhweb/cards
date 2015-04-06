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

{{ Form::close() }}

@include('elements.common-alert')

@stop

@section('scripts')
{{ HTML::script('js/admin/cadastrar-ficha-tecnica.js') }}
@append