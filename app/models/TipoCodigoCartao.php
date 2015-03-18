<?php

class TipoCodigoCartao extends Eloquent
{

    protected $table = 'tipos_codigo_cartao';

    protected $fillable = [
        'nome'
    ];

    public function fichasTecnicas()
    {
        return $this->hasMany('FichasTecnicas');
    }
}

