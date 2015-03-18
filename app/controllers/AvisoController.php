<?php

class AvisoController extends BaseController
{

	public function getIndex()
	{
		$auth = Auth::user();

		$avisos = Aviso::whereUsuarioId($auth->id)
				->orderBy('lido', 'ASC')
				->paginate(30);

		return View::make('aviso.index', get_defined_vars());				

	}


	public function getLer($id)
	{
		$auth = Auth::user();


		$aviso = Aviso::whereId($id)
					->whereUsuarioId($auth->id)
					->firstOrFail();


		if ($aviso->lido === 0) {

			$aviso->fill(['lido' => 1])->save();
		}

		return View::make('aviso.ler', get_defined_vars());
	}

	public function criar(){}


	public function editar($id){}
} 