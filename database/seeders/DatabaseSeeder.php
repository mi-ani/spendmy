<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Icon;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Заполняем таблицу "users" и получаем массив ID созданных записей

        $userIds = User::factory(10)->create()->pluck('id')->toArray();

        // Заполняем таблицу "colors" и получаем массив ID созданных записей

        $colorIds = Color::factory(10)->create()->pluck('id')->toArray();

        // Заполняем таблицу "icons"

        $icons = scandir(__DIR__ . '\..\..\public\icons'); // Получаем имена файлов

        $iconIds = []; // Массив ID иконок

        foreach ($icons as $icon) {
            if(!is_dir($icon)){

                // Создаем записи в таблице "icons" и добавляем массив ID созданной записи

                $iconIds[] = Icon::create(
                    ['path' => "/icons/$icon"]
                )->id;
            }
        }

        // Заполняем таблицу "categories"

        $categories = Category::factory(count($userIds) * 10)
            ->make()
            ->each(function ($category) use ($userIds, $colorIds, $iconIds){
                $category->user_id = $userIds[array_rand($userIds)];
                $category->color_id = $colorIds[array_rand($colorIds)];
                $category->icon_id = $iconIds[array_rand($iconIds)];
            });

        Category::insert($categories->toArray());

        // Получаем ID созданных категорий

        $categoryIds = Category::all('id')->pluck('id')->toArray();

        // Заполняем таблицу "operations"

        $operations = Operation::factory(count($categoryIds) * 100)
            ->make()
            ->each(function ($operation) use ($categoryIds){
                $operation->category_id = $categoryIds[array_rand($categoryIds)];
            })->toArray();

        Operation::insert($operations);

    }
}
