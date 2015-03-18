<?php

class Solicitacao extends Eloquent
{

    protected $table = 'solicitacoes';

    protected $fillable = [
        'codigo',
        'conferido',
        'deletado',
        'foto',
        'remessa_id',
        'carga_enviada',
        'via',
    ];

    protected $appends = [
        'foto_link'
    ];


    public function getFotoLinkAttribute()
    {

        $filename = 'img/no-image.png';

        if ($this->attributes['carga_enviada'] !== null && file_exists($filename)) {

            $filename = "solicitacoes/{$this->attributes['remessa_id']}/{$this->attributes['codigo']}.jpg";
        }

        return $filename;
        
    }

    public function getFotoFullPathAttribute()
    {


        $remessa_id = $this->attributes['remessa_id'];

        $codigo = $this->attributes['codigo'];

        $filename = public_path("solicitacoes/{$remessa_id}/{$codigo}.jpg");

        if (file_exists($filename)) {

            return $filename;
        }


        return false;
    }

    public function remessa()
    {
        return $this->belongsTo('Remessa', 'remessa_id');
    }

    public function camposVariaveis()
    {
        return $this->belongsToMany('CampoVariavel', 'solicitacoes_campos_variaveis')->withPivot('valor');
    }




}