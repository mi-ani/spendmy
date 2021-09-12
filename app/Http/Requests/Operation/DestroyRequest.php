<?php

namespace App\Http\Requests\Operation;

use App\Models\Operation;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
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

        if ($categoryOwner->id === \Auth::id()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

}
