<?php

namespace App\Modules\UserSubmissions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserSubmissionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

