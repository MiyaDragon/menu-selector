<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name' => 'required|unique:menus|max:30',
            'genre' => 'required|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '献立名',
            'genre' => 'ジャンル名',
        ];
    }
}
