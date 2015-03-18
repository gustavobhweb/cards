<?php

// Verifica se o sistema está em manutenção 

if (Config::get('app.maintenance') === true) {

    Route::any('{all}', function()
    {

        if (Request::ajax()) {

            return Response::json(['error' => 'Sistema em manutenção'], 503);
        }


        return View::make('errors.maintenance');

    })->where('all', '(.*)');
}

Route::group(['before' => 'guest'], function ()
{
    Route::any('/', function(){

        return Redirect::guest('login');
    });


    Route::any('/login', [
        'uses' => 'AuthController@anyGuest'
    ]);

});

Route::any('/logout', [
    'as' => 'logout',
    'uses' => 'AuthController@anyLogout'
]);

Route::controller('auth', 'AuthController');

Route::group(['before' => 'auth'], function(){
    
    if (Auth::check()) {

        $auth = Auth::user();

        $nivel = $auth->nivel;

        foreach ($auth->nivel->permissoes as $permissao) {
            Route::{$permissao->type}(
                $permissao->url, [
                    'uses' => $permissao->action
                ]
            );
        }


        $unauthorized = function() {
                
            
            if (Request::ajax()) {

                return Response::json(['error' => 'Acesso não autorizado'], 403);

            } else {

                return Redirect::to('auth/router');

            }
        };

        $permissoesNegadas = Permissao::whereDoesntHave('niveis', function($query) use($auth) {

            $query->whereId($auth->nivel_id);
        })
        ->lists('url');


        foreach ($permissoesNegadas as $url) {

            Route::any($url, $unauthorized);
        }

    }
});

Route::group(['before' => 'nivel_admin_cliente'], function (){

    if (Auth::check() && Auth::user()->nivel_id === 9) { 

        Route::controller('admin-cliente', 'AdminClienteController');
        
    }
});

Route::group(['before' => 'nivel_colaborador_cliente'], function ()
{

    Route::any('colaboradores', function ()
    {
        return Redirect::action('ColaboradoresController@getEnviarFoto');
    });


    Route::post('aluno/cropimage', ['uses' => 'AlunoController@postCropimage']);

    Route::controller('colaboradores', 'ColaboradoresController');
});


Route::get('json/cidades', function ()
{
    $cidade = Cidade::where('uf_id', '=', Input::get('uf_id'))->lists('nome');

    return Response::json($cidade);
});

Route::group(['before' => 'auth.basic'], function(){

   // Route::controller('service', 'ServiceController');
});






Route::group(['before' => 'csrf|ajax'], function()
{

    Route::post('captcha-validate', function()
    {
        if (! Input::has('captcha')) {

            return App::abort(400, 'Bad request. Excpected argument "captcha"');
        }

        $rules = [
            'captcha' => 'required|captcha',       
        ];

        $inputs = ['captcha' => filter_var(Input::get('captcha')) ];

        $validation = Validator::make($inputs, $rules);

        return Response::json([
            'status' => $validation->passes(),
        ]);

    });

});




Route::get('t', function()
{   

    $name = Request::ip();

    if (Cache::get($name) > 5) {

        return App::abort(403, 'Suspended by attempted request forgery!');
    }

    if (! Cache::has($name)) {

        Cache::forever($name, 0);

    } else {

        Cache::increment($name);
    }


    print_r(Cache::get($name));
});