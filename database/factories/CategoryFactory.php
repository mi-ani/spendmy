<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Color;
use App\Models\Icon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_expense' => $this->faker->boolean,
            'name' => $this->faker->word,
        ];
    }
}
