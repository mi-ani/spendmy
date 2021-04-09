<x-app-layout>
    {{--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Операции') }}
        </h2>
    </x-slot>--}}
    @php
        /** @var \Illuminate\Database\Eloquent\Collection $categoriesWithOperations */
        $formatter = new NumberFormatter( 'ru_RU', NumberFormatter::CURRENCY);
        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '₽');
    @endphp
    {{-- Title block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="sm:text-3xl text-2xl font-semibold title-font text-gray-900">Обзор</h1>
        </div>
    </section>

    {{-- Summary block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap -mx-4 -mb-10">
                {{-- Income block --}}
                <div class="sm:w-1/2 mb-10 px-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex-grow px-4 py-4">
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Общий доход</h2>
                            <span class="text-2xl font-medium text-gray-900 title-font text-right" style="color: #2dba75">
                                @php
                                $sum = 0;
                                foreach ($categoriesWithOperations->get(0) as $category){
                                    $sum += $category->operations->sum('amount');
                                }
                                @endphp
                                + {{ $formatter->formatCurrency($sum, "RUR") }}
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Expense block --}}
                <div class="sm:w-1/2 mb-10 px-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex-grow px-4 py-4">
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Общий расход</h2>
                            <span class="text-2xl font-medium text-gray-900 title-font text-right" style="color: #f14c52">
                                @php
                                $sum = 0;
                                foreach ($categoriesWithOperations->get(1) as $category){
                                    $sum += $category->operations->sum('amount');
                                }
                                @endphp
                                - {{ $formatter->formatCurrency($sum, "RUR") }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Category list --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap -mx-4 -mb-10">
                {{-- Income block --}}
                <div class="sm:w-1/2 mb-10 px-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="text-gray-900 text-lg title-font font-medium py-4 px-4">Доходы за период</h2>
                        @foreach($categoriesWithOperations->get(0) as $category)
                            @include('components.dashboard.category-list')
                        @endforeach
                    </div>
                </div>
                {{-- Expense block --}}
                <div class="sm:w-1/2 mb-10 px-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="text-gray-900 text-lg title-font font-medium py-4 px-4">Расходы за период</h2>
                        @foreach($categoriesWithOperations->get(1) as $category)
                            @include('components.dashboard.category-list')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


</x-app-layout>
