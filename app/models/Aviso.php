<?php

class Aviso extends Eloquent
{

    protected $fillable = [
        'assunto',
        'remetente',
        'mensagem',
        'lido',
        'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo('Usuario', 'usuario_id');
    }
}