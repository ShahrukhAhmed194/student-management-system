<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class ValidateExistingUsersName implements Rule
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
        $people_with_same_user_name = User::where('user_name', $value)->where('id', '!=', $this->user_id)->count();
        return $people_with_same_user_name > 1 ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Someone else is using this user name. Please try again with another user name';
    }
}
