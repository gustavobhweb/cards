<?php

class TipoEntrega extends Eloquent
{
	public $timestamps = false;
	
    protected $table = 'tipos_entrega';

    protected $fillable = ['nome', 'status'];
}