<?php

class Status extends Eloquent
{

    protected $table = 'status';

    /**
     *
     * @var array
     *
     */
    protected $fillable = [
        'titulo'
    ];


    public function setUpdatedAtAttribute(){}

    public function usuario()
    {
        return $this->belongsTo('Usuario');
    }
}