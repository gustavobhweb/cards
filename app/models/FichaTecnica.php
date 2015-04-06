<?php

class FichaTecnica extends Eloquent
{

    protected $table = 'fichas_tecnicas';

    protected $fillable = [
        'nome', 
        'foto_frente',
        'foto_verso',
        'tem_furo',
        'tipo_entrega_id',
        'aprovado',
        'campo_chave',
        'cliente_id',
        'tipo_solicitacao_id',
        'posicionamento',
        'tem_dados',
        'tem_foto'
    ];

    protected $appends = [
        'foto_frente_link',
        'foto_verso_link'
    ];


    public function tiposCartao()
    {
        return $this->belongsToMany('TipoCartao', 'fichas_tecnicas_tipos_cartao');
    }

    public function tipoEntrega()
    {
        return $this->belongsTo('TipoEntrega', 'tipo_entrega_id');
    }

    public function setUpdatedAtAttribute(){}

    public function camposVariaveis()
    {
        return $this->belongsToMany('CampoVariavel', 'fichas_tecnicas_campos_variaveis');
    }

    public function solicitacoes()
    {
        return $this->hasManyThrough('Solicitacao', 'Remessa');
    }

    public function cliente()
    {
        return $this->belongsTo('Cliente', 'cliente_id');
    }

    public function getFotoFrenteLinkAttribute()
    {
        if ($this->attributes['foto_frente'] === NULL) {

            return URL::to("img/no-image.png");
        }

        return URL::to("fichas_tecnicas/{$this->attributes['id']}/{$this->attributes['foto_frente']}");
    }


    public function getFotoVersoLinkAttribute()
    {
        if ($this->attributes['foto_verso'] === NULL) {

            return URL::to("img/no-image.png");
        }

        return URL::to("fichas_tecnicas/{$this->attributes['id']}/{$this->attributes['foto_verso']}");
    }


    public function getFotoVersoRealpathAttribute()
    {
        if ($this->attributes['foto_verso'] === NULL) {
            
            return null;
        }

        $id = $this->attributes['id'];

        $foto = $this->attributes['foto_verso'];

        return public_path("fichas_tecnicas/{$id}/{$foto}");
    }

    public function getFotoFrenteRealpathAttribute()
    {
        if ($this->attributes['foto_frente'] === NULL) {

            return null;
        }

        $id = $this->attributes['id'];

        $foto = $this->attributes['foto_frente'];

        return public_path("fichas_tecnicas/{$id}/{$foto}");
    }

}
