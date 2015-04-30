<div class="submenu">
	<ul>
		@if ($ficha->tem_dados)
		<li {{ Request::is('cliente/enviar-remessa/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/enviar-remessa', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-glyph-briefcase"></i> Enviar dados</h3>
			</a>
		</li>
		@else
		<li {{ Request::is('cliente/enviar-remessa-numero/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/enviar-remessa-numero', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-glyph-briefcase"></i> Selecionar qtd. de solicitaçãoes</h3>
			</a>
		</li>
		@endif
		@if ($ficha->tem_foto)
		<li {{ Request::is('cliente/remessas-enviar-foto/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/remessas-enviar-foto', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-picture"></i> Enviar fotos</h3>
			</a>
		</li>
		@endif
		<li {{ Request::is('cliente/remessas-solicitar-impressao/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/remessas-solicitar-impressao', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-print"></i> Solicitar impressão</h3>
			</a>
		</li>
	</ul>
</div><!-- .submenu -->