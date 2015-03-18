<?php

class AuthController extends BaseController
{

    public function anyGuest()
    {

        if (Request::isMethod('post')) {

            if (Session::token() != Input::get('_token')) {

                return App::abort(403, 'Acesso não autorizado');
            }

            $rules = [];

            $messages = [];

            $credentials = [
                'username' => filter_var(Input::get('username')),
                'password' => filter_var(Input::get('password')),
                'status'   => 1
            ];

            $validation = Validator::make(Input::all(), $rules, $messages);

            if ($validation->passes() && Auth::attempt($credentials)) {

                return Redirect::guest('auth/router');

            } else {

                /*
                    Se a validação passar, porém a tentativa de login deu errado,
                    adiciona a mensagem de erro
                */

                if ($validation->messages()->isEmpty()) {
                    $validation->messages()->add('login', 'Usuário ou senha incorretos');
                }

                return Redirect::back()->withErrors($validation);
            }

        }

        return View::make('auth.guest');
    }


    public function getRouter()
    {
        if (Auth::check()) {

            $auth = Auth::user();

            if ($auth->nivel->paginaInicial instanceof Permissao) {

                $paginaInicial = $auth->nivel->paginaInicial->action;

            } else {

                try {

                    $paginaInicial = $auth->nivel->permissoes()->firstOrFail()->action;

                } catch (Exception $e) {
                    
                    return App::abort(503, 'Erro ao redirecionar o usuário');
                }
            }


            return Redirect::action($paginaInicial);

        } else {

            return Redirect::to('login');
        }
    }


    public function anyLogout()
    {

        if (Auth::user()->nivel_id === 1) { 
            $url = '/';
        } else {
            $url = '/login';
        }

        Auth::logout();
        return Redirect::to($url);
        
    }

    public function anyLoginAluno()
    {
        if (Request::isMethod('post')) {

            try{

                $matricula = Input::get('matricula');
                $senha = Input::get('senha');

                // Stream passado por parâmetro no file_get_contents
                $context = stream_context_create([
                    'http' => [
                        'method'  => 'POST',
                        'content' => http_build_query([
                            'username' => $matricula,
                            'password' => $senha
                        ]),
                        'header'  => [
                            0 => 'Content-Type: application/x-www-form-urlencoded',
                            2 => sprintf('Authorization: Basic %s', base64_encode("tmt:5fGCxwqEryhfH7fLBYBaN9zN69dEK9e2"))
                        ]
                    ]
                ]);

                try {
                    $response = json_decode(file_get_contents(self::URL_API_LOGIN, false, $context));
                } catch(\Exception $e) {
                    throw new \Exception('Matrícula e/ou senha não conferem.');
                }


                $usuario = Usuario::whereMatricula($matricula)->first();

                /**
                * $response, nesse caso, vem como [true], por isso temos que capturá-lo pelo índice
                **/

            
                if (isset($response[0]) && $response[0] === true) {

                    if ($usuario instanceof Usuario) {

                        if ($usuario->nivel_id != 1) {

                            throw new Exception(sprintf(
                                'O seu nível de usuário exige que o login seja feito %s',
                                HTML::link('/login', 'nessa página', ['class' => 'link'])
                            ));
                        }

                        Auth::login($usuario);
                        return Redirect::to('auth/router');

                    }
                    
                    throw new \Exception("Você não possui créditos. <a class='saiba-mais' target='_blank' href='http://newtonpaiva.br/mkt/arquivos/manual_solicitacao_carteirinha_nov2014.pdf'>Saiba mais</a>");

                } else {
                    throw new \Exception('Matrícula e/ou senha incorretos.');
                }



            } catch(\Exception $e) {

                return Redirect::back()
                                ->withErrors(['message' => $e->getMessage()])
                                ->withInput();
            }
        }


        return View::make('auth.login-aluno');
    }


    public function anyMeusDados()
    {
        $usuario = Auth::user();


        if (Request::isMethod('post')) {

            $rules = [
                'nome'     => 'required|min:2',
                'username' => 'required|unique:usuarios,username',
                'password' => 'same:confirmaSenha'
            ];

            $messages = [
                'same'     => 'Os valores de :attribute não conferem.',
                'required' => 'O campo :attribute é de preenchimento obrigatório.',
                'unique'   => 'O :attribute já está em uso. '
            ];


            if ($usuario->username === Input::get('username')) {

                unset($rules['username']);
            }

            $validation = Validator::make(Input::all(), $rules, $messages);


            if ($validation->passes()) {

                $inputs = Input::only('username','nome');

                if (Input::has('password')) {

                    $inputs['password'] = Hash::make(Input::get('password'));

                } 
                
                $usuario->fill($inputs)->save();

                return Redirect::back()->withSuccess(true);

            } else {

                return Redirect::back()->withErrors($validation)->withInput();
            }

        }
        
        return View::make('auth.meus_dados', get_defined_vars());
        
    }


    public function anyLoginColaborador()
    {
        if (Request::isMethod('post')) {

            $cpf   = filter_var(Input::get('cpf'));
            $senha = filter_var(Input::get('senha')); 

            try{

                $context = stream_context_create([
                    'http' => [
                        'method'  => 'POST',
                        'content' => http_build_query([
                            'username' => $cpf,
                            'password' => $senha
                        ]),
                        'header'  => [
                            0 => 'Content-Type: application/x-www-form-urlencoded',
                            1 => sprintf('Authorization: Basic %s', base64_encode("tmt:5fGCxwqEryhfH7fLBYBaN9zN69dEK9e2"))
                        ]
                    ]
                ]);

                try {
                    $response = json_decode(file_get_contents(self::URL_API_LOGIN, false, $context));
                } catch(\Exception $e) {
                    throw new \Exception('CPF e/ou senha não conferem.');
                }

                $usuario = Usuario::whereCpf($cpf)->first();
                
                if (isset($response[0]) && $response[0] === true) {

                    if ($usuario instanceof Usuario) {

                        if ($usuario->nivel_id != 12) {

                            throw new Exception(sprintf(
                                'O seu nível de usuário exige que o login seja feito %s',
                                HTML::link('/login', 'nessa página', ['class' => 'link'])
                            ));
                        }

                        Auth::login($usuario);
                        return Redirect::to('auth/router');

                    }
                    
                    throw new \Exception("Você não possui créditos. <a class='saiba-mais' target='_blank' href='http://newtonpaiva.br/mkt/arquivos/manual_solicitacao_carteirinha_nov2014.pdf'>Saiba mais</a>");

                } else {
                    throw new \Exception('CPF e/ou senha incorretos.');
                }



            } catch(\Exception $e) {

                return Redirect::back()
                                ->withErrors(['message' => $e->getMessage()])
                                ->withInput();
            }
        }

        return View::make('auth.login_colaboradores');
    }
}