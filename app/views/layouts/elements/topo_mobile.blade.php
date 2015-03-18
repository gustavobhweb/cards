<div class='topo-mobile'>
	<a href="{{ URL::to('/') }}"> 
		<img class='logo-mobile' src='{{ URL::to("img/pbh.png") }}' />
	</a>
	<div class='menu-mobile'>
			<div class="dados-user">
				<p>Olá, {{ $user->nome }}!</p>
				<p>Nível</p>
			</div>
			<img class='btn-menu-mobile' src='{{ URL::to("img/btn-menu-mobile.png") }}' />
	</div>
	<div class='container-menu-mobile'>
		<div class='menu-opened-mobile' data-visible='false'>
	        <ul>
		    	@foreach($PERMISSOES as $permissao)
			    	@if($permissao->in_menu)
				    <li {{ (Request::is($permissao->url)) ? 'class="on"' : '' }} >
				        <a href='{{ URL::to($permissao->url) }}' {{ (Request::is($permissao->url)) ? 'class="on"' : '' }}>
				            <span class="glyphicon glyphicon-{{ $permissao->glyphicon }}"></span>
				            {{ $permissao->name }}
				        </a>
				    </li>
				    @endif
				@endforeach
		    	<li>
		    		<a href="{{ URL::to('logout') }}">
			            <span class="glyphicon glyphicon-remove"></span>
			            Sair
			        </a>
		    	</li>
			</ul>
	        <img src='{{ URL::to("img/carteira_1.png")  }}'/>
		</div>	
	</div>
	<div class="clearfix"></div>
	<div class="line"></div>
</div>
