<?php


namespace App\Repositories;

use App\Models\Operation as Model;
use Illuminate\Database\Eloquent\Collection;


class OperationRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить операцию по id
     *
     * @param int $id
     * @return Model
     */
    public function getOperation(int $id)
    {
        $operation = $this->startConditions()->find($id);

        return $operation;
    }

    /**
     * Получить операции принадлежащие категориям
     *
     * @param array $categories
     * @return Collection
    */
    public function getOperationsBelongsToCategories(array $categories){
        $operations = $this->startConditions()
            ->whereIn('category_id', $categories)
            ->get();

        return $operations;
    }

    /**
     * Получить операции принадлежащие категориям
     *
     * @param array $categories
     * @param int $pages
     * @return Collection
     */
    public function getOperationsBelongsToCategoriesWithPaginate(array $categories, int $pages = null){
        $operations = $this->startConditions()
            ->whereIn('category_id', $categories)
            ->orderBy('date', 'desc')
            ->paginate($pages ?? 50);

        return $operations;
    }

}
