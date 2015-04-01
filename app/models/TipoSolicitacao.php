<?php

class TipoSolicitacao extends Eloquent
{
	protected $table = 'tipos_solicitacoes';

	protected $fillable = [
		'nome',
		'status'
	];
}