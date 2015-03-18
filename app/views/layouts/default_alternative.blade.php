<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no"/>

        {{ HTML::style('css/default.css') }}
        {{ HTML::style('css/topo_mobile.css') }}

        @yield('styles') 

        {{ HTML::script('js/jquery-1.11.2.js')  }}
         
        {{ HTML::script('js/animacao_topo_mobile.js') }}
        
        {{ HTML::script('js/jquery.mask.min.js')  }}
         
        {{ HTML::script('js/default.js') }}
         
        @yield('scripts')

        <link rel="shortcut icon" type="image/png" href="{{ URL::to('img/favicon.png?10') }}" />

        <title>WorkTab</title>

    </head>
<body>
	@include('layouts.elements.topo_mobile')
	<div class='content-box'>

		<div class='left-menu-box'>
			<a href="{{ URL::to('/') }}"> 
                <img class='logo-tmt-box' src='{{ URL::to("img/pbh.png") }}' style="width:76.92307692307692%; max-width:200px;   margin-left: 14%; margin-top: 23px;" />
			</a>
			<div style='width: 84.61538461538462%; float: left; margin: 10.3448275862069% 0 0 13.79310344827586%'>
				<h1  class='h1-menu'>Olá, {{ $user->nome }}!</h1>
				<div class='line' style='margin: 10px 0 0 0'></div>
				<div class='menu'>
                     <ul>
					    
				    	@foreach($PERMISSOES as $permissao)
					    	@if($permissao->in_menu)
						    <li>
						        <a href='{{ URL::to($permissao->url) }}' {{ (Request::is($permissao->url)) ? 'class="on"' : '' }} >
						            <span class="glyphicon glyphicon-{{ $permissao->glyphicon }}"></span>
						            {{ $permissao->name }}
						        </a>
						    </li>
						    @endif
					    @endforeach
					    
					</ul>
                    <img src='{{ URL::to("img/carteira_1.png")  }}' style='margin: 20px 0 0 0; width:100%; background-size:100%;'  />
				</div>
				<!--menu-->
			</div>
		</div>
		<!--left-menu-box-->

		<div class='main-content'>

			<nav class="top-menu">
				<a href='{{URL::current() }}'>
					<div class='solicsHovered'>
						<h1>@yield('title')</h1>
					</div>
				</a>

				<div class='menu-usuario'
					style="width: 65%; margin: 30px 0 0 0">
					<div id="descricao-nome-curso">
						<p>{{ $user->nome }}</p>
                        @if(!empty($user->curso))
						<p style='font-size: 15px'>
                            Curso: {{ $user->curso }}
                        </p>
						@endif
					</div>

					<div style="width: 175px; float: right; position: relative; z-index: 5">
						<a style='text-decoration: none' href='{{ URL::to("/") }}'>
                            <div class='pagina-inicial'>
								<p>Página inicial</p>
								<img src='{{ URL::to("img/home-blue.png") }}' />
							</div>
                        </a>
						<div class='minha-conta'>
							<img src='{{ URL::to("img/arrow-down.png") }}' class='arrow-icon' />
							<p>{{ $user->nome }}</p>
						</div>
						<!--minha-conta-->

						<a class='sair-link' href='{{ URL::to("auth/meus-dados") }}'> 
                            <span style='margin: 0 0 0 4px; color: #069; font-size: 16px' class="glyphicon glyphicon-edit"></span> 
                            <span style='margin: 5px'>Meus dados</span>
						</a> 
                        <a class='sair-link' href='{{ URL::to("logout") }}'> 
                            <span class="sair-icone"></span> <span style='margin: 5px'>Sair</span>
						</a>
					</div>
				</div>
				<!--menu-usuario-->
			</nav>
			<div class="clearfix"></div>
			<section class="container-section">@yield('content')</section>

		</div>
		<!--main-content-->

		<div class='clear'></div>

	</div>
	<!--content-box-->

	<div class='clearfix'></div>

	<div class='footer'>
		<div class='creditos-footer-interno'>
			<p style='font: 13px arial; color: #888888'>Termos de Uso | Política
				de Privacidade</p>
			<b style='font: 11px arial; color: #888888; font-weight: bold'>© 2014
				GrupoTMT.com.br. Todos os direitos reservados.</b>
		</div>
		<img id='img-navegadores' src='{{ URL::to("img/footer-login.png") }}'/>
		<a href="https://cardvantagens.com.br" target="_blank">
			<img src='{{ URL::to("img/tmt.png") }}' style="width:12%; background-size:100%; margin:20px 15px 0 0" />
		</a>
		<div class='clearfix'></div>
	</div>

	<div class='footer-login-mobile'>
			<div class='creditos'>
			    <p class='p-termos'>Termos de Uso | Política de Privacidade</p>
			    <p class='p-empresa'>
			    	<b>© 2014 GrupoTMT.com.br. Todos os direitos reservados.</b>
			    </p>
			</div>
			<img src='{{ URL::to("img/site-seguro.png") }}' class='footer-site-seguro-img'/>
		</div>
	<!--footer-->

</body>
</html>