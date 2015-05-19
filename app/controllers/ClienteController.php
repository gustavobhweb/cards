<?php
use Gregwar\Image\Image;

class ClienteController extends BaseController
{    

    public function getIndex()
    {

        $auth = Auth::user();

        $fichas_tecnicas = FichaTecnica::whereStatus(1)
                                        ->whereClienteId($auth->cliente_id)
                                        ->orderBy('aprovado', 'ASC')
                                        ->get();

        $avisos = Aviso::whereLido(0)
                        ->whereUsuarioId($auth->id)
                        ->orderBy('created_at', 'DESC')
                        ->take(3)
                        ->get();

        $cliente = Cliente::whereId($auth->cliente_id)->first();
        $creditos = $cliente->creditos - $cliente->creditos_utilizados;

        return View::make('cliente.index', get_defined_vars());
    }

    public function anyBaixarCarga()
    {
        $remessas = Remessa::whereIn('status_atual_id', [10, 5, 6, 7]);
        
        if (Request::isMethod('post') && Input::has('remessa_id')) {
            
            $remessaId = (int) Input::get('remessa_id');
            $remessas->where('remessas.id', 'like', "{$remessaId}%");
        }
        
        $remessas = $remessas->paginate(20);
        
        return View::make('cliente.baixar_carga', compact('remessas'));
    }

    public function getAjaxListarRemessas()
    {
        $remessas = Remessa::orderBy('created_at', 'desc')
                            ->take(1000)
                            ->lists('id');

        return Response::json($remessas);
        
    }


    public function getDownloadCargaRemessa($id = null)
    {
        try {
            
            $remessa = Remessa::findOrFail($id);
            
            Excel::create('download', function ($excel) use($remessa)
            {
                
                $excel->setTitle('Remessa');
                
                $excel->sheet('alunos', function ($sheet) use($remessa)
                {
                    
                    $sheet->appendRow([
                        'Nome',
                        'Instituição de Entrega',
                        'Foto',
                        'Codigo W'
                    ]);
                    
                    foreach ($remessa->solicitacoes as $solicitacao) {
                        
                        $sheet->appendRow([
                            $solicitacao->usuario->nome,
                            $solicitacao->instituicao_entrega_id,
                            $solicitacao->foto,
                            $solicitacao->codigo_w
                        ]);
                    }
                    
                    $sheet->row(1, function ($row)
                    {
                        $row->setFontColor('#ffffff')
                            ->setBackground('#00458B');
                    });
                });
                
                $remessa->fill([
                    'baixado' => 1
                ])->save();
            })->download('xlsx');

        } catch (\Exception $e) {

            return Redirect::back()->withErrors([
                'message' => $e->getMessage()
            ]);

        }
    }

    public function anyEntregas()
    {        

        $entregas = Remessa::whereStatusAtualId(5)->paginate(15);  

        return View::make('cliente.entregas', get_defined_vars());
    }


    public function getInfoRemessa($id)
    {

        $remessa = Remessa::find($id);
        
        $solicitacoes = $remessa->solicitacoes()->paginate(15);

        return View::make('cliente.info-remessa', get_defined_vars());
    }


    public function anyRetirada()
    {
        return View::make('cliente.retirada');
    }

