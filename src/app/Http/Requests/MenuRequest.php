<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
            'menu_name' => ['required', Rule::unique('menus', 'name')->where('user_id', Auth::user()->id), 'max:30'],
            'genre_name' => ['required', 'max:20'],
        ];
    }

    public function attributes()
    {
        return [
            'menu_name' => '献立名',
            'genre_name' => 'ジャンル名',
        ];
    }
}
