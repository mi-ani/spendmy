<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\Category\DestroyRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Color;
use App\Models\Icon;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getUserCategoriesWithPaginate();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $colorList = Color::all();
        $iconList = Icon::all();

        return view('category.create', compact(['colorList', 'iconList']));
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
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function show(CategoryRepository $categoryRepository, $id)
    {
        $category = $categoryRepository->getCategoryWithOperations($id);

        if ($category) {
            return view('category.show', compact('category'));
        }
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
        $category = $categoryRepository->getCategory($id);

        if ($category) {
            $colorList = Color::all();
            $iconList = Icon::all();

            return view('category.edit', compact(['category', 'colorList', 'iconList']));
        }

        return abort('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param CategoryRepository $categoryRepository
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, CategoryRepository $categoryRepository, $id)
    {

        $validated = $request->validated();

        $category = $categoryRepository->getCategory($id);

        if ($category) {
            $category->update($validated);

            return redirect()->route('category.edit', $category->id);
        }

        return back()->withErrors()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param CategoryRepository $categoryRepository
     * @param int $id
     * @return Response
     */
    public function destroy(DestroyRequest $request, CategoryRepository $categoryRepository, $id)
    {
        $category = $categoryRepository->getCategory($id);

        if ($category) {
            $categoryDeleted = $category->delete();
            if ($categoryDeleted)
                return redirect()->route('category.index');
        }

        return back()->withErrors();
    }
}
