<?php

class Cliente extends Eloquent
{
	protected $table = 'clientes';

	protected $fillable = [
		'nome',
		'email',
		'telefone',
		'status'
	];

	public function fichas()
	{
		return $this->hasMany('FichaTecnica');
	}
}