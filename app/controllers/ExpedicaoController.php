<?php

class ExpedicaoController extends BaseController
{

    public function getIndex()
    {
        $vars['entregas'] = Remessa::whereStatusAtualId(5)
                                ->paginate(15);

        return View::make('expedicao.index', $vars);
    }

    public function getInfoRemessa($id)
    {
        $remessa_id = zero_fill($id, 4);

        $remessa = Remessa::whereId($id)->first();
        $solicitacoes = Remessa::findOrFail($id)->solicitacoes()->paginate(15);

        return View::make('expedicao.info-remessa', get_defined_vars());
    }

    public function postAjaxSairParaEntrega()
    {
        $id = Input::get('remessa');
        $status = 6;

        try {

            DB::transaction(function() use($id, $status) {
            
                $auth = Auth::user();
                
                $remessa = Remessa::findOrFail($id);

                $remessa->fill(['status_atual_id' => $status])->save();

                $remessa->status()->attach($status, ['usuario_id' => $auth->id]);

            });

            return Response::json([
                'status' => true,
                'message' => 'Alterado com sucesso.'
            ]);

        } catch(\Exception $e) {
            return Response::json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function anyHistorico()
    {
        $vars['entregas'] = Remessa::whereIn('status_atual_id', [5, 6, 7])->paginate(15);

        return View::make('expedicao.historico', $vars);
    }

}