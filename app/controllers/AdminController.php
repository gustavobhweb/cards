<?php

class AdminController extends BaseController
{
    public function getGerenciarUsuarios()
    {
        return View::make('admin.gerenciar-usuarios', $vars);
    }

    public function anyCadastrarUsuarios()
    {
        if (Request::isMethod('post')) {
            $data = Input::all();
            if (Usuario::whereUsername($data['username'])->count()) {
                $vars['alert'] = [
                    'status' => false,
                    'message' => 'Este usuário já existe no banco de dados.'
                ];
            } elseif ($data['password'] == null || $data['password'] == '') {
                $vars['message'] = 'Digite a senha do usuário.';
            } elseif ($data['nome'] == null || $data['nome'] == '') {
                $vars['alert'] = [
                    'status' => false,
                    'message' => 'Digite o nome do usuário.'
                ];
            } elseif ($data['nivel_id'] == null || $data['nivel_id'] == '') {
                $vars['alert'] = [
                    'status' => false,
                    'message' => 'Selecione o nível do usuário.'
                ];
            } else {
                $data['password'] = Hash::make($data['password']);
                Usuario::create($data);
                $vars['alert'] = [
                    'status' => true,
                    'message' => 'Usuário cadastrado com sucesso.'
                ];
            }
        }
        $vars['niveis'] = Nivel::whereStatus(1)->get();
        $vars['clientes'] = Cliente::whereStatus(1)->get();
        return View::make('admin.cadastrar-usuarios', $vars);
    }

    public function anyCadastrarPermissoes()
    {
        $vars = [];

        if (Request::isMethod('post')) {
            $data = Input::all();
            if (Permissao::whereAction($data['action'])->count()) {
                $vars['message'] = 'Já existe uma permissão cadastrado com essa ação.';
            } else {
                $permissao = Permissao::create($data);
                $vars['suggest'] = true;
                $vars['permissao_id'] = $permissao->id;
                $vars['message'] = 'Permissão cadastrada com sucesso.';
            }
        }

        $vars['permissoes'] = Permissao::all();
        return View::make('admin.cadastrar-permissoes', $vars);
    }

    public function anyAcl()
    {
        $vars['niveis'] = Nivel::whereStatus(1)->get();
        $vars['permissoes'] = Permissao::all();

        if (Request::isMethod('post')) {
            $data = Input::all();
            if ($data['nivel_id'] == null || $data['nivel_id'] == '') {
                $vars['message'] = 'Selecione um nível.';
            } elseif ($data['permissao_id'] == null || $data['permissao_id'] == '') {
                $vars['message'] = 'Selecione uma permissão.';
            } elseif (NiveisPermissao::whereNivelId($data['nivel_id'])->wherePermissaoId($data['permissao_id'])->count()) {
                $vars['message'] = 'Esta permissão já foi concedida a este nível';
            } else {
                NiveisPermissao::create($data);
                $vars['message'] = 'Permissão concedida com sucesso.';
            }
        }

        return View::make('admin.acl', $vars);
    }

    public function anyPermissoes($nivel_id)
    {

        $nivel = Nivel::findOrFail($nivel_id);


        if (Request::isMethod('post')) {

            if (Input::has('permissao_id_del')) {

                $permissao_id = Input::get('permissao_id_del');

                $nivel->permissoes()->detach($permissao_id);

            } elseif (Input::has('permissao_define_home_id')) {

                $updateData = [
                    'pagina_inicial_permissao_id' => Input::get('permissao_define_home_id')
                ];

                $nivel->fill($updateData)->save();

            } else {

                $permissao_id = Input::get('permissao_id');

                if (! Input::has('permissao_id')) {

                    $vars['message'] = 'Selecione uma permissão.';

                } else {
                    
                    $nivel->permissoes()->attach($permissao_id);

                    $vars['message'] = 'Permissão concedida com sucesso.';  
                }
            }
        }

        $vars['nivel_id'] = $nivel_id;

        $vars['nivel'] = $nivel;

        $vars['permissoes'] = $nivel->permissoes;

        $vars['paginaInicialId'] = $nivel->paginaInicial()->pluck('id');

        return View::make('admin.permissoes', $vars);
    }

