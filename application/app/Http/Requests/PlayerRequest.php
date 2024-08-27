<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_goalkeeper' => ['required', 'boolean'],
            'level' => 'required|integer|min:1|max:5',
        ];
    }
}
