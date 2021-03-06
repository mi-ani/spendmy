<?php

namespace App\Http\Requests\Operation;

use App\Models\Operation;

class UpdateRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $categoryOwner = Operation::find($this->route('id'))
            ->category()
            ->first()
            ->user()
            ->first();

        if ($categoryOwner->id === \Auth::id())
            return true;

        return false;
    }

}
