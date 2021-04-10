<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['user_id' => \Auth::id()]);

        if ($this->get('is_expense') == 'on') {
            $this->merge(['is_expense' => true]);
        }
        else {
            $this->merge(['is_expense' => false]);
        }
    }

    /**

     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'color_id' => ['required', 'integer', 'exists:colors,id'],
            'icon_id' => ['required', 'integer', 'exists:icons,id'],
            'is_expense' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Укажите название!',
            'name.max' => 'Укажите название длиной не более 255 символов!',
            'color_id.required' => 'Выберите цвет категории!',
            'icon_id.required' => 'Выберите значок категории!',
        ];
    }
}
