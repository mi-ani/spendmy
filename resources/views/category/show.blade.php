<x-app-layout>
    {{-- Title block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-row">
                <h1 class="sm:text-3xl text-2xl font-semibold title-font text-gray-900">Операции по {{ $category->name }}</h1>
            </div>
        </div>
    </section>
    @php
        /** @var Illuminate\Database\Eloquent\Collection $category */
        $formatter = new NumberFormatter( 'ru_RU', NumberFormatter::CURRENCY);
        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '₽');
    @endphp
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-grow px-4 py-4">
                    @foreach($category->operations as $operation)
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
                                        <span class="text-gray-400 text-xs tracking-widest mt-0.5">{{ $operation->date }}</span>
                                    </span>
                                    </div>
                                </div>
                                <div class="md:flex-grow">
                                    <h2 class="text-base font-medium text-gray-900 title-font text-right"
                                        style="color: @if($category->is_expense) #f14c52 @else #2dba75 @endif">@if($category->is_expense === 0) +@else -@endif {{ $formatter->formatCurrency($operation->amount, "RUR") }}</h2>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
