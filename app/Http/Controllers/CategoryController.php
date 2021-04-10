<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Icon;

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
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        $validated = $request->validated();

        $category = Category::create($validated);

        if ($category) {
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

        return abort('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {

        $validated = $request->validated();

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
