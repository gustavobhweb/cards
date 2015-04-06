<div class="form-total-fc">
    
    <div class="fc-section">
        <div class="title">
            <span>1</span>
            <h4>Cliente</h4>
        </div>
        <div class="content-section" style="margin:10px 0 0 0">
        <select autofocus name="cliente_id" class="medium total">
            <option>Selecione o cliente</option>
            @foreach($clientes as $cliente)
            <option {{ (isset($ficha) && $cliente->id == $ficha->cliente_id) ? 'selected' : '' }} value="{{ $cliente->id }}">{{{  $cliente->nome }}}</option>
            @endforeach
        </select>
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section">
        <div class="title">
            <span>2</span>
            <h4>Nome do modelo</h4>
        </div>
        <div class="content-section" style="margin:10px 0 0 0">
            {{ 
                Form::text(
                    'nome',
                    null,
                    [
                        'placeholder'  => 'Digite aqui o nome deste modelo',
                        'class'        => 'medium total',
                        'required'     => 'required',
                        'id'           => 'nome'
                    ]
                ) 
            }}
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section">
        <div class="title">
            <span>3</span>
            <h4>Tipo</h4>
        </div>

        <div class="content-section" style="margin: 10px 0 0 0">
            @foreach($tiposSolicitacoes as $tipoSolicitacao)
            {{ 
                Form::radio(
                    'tipo_solicitacao_id',
                    $tipoSolicitacao->id,
                    false,
                    ['id' => 'tipo_solicitacao_' . $tipoSolicitacao->id, 'required' => 'required']
                )
            }}
            <label for="tipo_solicitacao_{{ $tipoSolicitacao->id }}">{{{ $tipoSolicitacao->nome }}}</label>
            @endforeach
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section" id="envio-fotos">
        <div class='title'>
            <span>4</span>
            <h4>Envio de fotos do modelo</h4>
        </div><!-- .title -->
        
        <div class="content-section">

            @if(isset($ficha) && $ficha->foto_frente)
            <div class="fotos-ficha">
                {{ Form::file('foto_frente', ['style' => 'display:none']) }}
                {{
                    Form::button(
                        'Selecionar foto frente...',
                        [
                            'class' => 'btn large',
                            'id'    => 'trigger-foto-frente'
                        ]
                    );
                }}
                <a href="#" class="ignition" id="disable-image-front">&times;</a>
                <img src="{{ URL::to($ficha->foto_frente_link) }}" id="image-front" class="preview-ficha-image" />
            </div>
            @else
            <div class="fotos-ficha">
                {{ Form::file('foto_frente', ['style' => 'display:none']) }}
                {{
                    Form::button(
                        'Selecionar foto frente...',
                        [
                            'class' => 'btn large',
                            'id'    => 'trigger-foto-frente'
                        ]
                    );
                }}
                <a href="#" class="ignition" id="disable-image-front">&times;</a>
                <img id="image-front" class="preview-ficha-image" />
            </div>
            @endif

            @if(isset($ficha) && $ficha->foto_verso)
            <div class="fotos-ficha">
                {{ Form::file('foto_verso', ['style' => 'display:none']) }}
                {{
                    Form::button(
                        'Selecionar foto verso...',
                        [
                            'class' => 'btn large',
                            'id'    => 'trigger-foto-verso'
                        ]
                    );

                }}
                <a href="#" class="ignition" id="disable-image-back">&times;</a>
                <img src="{{ URL::to($ficha->foto_verso_link) }}" id="image-back" class="preview-ficha-image" />
            </div>
            @else
            <div class="fotos-ficha">
                {{ Form::file('foto_verso', ['style' => 'display:none']) }}
                {{
                    Form::button(
                        'Selecionar foto verso...',
                        [
                            'class' => 'btn large',
                            'id'    => 'trigger-foto-verso'
                        ]
                    );

                }}
                <a href="#" class="ignition" id="disable-image-back">&times;</a>
                <img id="image-back" class="preview-ficha-image" />
            </div>
            @endif

        </div><!-- .content-section -->
    </div><!-- .fc-section -->

    <div class="fc-section">
        <div class='title'>
            <span>5</span>
            <h4>Tecnologia</h4>
            <a 
                href="{{ URL::to('admin/tipos-cartao') }}" 
                class="btn blue btn-gerenciar-tipos-cartao">
                <i class="halflings halflings-cog"></i>
                Gerenciar
            </a>
        </div><!-- .title -->

        <div class="content-section" style="margin: 10px 0 0 0">
            @foreach($tiposCartoes as $tipoCartao)
                    
                <div class='' style='float:left;width:50%;margin: 3px 0 2px 0'>
                    {{
                        Form::checkbox(
                            "tipo_cartao_id[{$tipoCartao->id}]",
                           $tipoCartao->id,
                            isset($ficha) && in_array($tipoCartao->id, $ficha->tiposCartao->lists('id')),
                            ['id' => "tipo-entrega-{$tipoCartao->id}"]
                        )

                    }}

                    {{ Form::label("tipo-entrega-{$tipoCartao->id}", $tipoCartao->nome) }}
                </div>

            @endforeach
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section">

        <div class="title">
            <span>6</span>
            <h4>Tem furo?</h4>
        </div>
        
        <div class="content-section" style="margin:10px 0 0 0"> 
            {{ 
                Form::radio(
                    'tem_furo',
                    1,
                    false,
                    ['id' => 'tem-furo-sim', 'required' => 'required']
                )
            }}
            <label for="tem-furo-sim">Sim</label>

            {{ 
                Form::radio(
                    'tem_furo',
                    0,
                    false,
                    ['id' => 'tem-furo-nao', 'required' => 'required']
                )
            }}
            <label for="tem-furo-nao">Não</label>
        </div>
    </div><!-- .fc-section -->
	
	<div class="fc-section">
        <div class="title">
            <span>7</span>
            <h4>Posicionamento</h4>
        </div>
        
        <div class="content-section" style="margin:10px 0 0 0">
            {{ 
                Form::radio(
                    'posicionamento',
                    'h',
                    false,
                    ['id' => 'posicionamento-h', 'required' => 'required']
                )
            }}
            <label for="posicionamento-h">Horizontal</label>
            {{ 
    			Form::radio(
    				'posicionamento',
    				'v',
    				false,
    				['id' => 'posicionamento-v', 'required' => 'required']
    			)
    		}}
    		<label for="posicionamento-v">Vertical</label>
        </div>
    </div><!-- .fc-section -->
    
    <div class="fc-section">
        <div class="content-section">
            <p>Tem carga de fotos?</p><br>
            {{ 
                Form::radio(
                    'tem_foto',
                    1,
                    false,
                    ['id' => 'tem-foto-s', 'required' => 'required']
                )
            }}
            <label for="tem-foto-s">Sim</label>
            {{ 
                Form::radio(
                    'tem_foto',
                    0,  
                    false,
                    ['id' => 'tem-foto-n', 'required' => 'required']
                )
            }}
            <label for="tem-foto-n">Não</label>
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section">
        <div class="content-section">
            <p>Tem dados variáveis?</p><br>
            {{ 
                Form::radio(
                    'tem_dados',
                    1,
                    false,
                    ['id' => 'tem-dados-s', 'required' => 'required']
                )
            }}
            <label for="tem-dados-s">Sim</label>
            {{ 
                Form::radio(
                    'tem_dados',
                    0,
                    false,
                    ['id' => 'tem-dados-n', 'required' => 'required']
                )
            }}
            <label for="tem-dados-n">Não</label>
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section dados-section">
        <div class="title">
            <span>8</span>
            <h4>Campo chave</h4>
        </div>

        <div class="content-section">
        {{ 
            Form::text(
                'campo_chave',
                null,
                [
                    'required' => 'required',
                    'class' => 'medium total campo-chave',
                    'placeholder' => 'Digite aqui o nome do campo chave',
                    'style' => 'margin: 10px 0 0 0'
                ]
            ) 
        }}
        </div>
    </div><!-- .fc-section -->

    <div class="fc-section dados-section">
        <div class="title">
            <span>9</span>
            <h4>Campos variáveis</h4>
        </div>

        <div class="content-section" style="margin: 10px 0 0 0">
            <div class="input-group">
                <input type="text" id="input-campo" class="medium" placeholder="Nome do campo variável" />
                <button type="button" class="btn medium blue add-field">
                    <i class="halflings halflings-plus"></i> Adicionar
                </button>
            </div>
            <div class="jtable fields" {{ (isset($ficha) && $ficha->camposVariaveis->count()) ? 'style="display:block"' : ''}} >
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($ficha) && $ficha->camposVariaveis->count())
                        @foreach($ficha->camposVariaveis as $campo)
                        <tr class="box-campo-variavel">
                            <td class="nome-campo-variavel" data-nome="{{{ $campo->nome }}}">
                            {{{ $campo->nome }}}
                            </td>
                            <td class="center">
                                <button type="button" class="btn medium red del-field">
                                    <i class="halflings halflings-trash"></i>
                                </button>
                                <input type="hidden" class="input-campo" value="{{{ $campo->nome }}}"/>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div><!-- .jtable -->
        </div>
    </div>
	
	<div class="fc-section">
        <div class="title">
            <span>10</span>
            <h4>Tipo de entrega</h4>
            <a 
                href="{{ URL::to('admin/tipos-entrega') }}" 
                class="btn blue btn-gerenciar-tipos-cartao">
                <i class="halflings halflings-cog"></i>
                Gerenciar
            </a>
        </div>
        
        <div class="content-section" style="margin:10px 0 0 0">
        {{ 
            Form::select(
                'tipo_entrega_id',
                ['' => '(Selecionar)'] + $tiposEntrega,
                null,
                [
                    'required' => 'required',
                    'class' => 'medium total'
                ]
            ) 
        }}
        </div>
    </div><!-- .fc-section -->

    <div id="box-submit">
        <a href="{{ URL::previous() }}" type="button" class="btn medium">
            <i class="halflings halflings-remove"></i> Cancelar
        </a>

        <button type="submit" class="btn medium green" id="btn-send" style="margin-left:5px">
            <i class="halflings halflings-ok"></i> Salvar
        </button>
    </div>

</div><!-- .form-total-fc -->

<script type="text/template" id="tpl-campos-variaveis">
    <tr class="box-campo-variavel">

        <td class="nome-campo-variavel" data-nome="<%- nome %>" ><%- nome %></td>
        <td class="center">
            <button type="button" class="btn medium red del-field">
                <i class="halflings halflings-trash"></i>
            </button>
            
            <input type="hidden" value="<%- nome %>" class="input-campo" />

        </td>
    </tr>
</script>

{{-- Scripts e Estilos comuns entra as views "editar" e "cadastrar ficha técninca" --}}

@section('scripts')
{{  
    HTML::script('js/jquery-ui.js'),
    HTML::script('js/jQueryObjectForm.js'),
    HTML::script('js/underscore-min.js'),
    HTML::script('js/admin/ficha-tecnica-cadastrar-editar.js')
}}
@append


@section('styles')
{{ 
    HTML::style('css/jtable.css'),
    HTML::style('css/jquery-ui.css'),
    HTML::style('css/wm-grid.css'), 
    HTML::style('css/admin/cadastrar-ficha-tecnica.css')
}}
@append