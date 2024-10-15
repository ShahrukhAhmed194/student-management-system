<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validPhoneNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // Regular expression to match the provided formats
        $pattern = '/^(?:\+8801[3456789]\d{8}|01[3456789]\d{8})$/';

        // Check if the phone number matches the pattern
        return preg_match($pattern, $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid phone number.';
    }
}
