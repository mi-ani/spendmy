@props(['dateInterval', 'route'])

<form action="{{ $route }}" method="GET" class="flex flex-row">
    <div class="flex flex-row flex-nowrap px-2 items-center">
        <input type="date" name="from" value="{{ \Illuminate\Support\Carbon::parse($dateInterval['from'])->format('Y-m-d') }}" class="bg-main rounded-l border-none focus:shadow-none focus:ring-0">
        <span class="bg-main h-full flex items-center">-</span>
        <input type="date" name="to" value="{{ \Illuminate\Support\Carbon::parse($dateInterval['to'])->format('Y-m-d') }}" class="bg-main rounded-r border-none focus:shadow-none focus:ring-0">
    </div>
    <button type="submit" class="py-2 px-4 bg-button text-sm font-bold text-paragraph rounded">Показать</button>
</form>
