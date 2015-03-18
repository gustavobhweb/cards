<?php

class Nivel extends Eloquent
{
    protected $table = 'niveis';

    protected $fillable = [
    	'titulo',
        'pagina_inicial_permissao_id'
    ];

    public function permissoes()
    {
    	return $this->belongsToMany('Permissao', 'niveis_permissoes');
    }

    public function paginaInicial()
    {
    	return $this->belongsTo('Permissao', 'pagina_inicial_permissao_id');
    }

    public function usuarios()
    {
        return $this->hasMany('Usuario', 'nivel_id');
    }
}
