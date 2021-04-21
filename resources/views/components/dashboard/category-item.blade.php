<div class="p-2 rounded overflow-hidden flex flex-row flex-nowrap items-center justify-between">
    <div class="flex flex-row flex-nowrap items-center">
        <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
             style="background: {{ $category->color->hex }}">
            <img src="{{ $category->icon->path }}" class="object-cover object-center"
                 style="width: 100%; height: 100%">
        </div>
        <div class="flex flex-col ml-4">
            <span class="text-sm font-bold text-headline">
                <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
            </span>
            <span class="text-xs font-normal text-headline opacity-60">
                {{ $category->operations->count() }} операций
            </span>
        </div>
    </div>
    <h2 class="text-sm font-semibold @if($category->is_expense) text-expanse-red @else text-expanse-green @endif">
        @if($category->is_expense) +@else -@endif {{ $formatter->formatCurrency($category->operations->sum('amount'), "RUR") }}
    </h2>
</div>
