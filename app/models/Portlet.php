<?php

class Portlet extends Eloquent
{

	protected $table = 'portlets';

    protected $fillable = [
        'conteudo',
        'ordem',
        'coluna_id'
    ];

    public function coluna()
    {
    	return $this->belongsTo('Coluna', 'coluna_id');
    }
}