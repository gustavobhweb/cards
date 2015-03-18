@if ($paginator->getLastPage() > 1)

<ul class="wm-paginator">
	<li>@if($paginator->getCurrentPage() != 1) <a
		href="{{ $paginator->getUrl(1) }}"> Anterior<i class="icon left arrow"></i>
	</a> @else <a class="disabled">Anterior</a> @endif
	</li> @for ($i = 1; $i <= $paginator->getLastPage(); $i++)
	@if($paginator->getCurrentPage() == $i)
	<a class="item active">{{ $i }}</a> @else
	<a href="{{ $paginator->getUrl($i) }}">{{ $i }}</a> @endif @endfor
	<li>@if($paginator->getCurrentPage() != $paginator->getLastPage()) <a
		href="{{ $paginator->getUrl($paginator->getCurrentPage()+1) }}">
			Próximo<i class="icon right arrow"></i>
	</a> @else <a class="disabled">Próximo</a> @endif
	</li>
</ul>

@endif
