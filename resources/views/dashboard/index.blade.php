<x-app-layout>
    <x-page-template title="Обзор">
        @php
            /** @var \Illuminate\Database\Eloquent\Collection $categoryGroups */
            $formatter = new NumberFormatter( 'ru_RU', NumberFormatter::CURRENCY);
            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '₽');
        @endphp

        <section>
            <div class="grid grid-cols-4 gap-6">
                <div class="col-span-4">
                    <div class="flex flex-row flex-nowrap justify-between items-center rounded shadow-sm bg-secondary px-4 py-2">
                        <h2 class="text-md font-bold text-headline h-full">Выберите период</h2>
                        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-row">
                            <div class="flex flex-row flex-nowrap px-2 items-center">
                                <input type="date" name="from" value="{{ \Illuminate\Support\Carbon::parse($dateInterval['from'])->format('Y-m-d') }}" class="bg-main rounded-l border-none focus:shadow-none focus:ring-0">
                                <span class="bg-main h-full flex items-center">-</span>
                                <input type="date" name="to" value="{{ \Illuminate\Support\Carbon::parse($dateInterval['to'])->format('Y-m-d') }}" class="bg-main rounded-r border-none focus:shadow-none focus:ring-0">
                            </div>
                            <button type="submit" class="py-2 px-4 bg-button text-sm font-bold text-paragraph rounded">Показать</button>
                        </form>
                    </div>
                </div>
                {{-- Summary block --}}
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Общий расход</h2>
                        <div class="bg-main p-4">
                            <span class="text-lg font-bold text-expanse-red">
                                @php
                                    $sum = 0;
                                    foreach ($categoryGroups->get(1) as $category){
                                        $sum += $category->operations->sum('amount');
                                    }
                                @endphp
                                - {{ $formatter->formatCurrency($sum, "RUR") }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Общий доход</h2>
                        <div class="bg-main p-4">
                            <span class="text-lg font-bold text-expanse-green">
                                @php
                                    $sum = 0;
                                    foreach ($categoryGroups->get(0) as $category){
                                        $sum += $category->operations->sum('amount');
                                    }
                                @endphp
                                + {{ $formatter->formatCurrency($sum, "RUR") }}
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Summary by categories block --}}
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Расходы по категориям</h2>
                        <div class="bg-main p-2">
                            @foreach($categoryGroups->get(1) as $category)
                                <x-dashboard.category-item :category="$category" :formatter="$formatter"/>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Доходы по категориям</h2>
                        <div class="bg-main p-2">
                            @foreach($categoryGroups->get(0) as $category)
                                <x-dashboard.category-item :category="$category" :formatter="$formatter"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-page-template>
</x-app-layout>
