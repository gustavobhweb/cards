<?php

class TipoCartao extends Eloquent
{

    protected $table = 'tipos_cartao';


    protected $fillable = ['nome', 'status'];


    public $timestamps = false;
}