<?php

class ProducaoController extends BaseController
{


    public function getFichasTecnicas()
    {

        $fichasTecnicas = FichaTecnica::whereStatus(1)->get();

        return View::make('producao.fichas_tecnicas', get_defined_vars());
    }


    public function getGerenciarFotos($id)
    {

        $fichaTecnica = FichaTecnica::whereStatus(1)
                                    ->whereId($id)
                                    ->firstOrFail();

        $solicitacoes = $fichaTecnica->solicitacoes;

        return View::make('producao/gerenciar_fotos', get_defined_vars());
    }

    public function postGerenciarFotos()
    {

        $action = Input::get('action');

        if (Input::has('solicitacoes')) {

            $solicitacoes = (array) Input::get('solicitacoes');

            try {

                switch ($action) {
                    case 'aprovar':
                        return $this->aprovarFotos($solicitacoes);
                        break;
                    case 'reprovar':
                        return $this->reprovarFotos($solicitacoes);
                        break;
                    default:
                        throw new \InvalidArgumentException('Parâmetro inválido');
                        break;
                }

            } catch (\Exception $e) {

                return Redirect::back()->withErrors([
                    'message' => $e->getMessage()
                ]);
            }
        }

        return Redirect::back()->withErrors([
            'message' => 'Nenhuma soliciação foi marcada para criar a remessa'
        ]);
    }

    /**
     * Quando a foto é aprovada, o status é alterado para "9 - Financeiro"
     */
    protected function aprovarFotos(array $solicitacoes)
    {
        try {

            return DB::transaction(function () use($solicitacoes) {

                $auth = Auth::user();

                Solicitacao::whereIn('id', $solicitacoes)->update(['status_atual' => 9]);

                foreach ($solicitacoes as $solicitacao) {

                    SolicitacoesStatus::create([
                        'solicitacao_id' => $solicitacao,
                        'status_id'      => 9,
                        'usuario_id'     => $auth->id,

                    ]);

                }

                return Redirect::back()
                                ->withMessage(sprintf('%s remessa(s) foram cadastradas com sucesso', count($solicitacoes)));
            });
        } catch (\Exception $e) {

            return Redirect::back()
                            ->withMessage($e->getMessage());
        }
    }

    protected function reprovarFotos(array $solicitacoes)
    {

        try {

            return DB::transaction(function () use($solicitacoes) {

                $auth = Auth::user();

                Solicitacao::whereIn('id', $solicitacoes)->update(['status_atual' => 8]);

                foreach ($solicitacoes as $solicitacao) {

                    $solicitacoesStatus = SolicitacoesStatus::create([

                        'solicitacao_id' => $solicitacao,
                        'status_id'      => 8,
                        'usuario_id'     => $auth->id,
                        'observacao'     => Input::get('motivo')
                    ]);

                }

                return Response::json(sprintf('%s solicitações foram reprovadas', count($solicitacoes)));

            });
        } catch (\Exception $e) {

            return Response::json($e->getMessage());

        }
    }

    public function getAjaxListarRemessas()
    {
        if (Request::ajax()) {
            return array_map(function ($value)
            {
                return zero_fill($value, 4);
            }, Remessa::orderBy('created_at', 'desc')->take(1000)->lists('id'));
        }
    }

    public function anyBaixarCarga()
    {
        $remessas = Remessa::with('protocolo')
                            ->with('usuario')
                            ->with('solicitacoes')
                            ->whereStatusAtualId(3)
                            ->paginate(15);

        return View::make('producao.baixar_carga', compact('remessas'));
    }

