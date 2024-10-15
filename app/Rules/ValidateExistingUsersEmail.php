<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class ValidateExistingUsersEmail implements Rule
{
    public $user_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user_id = $id;
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
        $users_with_same_email = User::where('email', $value)->where('id', '!=', $this->user_id)->count();
         return $users_with_same_email > 2 ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Someone else is using this email. Please try again with another email';
    }
}