    public function anyCadastrarNiveis()
    {
        $vars = [];

        if (Request::isMethod('post')) {
            $nome = Input::get('titulo');
            if (Nivel::whereTitulo($nome)->count()) {
                $vars['alert'] = [
                    "status" => false,
                    "message" => "O nível &ldquo;" . $nome . "&rdquo; já existe!"
                ];
            } else {
                Nivel::create([
                    'titulo' => $nome
                ]);
                $vars['alert'] = [
                    "status" => true,
                    "message" => "O nível &ldquo;" . $nome . "&rdquo; foi cadastrado com sucesso!"
                ];
            }
        }

        return View::make('admin.cadastrar-niveis', $vars);
    }

    public function getControleDeUsuarios()
    {
        $vars['niveis'] = Nivel::whereStatus(1)
                                ->with(['usuarios' =>    function($query)
                                {
                                    $query->where('id', '!=', Auth::user()->id);
                                }])
                                ->get();

        return View::make('admin.controle-de-usuarios', $vars);
    }

    public function postAjaxTrocarNivel()
    {
        $nivel_id = Input::get('nivel_id');
        $usuario_id = Input::get('usuario_id');

        Usuario::whereId($usuario_id)
                ->update([
                    'nivel_id' => $nivel_id
                ]);
        return Response::json(true);
    }

    public function getAjaxSearchMethods()
    {
        $search = Input::get('search');

        if (!strpos($search, '@')) {
            $dir = dir(app_path('controllers'));
            $controllers = [];

            if ($search != null && $search != '') {
                while ($file = $dir->read()) {
                    if (stristr($file, $search)) {
                        $controllers[] = str_replace('.php', '', $file) . '@';
                    }
                }
            }

            return Response::json($controllers);
        } else {
            
            $searchArr = explode('@', $search);
            $controller = $searchArr[0];
            $method = $searchArr[1];

            $methods = get_class_methods($controller);

            $returnMethods = [];

            if ($method != null && $method != '') {
                foreach ($methods as $methodIndex) {
                    if (stristr($methodIndex, $method)) {
                        $returnMethods[] = $controller . '@' . $methodIndex;
                        if ($search == ($controller . '@' . $methodIndex)) {
                            return Response::json([]);
                        }
                    }
                }
            }
            return Response::json($returnMethods);
        }
    }

    public function getAjaxMakeUrl()
    {
        $action = explode('@', Input::get('action'));

        $controller = Str::slug(snake_case(str_replace('Controller', '', $action[0])));

        $method = explode('_', snake_case($action[1]));
        $typeRequest = $method[0];
        unset($method[0]);
        $method = str_replace('_', '-', implode('-', $method));


        //preg_replace('/^(get|post|delete|put)/', '', $method);

        $url = $controller . '/' . $method;

        $reflect = new ReflectionMethod($action[0], $action[1]);

        foreach( $reflect->getParameters() as $param) {
            if ($param->isOptional()) {
                $url .= '/{' . $param->getName() . '?}';
            } else {
                $url .= '/{' . $param->getName() . '}';
            }
        }

        return Response::json([
            'url' => $url,
            'type' => $typeRequest
        ]);
    }

    public function getSearchPermission()
    {
        $searchTerm = sprintf('%%%s%%', filter_var(Input::get('search')));        

        $callbackSearch = function($query) use($searchTerm)
        {

            $query->where('name', 'LIKE', $searchTerm)
                    ->orWhere('action', 'LIKE', $searchTerm)
                    ->orWhere('url', 'LIKE', $searchTerm);

        };

        $permissoes = Permissao::where($callbackSearch)                                
                                ->whereDoesntHave('niveis', function($query) 
                                {
                                    // Resultados de permissões que não foram concedidas para esse nível

                                    $nivel_id = Input::get('nivel_id');

                                    $query->whereId($nivel_id);
                                })
                                ->limit(10)
                                ->get();

        return Response::json($permissoes);
    }


