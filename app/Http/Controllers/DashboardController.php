<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request, CategoryRepository $categoryRepository)
    {
        $rules = [
            'from' => ['date'],
            'to' => ['date']
        ];

        $validated = $request->validate($rules);

        $dateInterval = [
            'from' => $validated['from'] ?? Carbon::today()->startOfMonth(),
            'to' => $validated['to'] ?? Carbon::today()->endOfMonth()
        ];

        /* Получаем все категории пользователя
         * по которым есть операции между 2-х дат
         * вместе с операциями, цветами и иконками,
         * сгруппированные по доходам/расходам [0/1]
         * */
        $categoryGroups = $categoryRepository
            ->getCategoriesWhereHasOperationsBetweenDateInterval($dateInterval)
            ->groupBy('is_expense');

        return view('dashboard.index', compact(['categoryGroups', 'dateInterval']));
    }
}
