<?php

class TipoCartaoProtocolo extends ELoquent
{

    protected $table = 'tipo_cartao_protocolo';

    protected $fillable = [
        'tipo_cartao_id',
        'protocolo_id'
    ];
}