<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $date = [
            'from' => Carbon::today()->startOfMonth(),
            'to' => Carbon::today()->endOfMonth()
        ];

        $categoriesWithOperations =
            Category::with(['operations' => function ($query) use ($date) {
                $query->select(['id', 'date', 'amount', 'category_id']);
                //$query->whereBetween('date', $date);
                $query->orderByDesc('date');
            }, 'color:id,hex', 'icon:id,path'])
                ->select(['id', 'is_expense', 'name', 'color_id', 'icon_id', 'user_id'])
                ->where('user_id', "=", $user->id)
                ->get()
                ->groupBy('is_expense');


        //dd($categoriesWithOperations);

        return view('dashboard.index', compact('categoriesWithOperations'));
    }
}