    public function postAjaxConfirmarRetirada()
    {
        $solicitacao_id = Input::get('solicitacao_id');
        $status_id = 7;
        
        try {
            DB::transaction(function () use($solicitacao_id, $status_id)
            {
                Solicitacao::whereId($solicitacao_id)->update([
                    'status_atual' => 7
                ]);
                
                SolicitacoesStatus::create([
                    'solicitacao_id' => $solicitacao_id,
                    'status_id'      => $status_id,
                    'usuario_id'     => Auth::user()->id
                ]);
            });
            return Response::json([
                'status' => true,
                'message' => 'Retirada do cartão registrada com sucesso.'
            ]);
        } catch (Exception $e) {
            return Response::json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function postAjaxDataGraph()
    {
        $solicitacoesNum = Solicitacao::select([
                                            'status_atual',
                                            DB::raw('COUNT(id) as count')
                                        ])
                                        ->groupBy('status_atual')
                                        ->get();
        return Response::json($solicitacoesNum);
    }

    public function anyInicial()
    {
        return View::make('cliente.incial');
    }

    public function getRelatorio($status = 'analise')
    {
        $vars['solicitacoes'] = [];
        switch ($status) {
            default:
            case 'analise':
                $vars['solicitacoes'] = Remessa::whereIn('status_atual_id', [1, 2])->solicitacoes()->paginate(15);
                $vars['title'] = 'Solicitações em análise';
                break;
            case 'fabricacao':
                $vars['solicitacoes'] = Remessa::whereIn('status_atual_id', [3, 4, 9, 10])->solicitacoes()->paginate(15);
                $vars['title'] = 'Cartões em fabricação';
                break;
            case 'expedido':
                $vars['solicitacoes'] = Remessa::whereIn('status_atual_id', [5])->solicitacoes()->paginate(15);
                $vars['title'] = 'Cartões que sairam para entrega';
                break;
            case 'disponível':
                $vars['solicitacoes'] = Remessa::whereIn('status_atual_id', [6])->solicitacoes()->paginate(15);
                $vars['title'] = 'Cartões disponíveis para entrega';
                break;
            case 'entregue':
                $vars['solicitacoes'] = Remessa::whereIn('status_atual_id', [7])->solicitacoes()->paginate(15);
                $vars['title'] = 'Cartões entregues';
                break;
            case 'reprovada':
                $vars['solicitacoes'] = Remessa::whereIn('status_atual_id', [8])->solicitacoes()->paginate(15);
                $vars['title'] = 'Solicitações com foto reprovada';
                break;
        }

        return View::make('cliente.relatorio', $vars);
    }

    public function getConferir($remessa_id)
    {

        $solicitacoes = Remessa::findOrFail($remessa_id)->solicitacoes;

        return View::make('cliente.conferir', get_defined_vars());
    }

    public function getPesquisarSolicitacao()
    {   
        $id = Input::get('solicitacao_id');

        $with['remessa'] = function($query){
            
            $query->with('status')->with('statusAtual');
        };

        $solicitacoes = Solicitacao::with($with)
                                    ->where('id', 'LIKE', "%{$id}%")
                                    ->paginate(15);

        return View::make('cliente.pesquisar_solicitacao', get_defined_vars());
    }

    public function anyEnviarRemessaNumero($ficha_tecnica_id)
    {
        try{

            /*
                Se não hover resultado, lança a exceção
            */

            $ficha = FichaTecnica::with('camposVariaveis')
                                ->whereId($ficha_tecnica_id)
                                ->whereAprovado(1)
                                ->wherestatus(1)
                                ->firstOrFail();

            if ($ficha->tem_dados) {
                return Redirect::to('cliente/enviar-remessa/' . $ficha->id);
            }

            if ($ficha->cliente_id != Auth::user()->cliente_id) {
                return Redirect::to('/');
            }

        } catch(Exception $e) {

            /*
                caso precise debugar ou retornar numa página com uma mensagem de erro global
            */

            $errors = ['error' => 'A ficha técnica é inexistente ou não foi aprovada'];

            return Redirect::back()->withErrors($errors);
        }

        if (Request::isMethod('post')) {
            try {
                DB::transaction(function() use($ficha) {
                    $remessa = Remessa::create([
                        'baixado'          => 0,
                        'deletado'         => 0,
                        'usuario_id'       => Auth::user()->id,
                        'ficha_tecnica_id' => $ficha->id,
                        'status_atual_id'  => 1,
                        'qtd'              => Input::get('qtd')
                    ]);

                    $cliente = Auth::user()->cliente();

                    $creditos_disponiveis = $cliente->first()->creditos - $cliente->first()->creditos_utilizados;
                    if (($creditos_disponiveis - Input::get('qtd')) < 0) {
                        throw new Exception('Créditos insuficientes');
                    } else {
                        $cliente->update([
                            'creditos_utilizados' => $cliente->first()->creditos_utilizados + Input::get('qtd')
                        ]);
                    }

                    $remessa->status()->attach(1, [
                        'usuario_id' => Auth::user()->id
                    ]);
                });
                return Redirect::to('cliente/remessas-solicitar-impressao/' . $ficha->id);
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }

        return View::make('cliente.enviar-remessa-numero', get_defined_vars());
    }

    public function anyEnviarRemessa($ficha_tecnica_id)
    {
        try{

            /*
                Se não hover resultado, lança a exceção
            */

            $ficha = FichaTecnica::with('camposVariaveis')
                                ->whereId($ficha_tecnica_id)
                                ->whereAprovado(1)
                                ->wherestatus(1)
                                ->firstOrFail();

            if (!$ficha->tem_dados) {
                return Redirect::to('cliente/enviar-remessa-numero/' . $ficha->id);
            }

            if ($ficha->cliente_id != Auth::user()->cliente_id) {
                return Redirect::to('/');
            }

        } catch(Exception $e) {

            /*
                caso precise debugar ou retornar numa página com uma mensagem de erro global
            */

            $errors = ['error' => 'A ficha técnica é inexistente ou não foi aprovada'];

            return Redirect::back()->withErrors($errors);
        }

        if (Request::isMethod('post') && Input::hasFile('excel')) {
            
            $fileInstance = Input::file('excel');
            
            $extension = strtolower($fileInstance->getClientOriginalExtension());
            
            if (! preg_match('/\.(xls|xlsx|csv)$/i', $fileInstance->getClientOriginalName())) {
                return Redirect::back()->withErrors([
                    'message' => 'A extensão de arquivo é inválido'
                ]);
            }
            
            $tmpFilename = $fileInstance->getRealPath();
            
            try {
                
                Excel::load($tmpFilename, function ($reader) use($ficha) {


                    // campos variáveis

                    $listaCamposVariaveis = $ficha->camposVariaveis->lists('nome', 'id');
                    foreach ($listaCamposVariaveis as $key => $value) {
                        $listaCamposVariaveis[$key] = strtolower($value);
                    }

                    /* campos fixos. Serão inseridos no model Solicitacao */

                    $listaCamposFixos = [$ficha->campo_chave];

                    /*
                        Campos obrigatórios para o upload do Excel, contando com os campos variáveis e fixos
                    */

                    $listaTotalCampos = array_merge($listaCamposVariaveis, $listaCamposFixos);

                    $reader = $reader->select($listaTotalCampos)->all();

                    // define os dados que serão exibidos no cabeçalho da tabela da view

                    Session::flash('requiredFields', $listaTotalCampos);
                    
                    $fields = array_keys($reader->first()->toArray());


                    /*
                        Compara os dados para ver se os campos variáveis batem 
                        com os campos requiridos do excel.
                        Os valores de $listaCamposFixos foram removidas da comparação anteriormente
                    */
                    
                    if ($missingFields = array_diff($listaTotalCampos, $fields)) {
                        
                        throw new \UnexpectedValueException(sprintf(
                            'Alguns campos não foram incluídos na sua planilha.A saber: %s', 
                            implode(', ', $missingFields))
                        );
                    }
                    
                    $data = $reader->toArray();
                    
                    $separated = [
                        'yes'      => [],
                        'hasEmpty' => []
                    ];
                    
                    DB::transaction(function () use($data, $listaCamposVariaveis, $ficha, &$separated) {

                        $auth = Auth::user();

                        $remessa = Remessa::create([
                            'baixado'          => 0,
                            'deletado'         => 0,
                            'usuario_id'       => $auth->id,
                            'ficha_tecnica_id' => $ficha->id,
                            'status_atual_id'  => 1
                        ]);

                        $remessa->status()->attach(1, [
                            'usuario_id' => $auth->id
                        ]);

                        $cliente = $auth->cliente();

                        $creditos_disponiveis = $cliente->first()->creditos - $cliente->first()->creditos_utilizados;
                        if (($creditos_disponiveis - Input::get('qtd')) < 0) {
                            throw new Exception('Créditos insuficientes');
                        } else {
                            $cliente->update([
    	                        'creditos_utilizados' => $cliente->first()->creditos_utilizados + count($data)
    	                    ]);
                        }

                        $solicitacoesCriadas = [];
                        
                        foreach ($data as $userdata) {
                            
                            /* Verifica se contém valores vazios e se não existe o campo foto*/

                            if (in_array(false, $userdata)) {

                                $separated['hasEmpty'][] = $userdata;

                                continue;

                            }

                            $solicitacao = Solicitacao::orderBy('via', 'DESC')
                                                        ->whereCodigo($userdata[$ficha->campo_chave])
                                                        ->first();

                            
                            // Se Existe a solicitação 

                            $via = 1;

                            if ($solicitacao instanceof Solicitacao) {

                                $via += $solicitacao->via;
                            }

                            $foto = isset($userdata['foto']) ? $userdata['foto'] : DB::raw('NULL');

                            $novaSolicitacao = Solicitacao::create([
                                'codigo'        => $userdata[$ficha->campo_chave],
                                'status_atual'  => 1,
                                'deletado'      => 0,
                                'remessa_id'    => $remessa->id,
                                'via'           => $via,
                                // Se a ficha técnica tem foto, o status da carga fica pendente
                                'carga_enviada' => $ficha->tem_foto ? 0 : 1
                            ]);

                            $camposVariaveis = [];

                            array_walk($listaCamposVariaveis, function(&$campo, $campo_id) use(&$camposVariaveis, $userdata)
                            {
                                $camposVariaveis[$campo_id]['valor'] = $userdata[$campo];
                            });

                            $novaSolicitacao->camposVariaveis()->attach($camposVariaveis);

                            $solicitacoesCriadas[] = $novaSolicitacao;

                            $separated['yes'][] = $userdata;

                        }

                        $remessa->solicitacoes()->saveMany($solicitacoesCriadas);

                        if (!$ficha->tem_foto) {
                            $remessa->solicitacoes()->update([
                                'carga_enviada' => 1
                            ]);   
                        }

                        if (count($separated['hasEmpty'])) {

                            $sheetFilename = uniqid();

                            $sheetPath = 'xls/carga_erro';

                            $sheetFullpath = public_path($sheetPath);

                            Excel::create($sheetFilename, function ($excel) use($listaCamposVariaveis, $separated) {

                                $excel->sheet('dados', function ($sheet) use($listaCamposVariaveis, $separated) {

                                    $sheet->appendRow($listaCamposVariaveis);

                                    foreach($separated['hasEmpty'] as $values) {
                                        $sheet->appendRow($values);
                                    }

                                });

                            })->save('xlsx', $sheetFullpath);

	                        Session::flash('errorFile',  "{$sheetPath}/{$sheetFilename}.xlsx");
                        }


                        Session::flash('uploadedData', $separated);

                    });
                    
                    return Redirect::back()->with([
                        'messageSuccess' => 'Os registros foram inseridos com successo',
                        'uploadedData'   => $separated
                    ]);

                }, 'UTF-8');

            } catch (\Exception $e) {
                return Redirect::back()->withInput()->withErrors([
                    'message' => $e->getMessage()
                ]);
            }
        }

        $fichasTecnicas = FichaTecnica::whereStatus(1)->lists('nome', 'id');

        return View::make('cliente.enviar_carga', get_defined_vars());
    }

    public function postAjaxUploadZip($id)
    {   
        $file = Input::file('zip');

        $rules = [
            'zip' => 'required|mimes:zip'
        ];

        $messages = [
            'mimes' => "Extensão de arquivo inválida"
        ];

        $validation = Validator::make(Input::all(), $rules, $messages);


        if ($validation->passes()) {

            try{

                $zip = Input::file('zip')->getRealPath();

                $zipObject =  new ZipArchive;

                if (! $zipObject->open($zip)) {

                    throw new RunTimeException('Não foi possível abrir o arquivo enviado');
                }

                $path = base_path("secure/{$id}");  


                if (! File::isDirectory($path)) {

                    File::makeDirectory($path, 0755);
                }

                // Diretório de destino ao concluir a verificação de segurança

                $pathDestiny = public_path("solicitacoes/{$id}");

                if (! File::isDirectory($pathDestiny)) {

                    File::makeDirectory($pathDestiny, 0755);
                }

                $zipObject->extractTo($path);

                // Itera com os arquivos do diretório 

                $files = new FileSystemIterator($path);


                $deletedFiles = $includedFiles = [];

                foreach ($files as $file) {

                    $data = [
                        'mime' => mime_content_type($file->getRealPath())
                    ];

                    $rules = ['mime' => 'in:image/png,image/jpeg,image/bmp'];

                    if (Validator::make($data, $rules)->fails()) {

                        $deletedFiles[] = $file->getRealPath();

                    } else {
                        

                        $uncovertedFilename = $file->getRealPath();
                     
                        // Novo nome da imagem que será convertida para o formato JPG e salvo na pasta
                        // File::name retorna o nome da imagem sem a extensão

                        $filenameWithoutExtension = File::name($uncovertedFilename);

                        $convertedImageName = $pathDestiny . '/' . Str::finish($filenameWithoutExtension, '.jpg');

                        // Abre a imagem e salva ela em JPG. 100 é referente à qualidade da imagem salva

                        Image::open($uncovertedFilename)->save($convertedImageName, 'jpg', 100);


                        // O arquivo sem extensão equivale ao número do "codigo" da tabela "solicitacoes"

                        $solicitacoesChaves[] = $filenameWithoutExtension;

                        // Deleta o arquivo não convertido (o original)
                        File::delete($uncovertedFilename);
                    }
                }

                File::delete($deletedFiles);

                // Se não existir nenhum arquivo incluído, lança a exceção

                if (! count($solicitacoesChaves)) {

                    throw new UnexpectedValueException('Nenhuma foto da remessa foi enviada');
                }

                $remessa = Remessa::find($id);

                $numeroSolicitacoes = $remessa->solicitacoes->count();

                $numeroSolicitacoesAtualizadas = Remessa::whereId($id)
                        ->whereStatusAtualId(1)
                        ->first()
                        ->solicitacoes()
                        ->whereIn('codigo', $solicitacoesChaves)
                        ->update([
                            'carga_enviada' => 1
                        ]);

                $numeroFotosFaltando = Remessa::whereId($id)->whereStatusAtualId(1)
                                        ->first()
                                        ->solicitacoes()
                                        ->whereCargaEnviada(0)
                                        ->count();

            } catch (Exception $e) {

                return Response::json([
                    'error'     => $e->getMessage(),
                    'directory' => $path,
                ]);
            }

            return Response::json([
                'error'          => false, 
                'deleted_files'  => $deletedFiles,
                'included_files' => $solicitacoesChaves,
                'row_count'      => $numeroSolicitacoesAtualizadas,
                'missing_photos' => $numeroFotosFaltando
            ]);

        } else {

            return Response::json(['error' => $validation->messages()->first() ]);    
        }
    }


    public function getAjaxSolicitacoesPendentes($id)
    {

        $solicitacoes = Remessa::whereStatusAtualId(1)
                                ->whereId($id)
                                ->firstOrFail()
                                ->solicitacoes()
                                ->whereCargaEnviada(0)
                                ->get();


        return Response::json($solicitacoes);
    }

    public function getDownloadModeloExcel($id)
    {

        try {

            $ficha = FichaTecnica::findOrFail($id);
            
            $campos = $ficha->camposVariaveis->lists('nome');

            $camposFixos = [$ficha->campo_chave];
        
            $campos = array_merge($camposFixos, $campos);

            Excel::create('modelo', function ($excel) use($campos, $ficha) {

                $excel->setTitle('Modelo ' . $ficha->nome);

                $excel->sheet('colaboradores', function ($sheet) use($campos)
                {
                    $sheet->appendRow($campos);

                    $sheet->row(1, function ($row)
                    {
                        $row->setFontColor('#ffffff')
                            ->setBackground('#00458B');
                    });
                });

            })->download('xlsx');

        } catch (\Exception $e) {
            return Redirect::back()->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function postAjaxSolicitarImpressao()
    {
        $remessa_id = Input::get('remessa_id');
        $auth = Auth::user();
        $next_status = 3;
        try {
            DB::transaction(function() use($remessa_id, $auth, $next_status){
                Remessa::find($remessa_id)
                        ->status()
                        ->attach($next_status, [
                            'usuario_id' => $auth->id
                        ]);
                Remessa::whereId($remessa_id)
                        ->update([
                            'status_atual_id' => $next_status
                        ]);
            });
            return Response::json(['status' => true]);
        } catch(Exception $ex) {
            return Response::json([
                'status' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function getLinhaTempoRemessa($id)
    {
        $with['solicitacoes'] = function($query)
        {
            $query->with('camposVariaveis');
        };

        $with['FichaTecnica'] = function($query)
        {
            $query->with('camposVariaveis');
        };

        $remessa = Remessa::with('status')
                        ->with($with)
                        ->findOrFail($id);

        $meusStatus = $remessa->status->lists('id');

        $status = Status::where('na_regua', '=', 1)->get();

        return View::make('cliente.linha_tempo_remessa', get_defined_vars());
    }

    public function getRemessas()
    {   
        $remessas = Remessa::with('solicitacoes')
                            ->orderBy('id', 'DESC')
                            ->paginate(15);

        
        return View::make('cliente.remessas', get_defined_vars());
    }

    public function getRemessasEnviarFoto($ficha_tecnica_id)
    {
        set_time_limit(0);
        $ficha = FichaTecnica::whereId($ficha_tecnica_id)->first();

        if ($ficha->cliente_id != Auth::user()->cliente_id || !($ficha instanceof FichaTecnica) || !$ficha->tem_foto) {
            return Redirect::to('/');
        }

        $remessas = Remessa::with('solicitacoes')
        ->whereFichaTecnicaId($ficha_tecnica_id)
        ->whereStatusAtualId(1)
        ->whereHas('solicitacoes', function($query)
        {
            $query->whereCargaEnviada(0);
        })
        ->paginate(15);

        $callbackHasPhoto = function($solicitacao)
        {
            return $solicitacao->carga_enviada == 1;
        };

        return View::make('cliente.remessas_enviar_foto', get_defined_vars());
    }

    public function getRemessasSolicitarImpressao($ficha_tecnica_id)
    {
        $ficha = FichaTecnica::whereId($ficha_tecnica_id)->first();
        if ($ficha->cliente_id != Auth::user()->cliente_id || !($ficha instanceof FichaTecnica)) {
            return Redirect::to('/');
        }
        $remessas = Remessa::with('solicitacoes')
                            ->whereFichaTecnicaId($ficha_tecnica_id)
                            ->whereStatusAtualId(1)
                            ->whereDoesntHave('solicitacoes', function($query)
                            {
                                $query->whereCargaEnviada(0);
                            })->paginate(15);

        return View::make('cliente.remessas_solicitar_impressao', get_defined_vars());
    }

    public function getRemessasHistorico()
    {
        $auth = Auth::user();

        $remessas = Remessa::with('solicitacoes')
                            ->where('status_atual_id', '<>', 1)
                            ->whereHas('fichaTecnica', function($query) use($auth)
                            {
                                $query->whereClienteId($auth->cliente_id);
                            });

        if (Input::has('search')) {
            $remessas = $remessas->whereId(Input::get('search'));
        }                            

        $remessas = $remessas->paginate(15);

        return View::make('cliente.remessas_historico', get_defined_vars());
    }

    public function anyRelatorios()
    {
        $auth = Auth::user();

    	$remessas = Remessa::with('solicitacoes')
                            ->with('fichaTecnica')
                            ->where('status_atual_id', '<>', 1)
                            ->whereHas('fichaTecnica', function($query) use($auth)
                            {
                                $query->whereClienteId($auth->cliente_id);
                            });

    	if (Input::has('search')) {
	    	$remessas->whereId(Input::get('search'));
	    }

    	$remessas = $remessas->paginate(15);

    	return View::make('cliente.relatorios', get_defined_vars());
    }

    public function getDownloadRelatorioRemessaPdf($remessa_id)
    {
    	$remessa = Remessa::with('solicitacoes')->findOrFail($remessa_id);
        $solicitacoes = $remessa->solicitacoes;
            
        return PDF::loadView('elements.producao.pdf_relatorio_remessa', get_defined_vars())
                    ->setPaper('a4')
                    ->download();
    }

    public function getDownloadRelatorioRemessaExcel($remessa_id)
    {
    	try { 

            $with['solicitacoes'] = function ($query) {
                $query->with('camposVariaveis');
            };

            $remessa = Remessa::with($with)
                                ->with('fichaTecnica.camposVariaveis')
                                ->findOrFail($remessa_id);

            $downloadName = sprintf('remessa_%04s', $remessa_id);

            Excel::create($downloadName, function ($excel) use($remessa) {

                $excel->setTitle('Remessa');

                $excel->sheet('dados', function ($sheet) use($remessa) {

                    $camposCabecalho = $remessa->fichaTecnica->camposVariaveis->lists('nome');

                    $camposFixos = [
                        $remessa->fichaTecnica->campo_chave,
                        'via',
                    ];

                    if ($remessa->fichaTecnica->tem_foto) {

                        $camposFixos[] = 'foto';
                    }

                    $camposCabecalho = array_merge($camposFixos, $camposCabecalho);

                    $sheet->appendRow($camposCabecalho);

                    foreach ($remessa->solicitacoes as $solicitacao) {

                        $camposValores = [
                            $solicitacao->codigo,
                            $solicitacao->via
                        ];

                        if ($remessa->fichaTecnica->tem_foto) {

                            $camposValores[] = 'foto';
                        }

                        foreach($solicitacao->camposVariaveis as $campo) {

                            $camposValores[] = $campo->pivot->valor; 

                        }


                        $sheet->appendRow($camposValores);

                    }

                    $sheet->row(1, function ($row) {

                        $row->setFontColor('#ffffff')
                            ->setBackground('#00458B');
                    });
                });

            })->download('xlsx');

        } catch (\Exception $e) {

            return Response::json([
                'error' => $e->getMessage(),
                'line'  => $e->getLine()
            ]);
        }
    }

    public function getPesquisarSolicitacoes()
    {
    	$fichas_tecnicas = FichaTecnica::whereStatus(1)
    									->whereAprovado(1)
                                        ->whereClienteId(Auth::user()->cliente_id)
                                        ->orderBy('aprovado', 'DESC')
                                        ->with('solicitacoes')
                                        ->get();
                                        
    	return View::make('cliente.pesquisar-solicitacoes', get_defined_vars());
    }

    public function getPesquisarSolicitacoesModelo($ficha_tecnica_id)
    {

    	$callbackSearch = function($query){

    		if (Input::has('search')) {

                $search = filter_var(Input::get('search'));

    			$query->whereCodigo($search);
    		}
    	};


    	$ficha = FichaTecnica::findOrFail($ficha_tecnica_id);

    	$solicitacoes = Solicitacao::whereHas('remessa', function($query) use($ficha) {
    		$query->whereFichaTecnicaId($ficha->id);
    	})
    	->where($callbackSearch)
    	->paginate(10);
		

    	return View::make('cliente.pesquisar-solicitacoes-modelo', get_defined_vars());
    }


    public function anyAprovarFichaTecnica($id)
    {
        $ficha = FichaTecnica::with('camposVariaveis', 'tiposCartao', 'tipoEntrega')
                              ->whereId($id)
                              ->whereStatus(1)
                              ->firstOrFail();


        $message = new MessageBag;

        if (Request::isMethod('post')) {

            $ficha->fill(['aprovado' => 1])->save();

            $message->add('message', 'Ficha técnica aprovada com sucesso.');

        }

        return View::make('cliente.aprovar_ficha_tecnica', get_defined_vars());
    }

} 
