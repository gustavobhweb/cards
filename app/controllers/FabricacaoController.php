<?php

class FabricacaoController extends BaseController
{

    public function getIndex()
    {
        $select = [
            'remessas.id',
            'remessas.created_at as data_criacao',
            'responsavel.nome'
        ];
        
        $vars['remessas'] = Remessa::select($select)->join('solicitacoes_remessa AS sr', 'remessas.id', '=', 'sr.remessa_id')
            ->join('solicitacoes AS s', 's.id', '=', 'sr.solicitacao_id')
            ->join('usuarios AS u', 'u.id', '=', 's.usuario_id')
            ->join('usuarios AS responsavel', 'responsavel.id', '=', 'remessas.usuario_id')
            ->where('s.status_atual', '=', 11)
            ->groupBy('remessas.id')
            ->paginate(15);
        
        $vars['currentPage'] = (Input::get('page')) ? Input::get('page') : 1;
        
        return View::make('fabricacao.index', $vars);
    }
}