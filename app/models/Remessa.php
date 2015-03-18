<?php

class Remessa extends Eloquent
{

    protected $fillable = [
        'baixado',
        'deletado',
        'ficha_tecnica_id',
        'status_atual_id',
        'usuario_id',
    ];

    public function solicitacoes()
    {
        return $this->hasMany('Solicitacao');
    }

    public function camposVariaveis()
    {
        return $this->fichaTecnica->camposVariaveis();
    }

    public function fichaTecnica()
    {
        return $this->belongsTo('FichaTecnica', 'ficha_tecnica_id');
    }

    public function usuario()
    {
        return $this->belongsTo('Usuario');
    }

    public function protocolo()
    {
        return $this->hasOne('Protocolo');
    }

    public function statusAtual()
    {
        return $this->belongsTo('Status', 'status_atual_id');
    }


    public function status()
    {
        return $this->belongsToMany('Status', 'remessas_status')->withPivot('created_at', 'usuario_id');
    }

    public static function gerarProtocoloPdf($id)
    {
        $remessa = Remessa::whereId($id)
                            ->with( 'usuario', 'fichaTecnica', 'solicitacoes')
                            ->first();
        
        return PDF::loadView('elements.producao.pdf_protocolo', compact('remessa'))->setPaper('a4')->stream();
    }


}


