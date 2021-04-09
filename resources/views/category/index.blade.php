<x-app-layout>

    {{-- Title block --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-row">
                <h1 class="sm:text-3xl text-2xl font-semibold title-font text-gray-900">Категории</h1>
            </div>
        </div>
    </section>

    {{-- Category list --}}
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
                                        Название
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <div class="flex justify-end">
                                            <a href="{{ route('category.create') }}" class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-xs">Создать</a>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categoryList as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                                                     style="background: {{ $category->color->hex }}">
                                                    <img src="{{ $category->icon->path }}" class="object-cover object-center"
                                                         style="width: 100%; height: 100%">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-lg font-medium text-gray-600 hover:text-gray-900">
                                                        <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('category.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900">Изменить</a>
                                        </td>
                                    </tr>
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
