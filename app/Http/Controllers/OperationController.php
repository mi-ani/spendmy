<?php

namespace App\Http\Controllers;

use App\Http\Requests\Operation\DestroyRequest;
use App\Http\Requests\Operation\StoreRequest;
use App\Http\Requests\Operation\UpdateRequest;
use App\Models\Operation;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getUserCategories();

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
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function create(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getUserCategories();

        return view('operations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {

        $validated = $request->validated();

        if (!array_key_exists('date', $validated))
            $validated['date'] = Carbon::now();

        $operation = Operation::create($validated);

        if ($operation) {
            return redirect()->route('operations.edit', $operation->id);
        }

        return back()->withInput()->withErrors();

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CategoryRepository $categoryRepository
     * @param int $id
     * @return Response
     */
    public function edit(CategoryRepository $categoryRepository, $id)
    {
        $categories = $categoryRepository->getUserCategories();

        $operation = Operation::find($id);

        if ($operation)
            return view('operations.edit', compact(['operation', 'categories']));

        return redirect('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {

        $validated = $request->validated();

        if (!array_key_exists('date', $validated)) $validated['date'] = Carbon::now();

        $operation = Operation::find($id);

        if ($operation) {
            $updated = $operation->update($validated);

            if ($updated)
                return redirect()->route('operations.edit', $operation->id);
        }

        return back()->withInput()->withErrors();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param int $id
     * @return Response
     */
    public function destroy(DestroyRequest $request, $id)
    {
        $operation = Operation::find($id);

        if ($operation) {
            $deleted = $operation->delete();

            return redirect()->route('operations.index');
        }

        return redirect()->back();
    }
}
