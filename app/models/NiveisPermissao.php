<?php

class NiveisPermissao extends Eloquent
{
	protected $table = "niveis_permissoes";
	public $timestamps = false;
	
	protected $fillable = [
		'nivel_id',
		'permissao_id'
	];

	public function permissao()
	{
		return $this->belongsTo('Permissao');
	}
}