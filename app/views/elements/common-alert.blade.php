<div class='wm-modal'>
	<div class="wm-modal-box" id="wm-alert">
		<div class="wm-modal-head">
			<button class='wm-modal-close'>&times;</button>
			<h3 class='wm-modal-title'>Alerta</h3>
		</div>
		<div class="wm-modal-body"></div>
		<div class="wm-modal-footer">
			<div class='wm-modal-inputs'>
				<button class='wm-btn wm-modal-btn-cancel'>Cancelar</button>
				<button class='wm-btn wm-btn-blue wm-modal-btn-confirm'>Ok</button>
			</div>
		</div>
	</div>
</div>


@section('styles')
{{ 
	HTML::style('css/wm-modal.css'),
	HTML::style('css/jquery-ui.css')
}}
@append

@section('scripts')
{{ 
	HTML::script('js/wm-modal.js'),
	HTML::script('js/jquery-ui.js')
}}
@append