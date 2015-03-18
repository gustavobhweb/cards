<?php

class AdminClienteController extends BaseController
{
    
    public function getIndex()
    {
        $vars['niveis'] = Nivel::all();
        return View::make('admin_cliente.index', $vars);
    }

    public function postIndex()
    {
        $rules = [
            'nome' => 'required|min:4',
            'username' => 'required|unique:usuarios,username',
            'email'    => 'required|unique:usuarios,email',
            'password'    => 'required|same:confirmaSenha',
        ];

        $messages = [
            'required' => 'Esse campo é obrigatório',
            'unique'   => 'O campo :attribute já está cadastrado no sistema',
            'min'      => 'O campo :attribute deve conter no mínimo :min caracteres'
        ];

        $validation = Validator::make(Input::all(), $rules, $messages);

        $redirector = Redirect::action('AdminClienteController@getIndex');

        if ($validation->passes()) {

            $input = Input::only('nome', 'username', 'password', 'email', 'nivel_id');

            $input['password'] = Hash::make($input['password']);

            Usuario::create($input);

            return $redirector->withMessage(
                View::make('elements.flash.modal_flash_message')
                    ->with('message', 'Dados salvos com sucesso')
                    ->render()                     
            );

        } else {

            return $redirector->withInput()->withErrors($validation->messages());
        }
    }


    public function getEditarUsuario($id = null)
    {
        if (null === $id) {
            return $this->listarUsuarios();
        } else {
            return $this->editarUsuario($id);
        }
    }

    public function postEditarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);

        $rules = [
            'nome' => 'required|min:4',
            'username' => 'required|unique:usuarios,username',
            'email'    => 'required|unique:usuarios,email',
            'password'    => 'required|same:confirmaSenha',
        ];

        $messages = [
            'required' => 'Esse campo é obrigatório',
            'unique'   => 'O campo :attribute já está cadastrado no sistema',
            'min'      => 'O campo :attribute deve conter no mínimo :min caracteres'
        ];

        $validation = Validator::make(Input::all(), $rules, $messages);

        $redirector = Redirect::back();

        if ($validation->passes()) {

            $input = Input::only('nome', 'username', 'password', 'email');

            $input['nivel_id'] = 4;

            $input['password'] = Hash::make($input['password']);


            $usuario::fill($input)->save();


            return $redirector->withMessage(
                View::make('elements.flash.modal_flash_message')
                    ->with('message', 'Dados salvos com sucesso')
                    ->render()                      
            );

        } else {

            return $redirector->withInput()
                              ->withErrors($validation->messages());
        }
    }

    public function listarUsuarios()
    {
        $usuarios = Usuario::whereIn('nivel_id', [9,10,11])->get();

        return View::make('admin_cliente.listar_usuarios', get_defined_vars());
    }

    public function editarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        return View::make('admin_cliente.editar_usuario', get_defined_vars());
    }
}

