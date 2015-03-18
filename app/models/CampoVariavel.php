<?php


class CampoVariavel extends Eloquent
{
	protected $table = 'campos_variaveis';


	protected $fillable = ['nome'];

	public function setUpdatedAtAttribute(){}
}