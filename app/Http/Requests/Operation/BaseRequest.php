<?php

namespace App\Http\Requests\Operation;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
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
            'amount' => ['required', 'numeric', 'min:1', 'max:9999999999.99'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'date' => ['date']
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
            'amount.required' => 'Введите сумму!',
            'amount.numeric' => 'Введите сумму, введенной значение должно быть числом!',
            'amount.min' => 'Вы ввели слишком маленькое число!',
            'amount.max' => 'Вы ввели слишком большое число!',
            'category_id.required' => 'Выберите категорию!',
            'date' => 'Введите дату!'
        ];
    }
}
