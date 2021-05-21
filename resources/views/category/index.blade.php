<x-app-layout>

    <x-page-template title="Категории">
        <div class="rounded overflow-hidden">
            <div class="py-2 px-4 bg-secondary flex justify-between items-center">
                <span class="text-md font-bold text-headline">
                    Название
                </span>
                <a href="{{ route("category.create") }}" class="py-2 px-4 bg-button text-sm font-bold text-paragraph rounded">Создать</a>
            </div>
            <div class="flex flex-col">
                @if(!empty($categories))
                    @foreach($categories as $category)
                        <div class="flex flex-row flex-nowrap justify-between items-center border-t border-secondary px-4 py-2">
                            <div class="flex flex-row flex-nowrap items-center">
                                <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                                     style="background: {{ $category->color->hex }}">
                                    <img src="{{ $category->icon->path }}" class="object-cover object-center"
                                         style="width: 100%; height: 100%">
                                </div>
                                <span class="ml-4 text-sm font-bold text-headline">
                                    <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                                </span>
                            </div>
                            <div class="flex flex-row flex-nowrap items-center">
                                <form action="{{ route("category.destroy", $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-expanse-red focus:outline-none">Удалить</button>
                                </form>
                                <span class="text-sm text-secondary mx-2">|</span>
                                <a href="{{ route("category.edit", $category->id) }}" class="text-sm text-contrast">Изменить</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </x-page-template>

</x-app-layout>
