<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class EnoughBalance implements Rule
{
    private $category_id;
    /**
     * Create a new rule instance.
     *
     * @param $category_id
     */
    public function __construct($category_id)
    {
        $this->category_id = $category_id;

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
        $category = Category::query()->find($this->category_id);
        /* @var $category Category*/
        if ($category->type == Category::TYPE_EXPENSE) {
            $user = Auth::user();
            /* @var $user User*/
            return $user->balance >= $value;
        }
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You cannot add an expense transaction with a value 
                greater than the remaining balance in your wallet!';
    }
}
