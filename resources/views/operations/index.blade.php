@php
    /**
     * @var Illuminate\Pagination\LengthAwarePaginator $operations
     * @var Illuminate\Database\Eloquent\Collection $categories
    */
    $formatter = new NumberFormatter( 'ru_RU', NumberFormatter::CURRENCY);
    $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '₽');
@endphp

<x-app-layout>
    <x-page-template title="Операции">
        <div class="rounded overflow-hidden">
            <div class="py-2 px-4 bg-secondary flex justify-between items-center">
                <span class="text-md font-bold text-headline">
                    Категория
                </span>
                <a href="{{ route("operations.create") }}"
                   class="py-2 px-4 bg-button text-sm font-bold text-paragraph rounded">Создать</a>
            </div>
            <div class="flex flex-col">
                @if(!empty($operations))
                    @foreach($operations as $operation)
                        @php
                        /**
                         * @var App\Models\Category $category
                         * @var App\Models\Operation $operation
                         */
                        $category = $categories->firstWhere('id', $operation->category_id)
                        @endphp
                        <div class="flex flex-row flex-nowrap justify-between items-center border-t border-secondary px-4 py-2">
                            <div class="flex flex-row flex-nowrap items-center">
                                <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                                     style="background: {{ $category->color->hex }}">
                                    <img src="{{ $category->icon->path }}" class="object-cover object-center"
                                         style="width: 100%; height: 100%">
                                </div>
                                <span class="ml-4 text-sm font-bold text-headline">
                                    <span>{{ $category->name }}</span>
                                </span>
                            </div>
                            <div class="flex flex-row flex-nowrap items-center">
                                <span class=""
                                    style="color: @if($category->is_expense) #f14c52 @else #2dba75 @endif">
                                    @if($category->is_expense === 0) +@else -@endif {{ $formatter->formatCurrency($operation->amount, "RUR") }}
                                </span>
                                <span class="text-sm text-secondary mx-4">|</span>
                                <form action="{{ route("operations.destroy", $operation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-expanse-red focus:outline-none">Удалить
                                    </button>
                                </form>
                                <span class="text-sm text-secondary mx-2">|</span>
                                <a href="{{ route("operations.edit", $operation->id) }}" class="text-sm text-contrast">Изменить</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="py-2 px-4 bg-secondary flex justify-between items-center">
                {{ $operations->links('pagination.simple') }}
            </div>
        </div>
    </x-page-template>

</x-app-layout>