    public function getDownloadExcelRemessa($id)
    {
        try { 

            $with['solicitacoes'] = function ($query) {
                $query->with('camposVariaveis');
            };

            $remessa = Remessa::with($with)
                                ->with('fichaTecnica')
                                ->findOrFail($id);

            $downloadName = sprintf('remessa_%04s', $id);

            Excel::create($downloadName, function ($excel) use($remessa) {

                $excel->setTitle('Remessa');
                $excel->sheet('dados', function ($sheet) use($remessa) {

                    $camposCabecalho = $remessa->fichaTecnica->camposVariaveis->lists('nome');


                    $camposFixos = [
                        $remessa->fichaTecnica->campo_chave
                    ];

                    $camposCabecalho = array_merge($camposFixos, $camposCabecalho);

                    $sheet->appendRow($camposCabecalho);

                    foreach ($remessa->solicitacoes as $solicitacao) {

                        $camposValores = [
                            $solicitacao->codigo
                        ];

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

                $remessa->fill([
                    'baixado' => 1

                ])->save();

            })->download('xlsx');

        } catch (\Exception $e) {

            return Response::json([
                'error' => $e->getMessage(),
                'line'  => $e->getLine()
            ]);
        }
    }

    public function getDownloadFotosRemessa($id)
    {
        $solicitacoes = Remessa::findOrFail($id)->solicitacoes;

        try {

            $zip = new \ZipArchive();

            $zipName = tempnam(sys_get_temp_dir(), 'remessa_');

            if ($zip->open($zipName, ZipArchive::CREATE) === true) {

                $filesWithProblems = [];

                $remessaId = zero_fill($id, 4);

                foreach ($solicitacoes as $solicitacao) {

                    $filename = $solicitacao->foto_fullpath;

                    $filenameInZip = "{$id}/{$solicitacao->codigo}.jpg";

                    if (File::exists($filename)) {

                        $zip->addFile($filename, $filenameInZip);

                    } else {

                        $filesWithProblems[] = $filename;

                    }
                }

                if (($count = count($filesWithProblems)) > 0) {

                    $errorMessage = "{$count} foto não foram encontrados no sistema:\n" . implode(PHP_EOL, $filesWithProblems);

                    $zip->addFromString('erros.txt', $errorMessage);
                }

                $zip->close();

                return Response::download($zipName, "remessa_{$remessaId}.zip");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getListaRemessasConferencia()
    {

        $remessas = Remessa::with('solicitacoes')
                            ->with('statusAtual')
                            ->whereStatusAtualId(4)
                            ->orderBy('remessas.id', 'DESC')
                            ->paginate(15);

        return View::make(
            'producao.lista_remessas_conferencia',
            compact('remessas')
        );
    }

    public function getConferirRemessa($id = null)
    {
        $remessa = Remessa::whereIn('status_atual_id', [4, 5])->firstOrFail();
        $solicitacoes = $remessa->solicitacoes;

        return View::make('producao.conferir_remessa', compact('solicitacoes', 'remessa'));
    }

    public function postConferirRemessa($id)
    {
        $allowedExtensions = [
            'xls',
            'xlsx'
        ];

        try {

            if (! Input::hasFile('excel')) {
                throw new \UnexpectedValueException('Nenhum arquivo foi selecionado');
            }

            $file = Input::file('excel');

            $tmpFilename = $file->getRealPath();

            if (! in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                throw new \InvalidArgumentException('Extensão de arquivo é inválida');
            }

            Excel::load($tmpFilename, function ($reader) use(&$missingInserts, $id)
            {
                $lines = $reader->all();

                $key = key($reader->first()->toArray());


                DB::transaction(function() use($key, $lines, $id){

                    $with['solicitacoes'] = function($query) use($key) {

                        $with['camposVariaveis'] = function($query) use($key) {
                            $query->whereNome($key);
                        };

                        $query->with($with)
                               ->whereHas('camposVariaveis', $with['camposVariaveis']);
                    };

                    $remessa = Remessa::with($with)->findOrFail($id);

                    $solicitacoes = $remessa->solicitacoes;

                    $linesArray = $lines->lists($key);

                    $solicitacoes = $solicitacoes->filter(function($solicitacao) use($linesArray, $key){

                        // dados já filtrados no primeiro "with"

                        $valor = $solicitacao->camposVariaveis->first()->pivot->valor;

                        return in_array($valor, $linesArray);
                    });

                    if ($solicitacoes->count()) {

                        Solicitacao::whereIn('id', $solicitacoes->lists('id'))->update([
                            'conferido' => 1
                        ]);

                        $conferidas = Solicitacao::whereConferido(1)->count();
                        $totalSolicitacoes = Remessa::whereId($id)->first()->solicitacoes()->count();
                        $conferenciaCompleta = !($totalSolicitacoes - $conferidas);
                        
                        $next_status_id = 5;

                        if ($conferenciaCompleta) {
                            $remessa->fill([
                                'status_atual_id' => $next_status_id
                            ])->save();

                            $remessa->status()->attach($next_status_id, [
                                'usuario_id' => Auth::user()->id
                            ]);
                        }
                        
                    } else {
                        throw new \Exception('Nenhum dado foi conferido.');
                    }

                });

                // DB::transaction(function () use($lines, &$missingInserts)
                // {

                //     $status = 10;

                //     foreach ($lines as $line) {

                //         $solicitacoes = DB::table('solicitacoes AS s')->select([
                //             's.id'
                //         ])
                //             ->join('usuarios AS u', 'u.id', '=', 's.usuario_id')
                //             ->where('u.matricula', '=', $line['matricula'])
                //             ->where('s.status_atual', '=', 4);

                //         if ($result = $solicitacoes->first()) {

                //             Solicitacao::whereId($result->id)->update([
                //                 'status_atual' => $status,
                //                 'codigo_w' => $line['codigo_w']
                //             ]);

                //             SolicitacoesStatus::create([
                //                 'solicitacao_id' => $result->id,
                //                 'status_id'      => $status,
                //                 'usuario_id'     => Auth::user()->id
                //             ]);
                //         } else {

                //             $missingInserts[] = $line['matricula'];
                //         }
                //     }
                // });

                if (($countLines = count($missingInserts)) > 0) {
                    throw new \Exception("Os dados foram conferidos, porém {$countLines} linhas não foram processadas");
                }
            });

            return Redirect::back()->with([
                'successMessage' => 'Os dados foram conferidos com sucesso'
            ]);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors([
                'message' => (string) $e
            ]);
        }
    }

    public function postAjaxEnviarParaConferencia()
    {
        try {

            if (! Input::has('remessa_id')) {
                throw new \UnexpectedValueException('O parâmetro "remessa_id" é obrigatório para essa requisição');
            }

            $remessa_id = Input::get('remessa_id');
            $next_status_id = 5;

            
            return DB::transaction(function() use($remessa_id, $next_status_id) {
                $remessa = Remessa::whereId($remessa_id);
                
                $remessa->update(['status_atual_id' => $next_status_id]);

                $remessa->first()->status()->attach($next_status_id, [
                    'usuario_id' => Auth::user()->id
                ]);

                return Response::json([
                    'message' => 'A remessa foi conferida com sucesso',
                    'error'   => false
                ]);
            });
            
        } catch (\Exception $e) {

            return Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function postAjaxReprovarFoto()
    {
        // try {

        //     $reprovacao = $this->reprovarFotos([
        //         Input::get('solicitacao_id')
        //     ]);


        //     if ($reprovacao) {
        //         return Response::json([
        //             'status' => true,
        //             'message' => $reprovacao
        //         ]);
        //     }
        // } catch (\Exception $e) {

        //     return Response::json([
        //         'status' => false,
        //         'message' => $e->getMessage()
        //     ]);
        // }
    }

    public function getAjaxVerificarImpressaoProtocolo()
    {
        try {

            $id = filter_var(Input::get('remessa_id'));

            $protocolo = Protocolo::whereRemessaId($id);

            $auth = Auth::user();

            if (! $protocolo->count()) {

                $protocolo = Protocolo::create([
                    'usuario_id' => $auth->id,
                    'remessa_id' => $id
                ]);
            } else {

                if ($protocolo->pluck('usuario_id') != $auth->id) {
                    throw new Exception('Você não pode trabalhar nessa remessa');
                }
            }

            return Response::json([
                'error' => false
            ]);
        } catch (\Exception $e) {

            return Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function getImprimirProtocolo($id)
    {
        $protocolo = Protocolo::whereRemessaId($id)->whereUsuarioId(Auth::user()->id)->count();
        
        if ($protocolo) {
            return Remessa::gerarProtocoloPdf($id);
        } else {
            return App::abort(403, 'Acesso não autorizado');
        }
    }

    public function getImprimirProtocoloRemessa($id)
    {
        return Remessa::gerarProtocoloPdf($id);
    }

    public function postAjaxRotacionar()
    {
        $im = imagecreatefrompng(Input::get('imgsrc'));
        $angle = -1 * Input::get('angle');

        $dest = imagerotate($im, $angle, 0xFFFFFF);

        $index = Str::length(URL::to('/'));
        $dir = substr(Input::get('imgsrc'), $index);
        imagepng($dest, public_path($dir));
        return Response::json([
            'status' => 1,
            'message' => 'Sucesso.'
        ]);
    }

    public function postAjaxCrop()
    {
        $im = imagecreatefrompng(Input::get('image'));

        $index = Str::length(URL::to('/'));
        $dir = substr(Input::get('image'), $index);

        $indexQr = strpos($dir, "?");
        $dir = substr($dir, 0, $indexQr);

        $x = Input::get('x');
        $y = Input::get('y');
        $w = Input::get('w');
        $h = Input::get('h');

        list($width, $height) = getimagesize(Input::get('image'));
        $nh = 215;
        $nw = ($nh * $width) / $height;

        $widthVar = 358;
        $heightVar = 478;
        $dest = imagecreatetruecolor($widthVar, $heightVar);

        imagecopyresampled($dest, $im, 0, 0, $x, $y, $widthVar, $heightVar, $w, $h);
        imagepng($dest, public_path($dir));
        imagedestroy($dest);

        return Response::json([
            'status' => true,
            'message' => 'Cadastrado com sucesso.',
            'image' => URL::to($dir . '?' . time())
        ]);
    }

    public function getGraphView()
    {
        $vars['solicitacoes'] = Solicitacao::all();

        return View::make('producao.graph_view', $vars);
    }


    public function getProtocolos()
    {
        $protocolos = Protocolo::whereUsuarioId(Auth::user()->id)
                                ->paginate(15);

        return View::make('producao.protocolos', get_defined_vars());
    }

    public function getPesquisarRemessa()
    {

        if (Input::has('remessa_id')) {

            try {
                $id = Input::get('remessa_id');
                $solicitacoes = Remessa::findOrFail($id)->solicitacoes;
            } catch (Exception $e) {
               $message = 'Nenhum resultado encontrado';
               return Redirect::action('ProducaoController@getPesquisarRemessa')
                                ->withErrors(compact('message'));
            }
        }

        return View::make('producao.pesquisar_remessa', get_defined_vars());
    }

    public function anyPesquisarRemessas()
    {

        $callbackSearch = function($query) 
        {

            if (Request::isMethod('post')) {

                $typeSearch     = Input::get('txt-type-search');

                $remessaSearch  = Input::get('txt-search');

                $remessaSearch1 = Input::get('txt-search1');

                if ($typeSearch == 1) {

                    $query->where('remessas.id', 'LIKE', $remessaSearch);

                } else {

                    $query->whereBetween('remessas.id', [$remessaSearch, $remessaSearch1]);
                }

            }
            
        };


        $remessas = Remessa::with('solicitacoes', 'usuario')
                            ->where($callbackSearch)
                            ->paginate(15);
                
        return View::make('producao.pesquisar_remessas', get_defined_vars());
    }

    public function getPdfRelatorioRemessa($id)
    {
        $remessa = Remessa::with('solicitacoes')->findOrFail($id);
        $solicitacoes = $remessa->solicitacoes;
    
        return PDF::loadView('elements.producao.pdf_relatorio_remessa', get_defined_vars())
                    ->setPaper('a4')
                    ->stream();
    }

    public function anyEnviarCarga()
    {
        if (Request::isMethod('post') && Input::hasFile('excel')) {
            
            $allowedExtensions = [
                'xls',
                'xlsx',
                'csv'
            ];
            
            $fileInstance = Input::file('excel');
            
            $extension = strtolower($fileInstance->getClientOriginalExtension());
            
            if (! in_array($extension, $allowedExtensions)) {
                return Redirect::back()->withErrors([
                    'message' => 'A extensão de arquivo é inválido'
                ]);
            }
            
            $tmpFilename = $fileInstance->getRealPath();
            
            try {
                
                Excel::load($tmpFilename, function ($reader) {
                    
                    $requiredFields = [
                        'cpf',
                        'curso',
                        'instituicao',
                        'matricula',
                        'nome',
                        'protocolo',
                        'turno',
                    ];
                    
                    $reader = $reader->select($requiredFields)->all();
                    
                    $fields = array_keys($reader->first()->toArray());
                    
                    if ($missingFields = array_diff($requiredFields, $fields)) {
                        
                        throw new \UnexpectedValueException(sprintf(
                            'Alguns campos não foram incluídos no documento.A saber: %s', implode(', ', $missingFields)
                        ));
                    }
                    
                    $data = $reader->toArray();
                    
                    $separated = [
                        'not' => [],
                        'yes' => [],
                        'hasEmpty' => []
                    ];
                    
                    DB::transaction(function () use($data, &$separated) {
                        
                        foreach ($data as $userData) {
                            
                            if (in_array(false, $userData)) {
                                $separated['hasEmpty'][] = $userData;
                                continue;
                            }
                            
                            $query = Usuario::where('matricula', '=', $userData['matricula']);
                            
                            if ($query->count()) {
                                $separated['not'][] = $userData;
                                $user = $query->first();
                            } else {
                                $userData['nivel_id'] = 1;
                                $user = Usuario::create($userData + [
                                    'username' => DB::raw('UUID()')
                                ]);
                                $separated['yes'][] = $userData;
                            }
                            
                            Credito::create([
                                'usuario_id' => $user->id,
                                'status' => '0'
                            ]);
                        }
                    });
                    
                    return Redirect::back()->with([
                        'messageSuccess' => 'Os registros foram inseridos com successo',
                        'uploadedData'   => $separated
                    ]);

                }, 'UTF-8');

            } catch (\Exception $e) {
                return Redirect::back()->withErrors([
                    'message' => $e->getMessage()
                ]);
            }
        }
        
        return View::make('cliente.enviar_carga');
    }

    public function getDownloadModeloConferencia($id)
    {

        $ficha = FichaTecnica::findOrFail($id);

        $callbackSheet = function($sheet) use($ficha)
        {
            $sheet->appendRow([$ficha->campo_chave]);

            $callbackRow = function($row)
            {
                $row->setFontColor('#FFFFFF')
                    ->setBackground('#00458B');
            };

            $sheet->row(1, $callbackRow);
        };

        Excel::create($filename, $callbackSheet)->download('xlsx');

    }

}