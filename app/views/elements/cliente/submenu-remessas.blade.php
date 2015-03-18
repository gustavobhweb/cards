<div class="submenu">
	<ul>
		<li {{ Request::is('cliente/enviar-remessa/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/enviar-remessa', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-glyph-briefcase"></i> Enviar dados</h3>
			</a>
		</li>
		<li {{ Request::is('cliente/remessas-enviar-foto/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/remessas-enviar-foto', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-picture"></i> Enviar fotos</h3>
				<span id="enviar-foto-count">{{ $enviarFotoCount }}</span>
			</a>
		</li>
		<li {{ Request::is('cliente/remessas-solicitar-impressao/' . $ficha_tecnica_id) ? 'class="on"' : '' }}>
			<a href="{{ URL::to('cliente/remessas-solicitar-impressao', [$ficha_tecnica_id]) }}">
				<h3><i class="halflings halflings-print"></i> Solicitar impressão</h3>
				<span id="impressao-count">{{ $impressaoCount }}</span>
			</a>
		</li>
	</ul>
</div><!-- .submenu -->