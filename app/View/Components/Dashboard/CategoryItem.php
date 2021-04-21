<?php

namespace App\View\Components\Dashboard;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryItem extends Component
{
    /**
     * @var Category $category
    */
    public $category;
    /**
     * @var \NumberFormatter $formatter
     */
    public $formatter;
    /**
     * Create a new component instance.
     * @param $category
     *
     * @return void
     */
    public function __construct(Category $category, \NumberFormatter $formatter)
    {
        $this->category = $category;
        $this->formatter = $formatter;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.category-item');
    }
}