    public function anyGerenciarFichasTecnicas()
    {
        $vars['fichas_tecnicas'] = FichaTecnica::whereStatus(1)->get();
        $vars['fichas_tecnicas_lixeira_num'] = FichaTecnica::whereStatus(0)->count();

        return View::make('admin.gerenciar-fichas-tecnicas', $vars);
    }

    public function anyCadastrarFichaTecnica()
    {

        $tiposCartoes = TipoCartao::whereStatus(1)->get();

        $tiposEntrega = TipoEntrega::whereStatus(1)->lists('nome', 'id');

        $clientes = Cliente::whereStatus(1)->get();

        $tiposSolicitacoes = TipoSolicitacao::whereStatus(1)->get();

        return View::make('admin.cadastrar-ficha-tecnica', get_defined_vars());
    }

    public function getEditarFichaTecnica($id)
    {

        $ficha = FichaTecnica::with('camposVariaveis')->findOrFail($id);

        if ($ficha->aprovado == 1) {

            $errors = [
                'ficha_tecnica' => 'Essa ficha já foi aprovada pelo cliente. Não pode ser editada.'
            ];

            return Redirect::back()->withErrors($errors);
        }

        $tiposCartoes = TipoCartao::whereStatus(1)->get();

        $tiposEntrega = TipoEntrega::whereStatus(1)->lists('nome', 'id');

        $clientes = Cliente::whereStatus(1)->get();

        $tiposSolicitacoes = TipoSolicitacao::whereStatus(1)->get();

        return View::make('admin.editar-ficha-tecnica', get_defined_vars());
    }


    public function postAjaxEditarFichaTecnica($id)
    {
        try {

            $ficha = FichaTecnica::findOrFail($id);
    
            if ($ficha->aprovado == 1) {

                throw new UnexpectedValueException(
                    'Não é possível editar uma ficha técnica aprovada'
                );
                
            }

            DB::transaction(function() use($id, $ficha) {


                $ficha->camposVariaveis()->detach();

                $ficha->tiposCartao()->detach();

                $inputs = Input::only(
                    'nome',
                    'tipo_cartao_id',
                    'tipo_entrega_id',
                    'tipo',
                    'campo_chave',
                    'tem_furo',
                    'cliente_id'
                );

                $dir = public_path("fichas_tecnicas/{$ficha->id}");

                if (! File::isDirectory($dir)) {

                    File::makeDirectory($dir, 0755, true);
                }

                if (Input::hasFile('foto_frente')) {

                    $fotoFrente = Input::file('foto_frente');

                    $ext = $fotoFrente->getClientOriginalExtension();

                    $inputs['foto_frente'] = "foto_frente.{$ext}";

                    $fotoFrente->move($dir, $inputs['foto_frente']);
                }

                if (Input::hasFile('foto_verso')) {

                    $fotoVerso = Input::file('foto_verso');

                    $ext = $fotoVerso->getClientOriginalExtension();

                    $inputs['foto_verso'] = "foto_verso.{$ext}";

                    $fotoVerso->move($dir, $inputs['foto_verso']);
                }

                $ficha->fill($inputs)->save();

                $campos = Input::get('campos');

                if (is_array($campos)) {
                    
                    foreach ($campos as $nome_campo) {

                        $nome_campo = trim($nome_campo);

                        $campoVariavel = CampoVariavel::firstOrCreate(['nome' => $nome_campo]);

                        $camposRelacionados[] = $campoVariavel->id;

                    }

                    $ficha->camposVariaveis()->attach($camposRelacionados);

                    $tiposCartao = (array) Input::get('tipo_cartao_id');

                    $ficha->tiposCartao()->attach($tiposCartao);

                } else {

                    throw new UnexpectedValueException('Nenhum dado foi enviado');
                }
            });

            return Response::json([
                'error' => false,
                'inputs' => Input::all()
            ]);

        } catch (Exception $e) {

            return Response::json([
                'error'  => $e->getMessage()
            ]);
            
        }
    }

