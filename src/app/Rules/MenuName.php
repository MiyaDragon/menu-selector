<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Menu;

class MenuName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Menu $menu)
    {
        $this->id = $menu->id;
        $this->user_id = $menu->user_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->name = $value;
        $menu = Menu::where('user_id', $this->user_id)->where('name', $this->name);
        if ($menu->exists()) {
            return $menu->where('id', $this->id)->exists();
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->name . 'は既に存在します';
    }
}
