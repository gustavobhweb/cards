<?php

class FinanceiroController extends BaseController
{

    public function anyIndex()
    {

        $remessas = Remessa::with('fichaTecnica')
        					->with('solicitacoes')
        					->whereStatusAtualId(2)
        					->paginate(15);


        return View::make('financeiro.index', compact('remessas'));
    }

    public function getInfoRemessa($id)
    {
  
        $remessa = Remessa::with('camposVariaveis')->findOrFail($id);

        $solicitacoes = $remessa->solicitacoes()
        						->with('camposVariaveis')
        						->paginate(15);


        return View::make('financeiro.info-remessa', get_defined_vars());
    }

    public function postAjaxLiberar()
    {
        $id = Input::get('remessa_id');
        
        $status = 3;
        
        try {

            DB::transaction(function () use($id, $status) {
                
                $auth = Auth::user();

                $remessa = Remessa::find($id);

				$remessa->fill(['status_atual_id' => $status])->save();


				$remessa->status()->attach($status, ['usuario_id' => $auth->id]);
			});

			return Response::json([
				'status'  => 'true',
				'message' => 'Alterado com sucesso.',
				'error'   => false
			]);

		} catch(\Exception $e) {

			return Response::json([
				'status'  => 'false',
				'message' => $e->getMessage(),
				'error' => $e->getMessage()
			]);
		}
	}

	public function anyHistorico()
	{

		$remessas = Remessa::whereIn('status_atual_id', [2, 3])->paginate(15);


		return View::make('financeiro.historico', compact('remessas'));
	}
    
}