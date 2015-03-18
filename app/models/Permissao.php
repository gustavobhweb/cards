<?php

class Permissao extends Eloquent
{
	protected $table = 'permissoes';

	protected $fillable = [
        'name',
        'action',
        'type',
        'url',
        'glyphicon',
        'in_menu'
    ];


    public function niveis()
    {
    	return $this->belongsToMany('Nivel', 'niveis_permissoes');
    }

}