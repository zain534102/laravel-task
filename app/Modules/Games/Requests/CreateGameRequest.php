<?php

namespace App\Modules\Games\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'player_one'=> 'required|string',
            'player_two'=>'required_if:is_computer,true|string',
            'is_computer' => 'boolean',
        ];
    }
}

