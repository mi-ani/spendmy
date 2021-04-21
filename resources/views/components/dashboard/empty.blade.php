@props(['expanse'])

<div class="flex h-32 justify-center items-center">
    <span class="text-md font-semibold text-paragraph">
        За выбранный период
        @if($expanse)
            <span class="text-expanse-red">расходов</span>
        @else
            <span class="text-expanse-green">доходов</span>
        @endif
        не найдено.
    </span>
</div>