    public function getAjaxCampos()
    {
        $q = Input::get('q');

        $select = [
            'id',
            'nome AS label'
        ];

        $campos = CampoVariavel::select($select)
                                ->where('nome', 'LIKE', '%'.$q.'%')
                                ->limit(6)
                                ->get();

        return Response::json($campos);
    }

    public function postAjaxCadastrarFichaTecnica()
    {

        try {

            DB::transaction(function() {

                /* inputs vindos do formulário */

                $inputs = Input::only(
                    'nome',
                    'tipo_cartao_id',
                    'tipo_entrega_id',
                    'tipo',
                    'campo_chave',
                    'tem_furo',
                    'cliente_id'
                );

                $files = [];

                $filename = [];

                if (Input::hasFile('foto_frente')) {

                    $files['foto_frente'] = Input::file('foto_frente');

                    $ext = Str::lower($files['foto_frente']->getClientOriginalExtension());

                    $inputs['foto_frente'] = "foto_frente.{$ext}";


                }

                if (Input::hasFile('foto_verso')) {

                    $files['foto_verso'] = Input::file('foto_verso');

                    $ext = Str::lower($files['foto_verso']->getClientOriginalExtension());

                    $inputs['foto_verso'] = "foto_verso.{$ext}";

                }

                $ficha = FichaTecnica::create($inputs);

                $dir = public_path("fichas_tecnicas/{$ficha->id}");             


                if (! File::isDirectory($dir)) {
                    
                    File::makeDirectory($dir, 0755, true);
                }


                if (isset($inputs['foto_frente'])) {

                    $files['foto_frente']->move($dir, $inputs['foto_frente']);
                }

                if (isset($inputs['foto_verso'])) {

                    $files['foto_verso']->move($dir, $inputs['foto_verso']);
                }


                $campos = Input::get('campos');

                $camposRelacionados = [];

                if (is_array($campos) && $campos) {
                    
                    foreach ($campos as $nome_campo) {
                        
                        /*
                            limpamos os espaços vazios para não 
                            criar um novo valor desnecessário por conta de espaços
                        */
                        $nome_campo = trim($nome_campo);

                        /* Cria ou acha os dados com esse valor */
                        $campoVariavel = CampoVariavel::firstOrCreate(['nome' => $nome_campo]);

                        /* array com os campos, para serem inseridos de uma só vez pelo "attach" */
                        $camposRelacionados[] = $campoVariavel->id;

                    }

                    $ficha->camposVariaveis()->attach($camposRelacionados);

                    $tiposCartao = (array) Input::get('tipo_cartao_id');

                    $ficha->tiposCartao()->attach($tiposCartao);


                } else {

                    throw new Exception('Nenhum campo foi inserido');
                }

            });

            return Response::json([
                'error' => false
            ]);

        } catch (Exception $e) {

            return Response::json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function putAjaxDeletarFichaTecnica()
    {
        $fcObj = FichaTecnica::whereId(Input::get('id'));
        $fcObj->update([
            'status' => 0
        ]);
        return Response::json(true);
    }

    public function getLixeiraFichasTecnicas()
    {
        $vars['fichas_tecnicas'] = FichaTecnica::whereStatus(0)->get();

        return View::make('admin.lixeira-fichas-tecnicas', $vars);
    }

    public function putAjaxRestaurarFichaTecnica()
    {
        $fcObj = FichaTecnica::whereId(Input::get('id'));
        $fcObj->update([
            'status' => 1
        ]);
        return Response::json(true);
    }


    public function getInfoLixeiraFichaTecnica($id)
    {

        $remessa = FichaTecnica::with('camposVariaveis')->findOrFail($id);

        return Response::json($remessa);
    }



    public function getTiposEntrega()
    {   

        $callbackSearch = function($query)
        {
            if (Input::has('nome')) {

                $nome = filter_var(Input::get('nome'));

                $query->where('nome', 'LIKE', "%{$nome}%");
            }
        };
        $tiposEntrega = TipoEntrega::where($callbackSearch)
                                    ->paginate(15)
                                    ->appends(Input::except('page'));


        return View::make('admin.tipos-entrega', get_defined_vars());
    }

    public function anyCadastrarTipoEntrega()
    {

        $message = new MessageBag;

        if (Request::isMethod('post')) {

            $rules = [
                'nome' => 'required|unique:tipos_entrega,nome'
            ];

            $validationMessages = [
                'required'  => 'Campo de preenchimento obrigatório',
                'unique'    => 'Esse :attribute já existe na nossa base de dados',
            ];

            $validation = Validator::make(Input::all(), $rules, $validationMessages);

            if ($validation->passes()) {

                $data = Input::only('nome');

                TipoEntrega::create($data);

                $message->add('message', 'Tipo de entrega criado com sucesso');

            } else {

                return Redirect::back()->withErrors($validation);

            }
            
        }

        $tipoEntrega =  null;

        return View::make('admin.editar-tipo-entrega', get_defined_vars());
    }

    public function anyEditarTipoEntrega($id)
    {
        $tipoEntrega = TipoEntrega::findOrFail($id);

        $message = new MessageBag;

        if (Request::isMethod('post')) {

            $rules = [
                'nome' => 'required|different:nome_atual|unique:tipos_entrega,nome'
            ];

            $validationMessages = [
                'required'  => 'Campo de preenchimento obrigatório',
                'unique'    => 'O :attribute já existe na nossa base de dados',
                'different' => 'O valor do campo :attribute não foi alterado'
            ];

            $inputs = Input::only('nome') + ['nome_atual' => $tipoEntrega->nome];

            $validation = Validator::make($inputs, $rules, $validationMessages);

            if ($validation->passes()) {

                $data = Input::only('nome');

                $tipoEntrega->fill($data)->save();

                $message->add('message', 'O tipo de entrega foi atualizado com sucesso');

            } else {

                return Redirect::back()->withErrors($validation);

            }
            
        }

        return View::make('admin.editar-tipo-entrega', get_defined_vars());
    }

    public function putAjaxAlterarStatusTipoEntrega($id)
    {
        try {

            $status = (int) Input::get('status');

            $tipoEntrega = TipoEntrega::findOrFail($id);

            $tipoEntrega->fill(['status' => $status])->save();

        } catch (Exception $e) {

            return Response::json([
                'error' => 'erro ao processar o tipo de entrega'
            ]);
        }

        return Response::json([
            'error'  => false,
            'inputs' => Input::all()
        ]);
    }


    public function getTiposCartao()
    {
        $tiposCartao = TipoCartao::paginate(30);

        return View::make('admin.tipos-cartao', get_defined_vars());
    }



    public function anyEditarTipoCartao($id)
    {

        $tipoCartao = TipoCartao::findOrFail($id);

        $message = new MessageBag;


        if (Request::isMethod('post')) {

            $rules = [
                'nome' => 'required|unique:tipos_cartao,nome|min:3'
            ];

            $messages = [
                'required' => 'O preenchimento de :attribute é obrigatório',
                'unique'   => 'O :attribute indicado já existe em nossa base de dados',
                'min'      => 'O campo :attribute deve ter no mínimo :min caracteres'
            ];

            $inputs = Input::only('nome');

            $validation = Validator::make($inputs, $rules, $messages);

            if ($validation->passes()) {


                $tipoCartao->fill($inputs)->save();


                $message->add('message', 'Tipo de cartão salva com sucesso');

            } else {

                return Redirect::back()->withInput()->withErrors($validation);

            }


        }

        return View::make('admin.editar-tipo-cartao', get_defined_vars());
    }

    public function anyCadastrarTipoCartao()
    {

        $tipoCartao = null;

        $message = new MessageBag;


        if (Request::isMethod('post')) {

            $rules = [
                'nome' => 'required|unique:tipos_cartao,nome|min:3'
            ];

            $messages = [
                'required' => 'O preenchimento de :attribute é obrigatório',
                'unique'   => 'O :attribute indicado já existe em nossa base de dados',
                'min'      => 'O campo :attribute deve ter no mínimo :min caracteres'
            ];

            $inputs = Input::only('nome');

            $validation = Validator::make($inputs, $rules, $messages);


            if ($validation->passes()) {

                $inputs['status'] = 1;

                TipoCartao::create($inputs);

                $message->add('message', 'Tipo de cartão salvo com sucesso');

            } else {

                return Redirect::back()->withInput()->withErrors($validation);

            }
        }

        return View::make('admin.editar-tipo-cartao', get_defined_vars());
    }


    public function putAjaxAlterarStatusTipoCartao($id)
    {

        try{

            $status = (int) Input::get('status');

            $tipoCartao = TipoCartao::findOrFail($id);

            $tipoCartao->fill(['status' => $status])->save();

        } catch (Exception $e) {


            $errors = [
                'error' => 'Não foi possível processar o tipo de cartão selecionado'
            ];

            return Response::json($errors);
        }


        return Response::json(['error' => false]);
    }

    public function putAjaxRemoverFotoFichaTecnica($id)
    {

        try {

            $ficha = FichaTecnica::findOrFail($id);
            
            if (Input::has('foto_frente')) {

                File::delete($ficha->foto_frente_realpath);

                $ficha->foto_frente = null;

            }

            if (Input::has('foto_verso')) {

                File::delete($ficha->foto_verso_realpath);

                $ficha->foto_verso = null;

            }

            $ficha->save();

        } catch (Exception $e) {
            
            $errors = [
                'error' => 'Não foi possível encontrar a ficha técninca selecionada',
                'exception' => [
                    'message' => $e->getMessage(),
                    'line'    => $e->getLine(),
                ]
            ];

            return Response::json($errors);
        }


        return Response::json(['error' => false]);
    }

    public function anyGerenciarClientes()
    {
        $clientes = Cliente::whereStatus(1);

        if (Input::has('search')) {
            $clientes->where('nome', 'LIKE', '%' . Input::get('search') . '%')
                     ->orWhere('cnpj', 'LIKE', '%' . Input::get('search') . '%')
                     ->orWhere('telefone', 'LIKE', '%' . Input::get('search') . '%')
                     ->orWhere('pessoa_contato', 'LIKE', '%' . Input::get('search') . '%')
                     ->orWhere('email', 'LIKE', '%' . Input::get('search') . '%');
        }

        if (Request::isMethod('post')) {
            $data = Input::all();
            if (Usuario::whereUsername($data['username'])->count()) {
                $vars['alert'] = [
                    'status' => false,
                    'message' => 'Este usuário já existe no banco de dados.'
                ];
            } elseif ($data['password'] == null || $data['password'] == '') {
                $vars['message'] = 'Digite a senha do usuário.';
            } elseif ($data['nome'] == null || $data['nome'] == '') {
                $vars['alert'] = [
                    'status' => false,
                    'message' => 'Digite o nome do usuário.'
                ];
            } else {
                $data['password'] = Hash::make($data['password']);
                $data['nivel_id'] = 16;
                Usuario::create($data);
                $vars['alert'] = [
                    'status' => true,
                    'message' => 'Usuário cadastrado com sucesso.'
                ];
            }
        }

        $clientes = $clientes->paginate(15);

        return View::make('admin.gerenciar-clientes', get_defined_vars());
    }

    public function getAjaxUsuariosCliente($id)
    {
        $clientes = Cliente::findOrFail($id)->usuarios()->whereStatus(1)->get();

        return Response::json($clientes);
    }

    public function anyClientesOperacao($id = null)
    {
        $cliente = Cliente::whereId($id)->first();
        if (Request::isMethod('post')) {
            $input = Input::all();
            $clienteConferir = Cliente::whereNome($input['nome'])
                                       ->whereStatus(1)
                                       ->first();

            if ($clienteConferir && $clienteConferir->id != $cliente->id) {
                $message = [
                    'status' => false,
                    'message' => 'Já existe um cliente com o mesmo nome!'
                ];
            } else {
                if (!is_null($id)) {
                    $cliente->update($input);
                    $message = [
                        'status' => true,
                        'message' => 'Os dados foram salvos com sucesso!'
                    ];
                } else {
                    $cliente = Cliente::create($input);
                    $message = [
                        'status' => true,
                        'message' => 'Os dados foram cadastrados com sucesso!'
                    ];
                }
            }
        }

        return View::make('admin.clientes-operacao', get_defined_vars());
    }

    public function anySalvarConfiguracaoAcl()
    {
        if (Request::isMethod('post')) {

            $json = [];

            if (Input::get('niveis')) {
                $json['niveis'] = Nivel::all()->toArray();
            }

            if (Input::get('permissoes')) {
                $json['permissoes'] = Permissao::all()->toArray();
            }

            if (Input::get('niveis_permissoes')) {
                $json['niveis_permissoes'] = NiveisPermissao::all()->toArray();
            }

            if (Input::get('usuarios')) {
                $json['usuarios'] = Usuario::all()->toArray();
            }

            if (!is_dir(public_path('config_files'))) mkdir(public_path('config_files'), 0777);
            if (!is_dir(public_path('config_files/acl'))) mkdir(public_path('config_files/acl'), 0777);

            $filename = time() . '.cfw';

            header("Content-Type: text/cfw");
            header("Content-Type: application/force-download");
            header("Content-disposition: attachment; filename=config_acl_" . date('Y-m-d_H-i-s').".cfw");

            echo base64_encode(json_encode($json));
            exit;
        }

        return View::make('admin.salvar-configuracao-acl', get_defined_vars());
    }

    public function anyImportarConfiguracaoAcl()
    {
        if (Request::isMethod('post')) {
            
        }
        return View::make('admin.importar-configuracao-acl', get_defined_vars());
    }

    public function deleteAjaxDeletarCliente()
    {
        $id = Input::get('cliente_id');

        $clientes = Cliente::whereId($id);

        $update = $clientes->update([
                                'status' => 0
                            ]);

        if ($update) {
            return Response::json([
                'status' => true
            ]);
        } else {
            return Response::json([
                'status' => false
            ]);
        }
    }

    public function deleteAjaxDeletarUsuarioCliente()
    {
        $id = Input::get('usuario_id');

        Usuario::whereId($id)->update([
            'status' => 0
        ]);
    }

    public function postAjaxCadastrarUsuarioCliente()
    {
        $inputs = Input::all();

        if (Usuario::whereUsername($inputs['username'])->whereStatus(1)->count()) {
            return Response::json([
                'status' => false,
                'message' => "O usuário <b>" . $inputs['username'] . "</b> já foi cadastrado no sistema"
            ]);
        }

        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['nivel_id'] = 16;
        $usuarios = Usuario::create($inputs);


        if ($usuarios) {
            return Response::json([
                'status' => true
            ]);
        } else {
            return Response::json([
                'status' => false,
                'message' => 'Usuário não cadastrado. Erro desconhecido.'
            ]);
        }
    }

}