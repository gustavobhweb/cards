<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuario extends Eloquent implements UserInterface, RemindableInterface
{
    
    use UserTrait, RemindableTrait;

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'bm',
        'cargo',
        'foto',
        'funcao',
        'nivel_id',
        'nome',
        'nome_completo',
        'password',
        'registro_geral',
        'username',
        'cliente_id',
        'primeiro_acesso'
    ];

    public function nivel()
    {
        return $this->belongsTo('Nivel', 'nivel_id');
    }

    public function creditos()
    {
        return $this->hasMany('Credito', 'usuario_id');
    }

    public function ultimaSolicitacao()
    {
        return $this->hasOne('Solicitacao', 'usuario_id')->orderBy('created_at', 'desc');
    }

    public function cliente()
    {
        return $this->belongsTo('Cliente', 'cliente_id');
    }

}
