<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with(['color:id,hex', 'icon:id,path'])
            ->select(['id', 'name', 'is_expense', 'color_id', 'icon_id'])
            ->where('user_id', \Auth::id())
            ->get();

        $categoryIds = $categories->pluck('id')->toArray();

        $categories = $categories->groupBy('id');

        $dates = Operation::whereIn('category_id', $categoryIds)
            ->select(['id', 'date', 'amount', 'category_id'])
            ->get()
            ->groupBy('date')
            ->sortKeysDesc();

        return view('operations.index', compact(['categories', 'dates']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with(['color:id,hex', 'icon:id,path'])
            ->select(['id', 'name', 'is_expense', 'color_id', 'icon_id'])
            ->where('user_id', \Auth::id())
            ->get();

        return view('operations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'amount' => ['required', 'numeric', 'min:1', 'max:9999999999.99'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'date' => ['date']
        ];

        $messages = [
            'amount.required' => 'Введите сумму!',
            'amount.numeric' => 'Введите сумму, введенной значение должно быть числом!',
            'amount.min' => 'Вы ввели слишком маленькое число!',
            'amount.max' => 'Вы ввели слишком большое число!',
            'category_id.required' => 'Выберите категорию!',
            'date' => 'Введите дату!'
        ];

        $validated = $request->validate($rules, $messages);

        if(!array_key_exists('date', $validated)) $validated['date'] = Carbon::now();

        $operation = Operation::create($validated);

        if($operation){
            return redirect()->route('operations.edit', $operation->id);
        }

        return back()->withInput()->withErrors();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::with(['color:id,hex', 'icon:id,path'])
            ->select(['id', 'name', 'is_expense', 'color_id', 'icon_id'])
            ->where('user_id', \Auth::id())
            ->get();

        $operation = Operation::find($id);

        if($operation)
            return view('operations.edit', compact(['operation' ,'categories']));

        return redirect('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'amount' => ['required', 'numeric', 'min:1', 'max:9999999999.99'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'date' => ['date']
        ];

        $messages = [
            'amount.required' => 'Введите сумму!',
            'amount.numeric' => 'Введите сумму, введенной значение должно быть числом!',
            'amount.min' => 'Вы ввели слишком маленькое число!',
            'amount.max' => 'Вы ввели слишком большое число!',
            'category_id.required' => 'Выберите категорию!',
            'date' => 'Введите дату!'
        ];

        $validated = $request->validate($rules, $messages);

        if(!array_key_exists('date', $validated)) $validated['date'] = Carbon::now();

        $operation = Operation::find($id);

        if($operation){
            $updated = $operation->update($validated);

            if($updated)
                return redirect()->route('operations.edit', $operation->id);
        }

        return back()->withInput()->withErrors();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operation = Operation::find($id);

        if($operation){
            $deleted = $operation->delete();

            return redirect()->route('operations.index');
        }

        return redirect()->back();
    }
}
