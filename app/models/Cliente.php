<?php

class Cliente extends Eloquent
{
	protected $table = 'clientes';

	protected $fillable = [
		'nome',
		'email',
		'telefone',
		'status',
		'pessoa_contato',
		'cnpj'
	];

	public function fichas()
	{
		return $this->hasMany('FichaTecnica')->whereStatus(1);
	}

	public function usuarios()
	{
		return $this->hasMany('Usuario');
	}
}