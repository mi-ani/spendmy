<x-app-layout>

    {{-- Title block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-row">
                <h1 class="sm:text-3xl text-2xl font-semibold title-font text-gray-900">Операции</h1>
            </div>
        </div>
    </section>

    {{-- Operations list --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Категория
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <div class="flex justify-end">
                                            <a href="{{ route('operations.create') }}"
                                               class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-xs">Создать</a>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    /** @var \Illuminate\Database\Eloquent\Collection $category */
                                    $formatter = new NumberFormatter( 'ru_RU', NumberFormatter::CURRENCY);
                                    $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '₽');
                                @endphp
                                @foreach($dates as $date => $operations)
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                                {{ $date }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                        </td>
                                    </tr>
                                    @foreach($operations as $operation)
                                        @php
                                            $category = $categories->get($operation->category_id)->first();
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                                                         style="background: {{ $category->color->hex }}">
                                                        <img src="{{ $category->icon->path }}"
                                                             class="object-cover object-center"
                                                             style="width: 100%; height: 100%">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div
                                                            class="text-lg font-medium text-gray-600 hover:text-gray-900">
                                                            {{ $category->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex flex-row justify-end items-center">
                                                    <span
                                                        class="mr-4 px-4 border-r-2 border-gray-200 text-base font-medium text-gray-900 title-font text-right"
                                                        style="color: @if($category->is_expense) #f14c52 @else #2dba75 @endif">
                                                        @if($category->is_expense === 0) +@else
                                                            -@endif {{ $formatter->formatCurrency($operation->amount, "RUR") }}
                                                    </span>
                                                    <a href="{{ route('operations.edit', $operation->id) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">Изменить</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
