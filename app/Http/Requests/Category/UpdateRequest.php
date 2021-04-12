<?php

namespace App\Http\Requests\Category;

use App\Models\Category;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $categoryOwner = Category::find($this->route('id'))
            ->user()
            ->first();

        if ($categoryOwner->id === \Auth::id())
            return true;

        return false;
    }
}
