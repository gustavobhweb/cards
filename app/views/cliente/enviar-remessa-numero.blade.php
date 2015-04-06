@extends('layouts.default')

@section('topbar')
<h4><i class="halflings halflings-glyph-briefcase"></i> Enviar carga</h4>
@stop

@section('content')

    @include('elements.cliente.submenu-remessas')

    @if(isset($error))
    <div class="alert error">{{ $error }}</div>
    @endif

    <div style="margin: 10px 0 0 0;float:left;width: 100%"> 
    {{ Form::open() }}
    	{{ 
    		Form::text(
    			'qtd',
                null,
                [
                    'placeholder'  => 'Digite aqui o qtd. de solicitações',
                    'class'        => 'medium total',
                    'required'     => 'required',
                    'id'           => 'qtd'
                ]
    		) 
    	}}
 
    	<button type="submit" class="btn medium green right" style="margin: 10px 0 0 0">
    		Enviar remessa
    		<i class="halflings halflings-arrow-right"></i>
    	</button>
    {{ Form::close() }}
    </div>

@stop