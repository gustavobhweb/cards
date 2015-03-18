<?php

class ServiceController extends BaseController
{
    public function __construct()
    {
        if (Auth::user()->username !== 'newtonuserapi') {
            return App::abort(403);
        }
    }

    public function getGet($remessa_id)
    {
        $solicitacoes = Remessa::with('solicitacoes')->findOrFail($remessa_id)->solicitacoes;

        return Response::json($solicitacoes);
    }

    public function postSet()
    {
        $alunos = Input::get('alunos');

        foreach ($alunos as $aluno) {
            unset($aluno['instituicao']);
            $aluno['nivel_id'] = 1;
            Usuario::create($aluno);
        }
    }
}