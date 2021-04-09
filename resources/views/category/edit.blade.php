<x-app-layout>
    {{-- Title block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-row">
                <h1 class="sm:text-3xl text-2xl font-semibold title-font text-gray-900">Редактирование категории</h1>
            </div>
        </div>
    </section>
    {{--  Form block  --}}
    <section class="body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex">
            <div class="py-12 px-12 bg-white overflow-hidden shadow-sm sm:rounded-lg w-3/5">
                @if($errors->any())
                    <div class="py-2 px-4 mb-6 bg-red-400 rounded-md text-gray-100">
                        @foreach ($errors->all() as $error)
                            <div class="mb-1">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="w-full">
                    <form action="{{ route('category.update', $category->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <label class="block">
                                <span class="text-gray-700">Название</span>
                                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" value="{{ $category->name }}">
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Выберите цвет</span>
                                <input type="hidden" name="color_id" value="{{ $category->color_id }}">
                                <div class="flex flex-row py-2">
                                    @foreach($colorList as $color)
                                        <div class="w-10 h-10 rounded-full overflow-hidden m-1 border-red-400 @if($category->color_id == $color->id) border-4 @endif"
                                             style="background: {{ $color->hex }}" data-color="{{ $color->id }}" onclick="setColor(this);">
                                        </div>
                                    @endforeach
                                </div>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Выберите значок</span>
                                <input type="hidden" name="icon_id" value="{{ $category->icon_id }}">
                                <div class="flex flex-row flex-wrap py-2">
                                    @foreach($iconList as $icon)
                                        <div class="w-10 h-10 rounded-full m-1 overflow-hidden border-red-400 @if($category->icon_id == $icon->id) border-4 @endif"
                                             style="background: {{ $colorList->where('id', $category->color_id)->first()->hex ?? 'grey' }}" data-icon="{{ $icon->id }}" onclick="setIcon(this)">
                                            <img src="{{ $icon->path }}" class="object-cover object-center"
                                                 style="width: 100%; height: 100%">
                                        </div>
                                    @endforeach
                                </div>
                            </label>
                            <div class="block">
                                <div class="mt-2">
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_expense" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50" value="1" @if($category->is_expense) checked @endif>
                                            <span class="ml-2">Категория расходов</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="py-5">
                                <div class="border-t border-gray-200"></div>
                            </div>

                            <div class="flex flex-row justify-end">
                                <button type="submit" class="flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Сохранить</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex flex-row justify-end mt-4">
                            <button type="submit" class="flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        function setColor (currentColor) {
            let colors = document.querySelectorAll('[data-color]');
            document.getElementsByName('color_id')[0].value = currentColor.dataset.color;
            colors.forEach(function callback(color) {
                color.classList.remove('border-4');
            });
            currentColor.classList.add('border-4');
            let icons = document.querySelectorAll('[data-icon]');
            icons.forEach(function callback(icon) {
                icon.style.backgroundColor = currentColor.style.backgroundColor;
            });
        }

        function setIcon (currentIcon) {
            let icons = document.querySelectorAll('[data-icon]');
            document.getElementsByName('icon_id')[0].value = currentIcon.dataset.icon;
            icons.forEach(function callback(icon) {
                icon.classList.remove('border-4');
            });
            currentIcon.classList.add('border-4');
        }
    </script>
</x-app-layout>
