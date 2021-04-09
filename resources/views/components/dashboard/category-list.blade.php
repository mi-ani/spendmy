<section class="text-gray-600 body-font overflow-hidden">
    <div class="px-5 py-2">
        <div class="flex flex-wrap md:flex-nowrap items-center">
            <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                <div class="inline-flex items-center">
                    <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                         style="background: {{ $category->color->hex }}">
                        <img src="{{ $category->icon->path }}" class="object-cover object-center"
                             style="width: 100%; height: 100%">
                    </div>
                    <span class="flex-grow flex flex-col pl-4">
                        <span class="title-font font-medium text-gray-600 hover:text-gray-900">
                            <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                        </span>
                        <span class="text-gray-400 text-xs tracking-widest mt-0.5">{{ $category->operations->count() }} операций</span>
                    </span>
                </div>
            </div>
            <div class="md:flex-grow">
                <h2 class="text-base font-medium text-gray-900 title-font text-right"
                    style="color: @if($category->is_expense) #f14c52 @else #2dba75 @endif">@if($category->is_expense === 0) +@else -@endif {{ $formatter->formatCurrency($category->operations->sum('amount'), "RUR") }}</h2>
            </div>
        </div>
    </div>
</section>
