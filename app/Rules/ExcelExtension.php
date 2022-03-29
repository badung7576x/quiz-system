<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExcelExtension implements Rule
{
    private $extensions = ['xls', 'xlsx'];
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
        return in_array($value->getClientOriginalExtension(), $this->extensions); 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('File phải là tập tin định dạng excel');
    }
}
