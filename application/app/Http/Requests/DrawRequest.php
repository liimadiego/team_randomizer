<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DrawRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'players_per_team' => 'required|integer',
            'total_teams' => 'required|integer',
            'confirmed_players' => 'required|integer|min:0'
        ];
    }
}
