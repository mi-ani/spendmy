<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Icon;
use App\Models\Operation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categoryList = Category::with(['color:id,hex', 'icon:id,path'])
            ->select(['id', 'is_expense', 'name', 'icon_id', 'color_id', 'user_id'])
            ->where('user_id', '=', \Auth::id())
            ->get();

        return view('category.index', compact('categoryList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colorList = Color::select(['id', 'hex'])->get();
        $iconList = Icon::select(['id', 'path'])->get();

        return view('category.create', compact(['colorList', 'iconList']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'color_id' => ['required', 'integer', 'exists:colors,id'],
            'icon_id' => ['required', 'integer', 'exists:icons,id'],
            'is_expense' => ['boolean'],
        ];

        $messages = [
            'name.required' => 'Укажите название!',
            'name.max' => 'Укажите название длиной не более 255 символов!',
            'color_id.required' => 'Выберите цвет категории!',
            'icon_id.required' => 'Выберите значок категории!',
        ];

        $validated = $request->validate($rules, $messages);

        if (!array_key_exists('is_expense', $validated)) $validated['is_expense'] = 0;

        $validated['user_id'] = \Auth::id();

        $category = Category::create($validated);

        if (!empty($category)) {
            return redirect()->route('category.edit', $category->id);
        } else {
            return back()->withInput()->withErrors();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::with(['operations:id,date,amount,category_id', 'color:id,hex', 'icon:id,path'])
            ->where('id', $id)
            ->get()
            ->first();

        if ($category) {
            return view('category.show', compact('category'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if ($category) {
            $colorList = Color::select(['id', 'hex'])->get();
            $iconList = Icon::select(['id', 'path'])->get();
            return view('category.edit', compact(['category', 'colorList', 'iconList']));
        }

        return redirect('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'color_id' => ['required', 'integer', 'exists:colors,id'],
            'icon_id' => ['required', 'integer', 'exists:icons,id'],
            'is_expense' => ['boolean'],
        ];

        $messages = [
            'name.required' => 'Укажите название!',
            'name.max' => 'Укажите название длиной не более 255 символов!',
            'color_id.required' => 'Выберите цвет категории!',
            'icon_id.required' => 'Выберите значок категории!',
        ];

        $validated = $request->validate($rules, $messages);

        $category = Category::find($id);

        if ($category) {
            $category->update($validated);

            return redirect()->route('category.edit', $category->id);
        }

        return back()->withErrors()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $categoryDeleted = $category->delete();
            if ($categoryDeleted)
                return redirect()->route('category.index');
        }

        return back()->withErrors();
    }
}
