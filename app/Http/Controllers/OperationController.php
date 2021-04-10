<?php

namespace App\Http\Controllers;

use App\Http\Requests\Operation\StoreRequest;
use App\Http\Requests\Operation\UpdateRequest;
use App\Models\Category;
use App\Models\Operation;
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
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        $validated = $request->validated();

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
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {

        $validated = $request->validated();

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
