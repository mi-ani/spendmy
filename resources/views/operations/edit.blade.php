<x-app-layout>
    {{-- Title block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-row">
                <h1 class="sm:text-3xl text-2xl font-semibold title-font text-gray-900">Редактирование операции</h1>
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
                    <form action="{{ route('operations.update', $operation->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <label class="block">
                                <span class="text-gray-700">Выберите категорию</span>
                                <input type="hidden" name="category_id" value="{{ $operation->category_id }}">
                                <div class="flex flex-row py-2 flex-wrap">
                                    @foreach($categories as $category)
                                        <div
                                            class="w-10 h-10 rounded-full overflow-hidden border-red-400 m-1 @if($operation->category_id == $category->id) border-4 @endif"
                                            style="background: {{ $category->color->hex }}"
                                            data-category="{{ $category->id }}" onclick="setCategory(this);">
                                            <img src="{{ $category->icon->path }}" class="object-cover object-center"
                                                 style="width: 100%; height: 100%">
                                        </div>
                                    @endforeach
                                </div>
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Сумма</span>
                                <input type="number" value="{{ $operation->amount }}" step="0.01" min="1"
                                       max="9999999999.99" name="amount"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="">
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Дата</span>
                                <input type="date" name="date"
                                       value="{{ \Illuminate\Support\Carbon::parse($operation->date)->format('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="">
                            </label>

                            <div class="py-5">
                                <div class="border-t border-gray-200"></div>
                            </div>

                            <button type="submit"
                                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                Сохранить
                            </button>
                        </div>
                    </form>
                    <form action="{{ route('operations.destroy', $operation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex flex-row justify-end mt-4">
                            <button type="submit"
                                    class="flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
                                Удалить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        function setCategory(currentCategory) {
            let categories = document.querySelectorAll('[data-category]');
            document.getElementsByName('category_id')[0].value = currentCategory.dataset.category;
            categories.forEach(function callback(category) {
                category.classList.remove('border-4');
            });
            currentCategory.classList.add('border-4');
        }
    </script>
</x-app-layout>
