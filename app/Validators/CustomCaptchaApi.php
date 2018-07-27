<?php
namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;

class CustomCaptchaApi implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return captcha_api_check($value, request()->get($attribute . '_key'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid captcha code';
    }
}