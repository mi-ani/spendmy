@if ($paginator->hasPages())
    <nav role="navigation" class="flex items-center @if($paginator->onFirstPage()) justify-end @elseif(!$paginator->hasMorePages()) justify-start @else justify-between @endif w-full">
        @if(!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}"
               class="py-2 px-4 mr-1 bg-button text-sm font-bold text-paragraph rounded">Назад</a>
        @endif

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="py-2 px-4 ml-1 bg-button text-sm font-bold text-paragraph rounded">Следующая</a>
        @endif
    </nav>
@endif
