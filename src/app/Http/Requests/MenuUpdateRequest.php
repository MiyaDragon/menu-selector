<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MenuName;

class MenuUpdateRequest extends FormRequest
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
            'menu_name' => [
                'required',
                new MenuName($this->menu),
                'max:30'
            ],
            'genre_name' => ['required', 'max:20'],
            'menu_image' => ['file', 'image', 'mimes:jpeg,png'],
        ];
    }

    public function attributes()
    {
        return [
            'menu_name' => '献立名',
            'genre_name' => 'ジャンル名',
            'menu_image' => '画像',
        ];
    }
}
