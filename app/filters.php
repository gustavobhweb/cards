<?php

App::before(function ($request)
{
    View::share('user', Auth::user());
        
    View::composer('layouts.default', function ($view)
    {
        $view['permissoesMenu'] = Auth::user()
                                        ->nivel
                                        ->permissoes()
                                        ->where('in_menu', '=', 1)
                                        ->get();
    });

    View::composer('elements.cliente.submenu-remessas', function($view)
    {

        $view['enviarFotoCount'] = Remessa::with('solicitacoes')
                                            ->whereStatusAtualId(1)
                                            ->whereHas('solicitacoes', function($query)
                                            {
                                                $query->whereCargaEnviada(0);
                                            })
                                            ->count();

        $view['impressaoCount'] = Remessa::whereStatusAtualId(1)
                                            ->whereDoesntHave('solicitacoes', function($query)
                                            {
                                                $query->whereCargaEnviada(0);

                                            })->count();

        $view['historicoCount'] =  Remessa::with('solicitacoes')
                                            ->where('status_atual_id', '<>', 1)
                                            ->count();

    });
});

Route::filter('guest', function()
{
    if (Auth::check()) {
        return Redirect::to('auth/router');
    }
});

Route::filter('auth', function()
{
    if (Auth::guest()) {
        
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    }
});

Route::filter('csrf', function()
{    
    if (Session::token() != Input::get('_token'))
    {
        throw new \Illuminate\Session\TokenMismatchException;
    }
});

/**
* Filtro para o web service
*/
Route::filter('auth.basic', function()
{
    return Auth::basic('username');
});

/**
* Apenas requisições do tipo "XHTTPREQUEST"
*/
Route::filter('ajax', function(){

    if (! Request::ajax()) {

        return App::abort(403, 'Only XHTTPRequest is accepted');
    }
});