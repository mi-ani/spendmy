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
                        <x-datepicker :route="route('dashboard')" :date-interval="$dateInterval"/>
                    </div>
                </div>
                {{-- Summary block --}}
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Общий расход</h2>
                        <div class="bg-main p-4">
                            <span class="text-lg font-bold text-expanse-red">
                                @if(!empty($categoryGroups->get(1)))
                                    @php
                                        $sum = 0;
                                        foreach ($categoryGroups->get(1) as $category){
                                            $sum += $category->operations->sum('amount');
                                        }
                                    @endphp
                                    - {{ $formatter->formatCurrency($sum, "RUR") }}
                                @else
                                    <x-dashboard.empty :expanse="1"/>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Общий доход</h2>
                        <div class="bg-main p-4">
                            <span class="text-lg font-bold text-expanse-green">
                                @if(!empty($categoryGroups->get(0)))
                                    @php
                                        $sum = 0;
                                        foreach ($categoryGroups->get(0) as $category){
                                            $sum += $category->operations->sum('amount');
                                        }
                                    @endphp
                                    + {{ $formatter->formatCurrency($sum, "RUR") }}
                                @else
                                    <x-dashboard.empty :expanse="0"/>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Summary by categories block --}}
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Расходы по категориям</h2>
                        <div class="bg-main p-2">
                            @if(!empty($categoryGroups->get(1)))
                                @foreach($categoryGroups->get(1) as $category)
                                    <x-dashboard.category-item :category="$category" :formatter="$formatter"/>
                                @endforeach
                            @else
                                <x-dashboard.empty :expanse="1"/>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="flex flex-col rounded shadow-sm bg-secondary overflow-hidden">
                        <h2 class="text-md font-bold text-headline px-4 py-2">Доходы по категориям</h2>
                        <div class="bg-main p-2">
                            @if(!empty($categoryGroups->get(0)))
                                @foreach($categoryGroups->get(0) as $category)
                                    <x-dashboard.category-item :category="$category" :formatter="$formatter"/>
                                @endforeach
                            @else
                                <x-dashboard.empty :expanse="0"/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-page-template>
</x-app-layout>
