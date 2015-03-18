<?php

class Protocolo extends Eloquent
{

    protected $fillable = [
        'tem_furacao',
        'remessa_id',
        'tem_cardvantagens',
        'tipo_entrega_id',
        'usuario_id'
    ];

    public function remessa()
    {
        return $this->belongsTo('Remessa');
    }

    public function usuario()
    {
        return $this->belongsTo('Usuario');
    }
}