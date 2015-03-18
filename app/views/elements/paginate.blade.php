@if ($paginator->getLastPage() > 1)

<div data-section="pagination">

	@if($paginator->getCurrentPage() == 1)
	<p>Primeiro</p>
	@else <a href='{{ $paginator->getUrl(1) }}'>Primeiro</a> @endif

	@if($paginator->getCurrentPage() != 1) <a
		href="{{ $paginator->getUrl($paginator->getCurrentPage()-1) }}">
		Anterior<i class="icon left arrow"></i>
	</a> @else
	<p class="disabled">Anterior</p>
	@endif @for ($i = 1; $i <= $paginator->getLastPage(); $i++)
	@if($paginator->getCurrentPage() == $i)
	<p class="item active">{{ $i }}</p>
	@else <a href="{{ $paginator->getUrl($i) }}">{{ $i }}</a> @endif
	@endfor @if($paginator->getCurrentPage() != $paginator->getLastPage())
	<a href="{{ $paginator->getUrl($paginator->getCurrentPage()+1) }}">
		Próximo<i class="icon right arrow"></i>
	</a> @else
	<p class="disabled">Próximo</p>
	@endif @if($paginator->getCurrentPage() === $paginator->getLastPage())
	<p>Último</p>
	@else <a href='{{ $paginator->getUrl($paginator->getLastPage()) }}'>Último</a>
	@endif

</div>

<div class='clearfix'></div>

@endif