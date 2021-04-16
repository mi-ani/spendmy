<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Category as Model;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить все категории аутентифицированного пользоватеся с цветами и иконками
     *
     * @return Collection
     */
    public function getUserCategories()
    {

        $categories = $this->startConditions()
            ->with(['color:id,hex', 'icon:id,path'])
            ->select(['id', 'is_expense', 'name', 'icon_id', 'color_id', 'user_id'])
            ->where('user_id', '=', \Auth::id())
            ->get();

        return $categories;
    }

    /**
     * Получить категорию вместе с операциями, цветом и иконкой по id
     *
     * @param integer $id
     * @return Collection
     */
    public function getCategoryWithOperations($id)
    {
        $category = $this->startConditions()
            ->with(['operations:id,date,amount,category_id', 'color:id,hex', 'icon:id,path'])
            ->where('id', $id)
            ->first();

        return $category;
    }

    /**
     * Получить категорию по id
     *
     * @param integer $id
     * @return Category
     */
    public function getCategory($id)
    {
        $category = $this->startConditions()
            ->find($id);

        return $category;
    }

}
