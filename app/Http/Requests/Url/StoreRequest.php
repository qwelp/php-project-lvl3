<?php

namespace App\Http\Requests\Url;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'url.name' => 'required|active_url|max:255'
        ];
    }

    public function messages()
    {
        return [
            'url.name.active_url' => "Некорректный URL",
            'url.name.max' => "Максимальное кол-во символов 255",
            'url.name.required' => "Обязательное поле",
            'url.name.unique' => "Такой адрес существует"
        ];
    }
}
