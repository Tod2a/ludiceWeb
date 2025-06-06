<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $gameId = $this->route('game');

        return [
            'name' => [
                'required',
                'max:50',
                Rule::unique('games')->ignore($gameId),
            ],
            'description' => 'required',
            'published_at' => 'required|date',
            'min_players' => 'required|integer|min:1|max:150',
            'max_players' => 'required|integer|min:1|max:150',
            'average_duration' => 'required|integer|min:1|max:1000',
            'EAN' => 'nullable|digits:13',
            'imgurl' => 'nullable',
            'suggestedage' => 'required|integer|min:1|max:70',
            'is_expansion' => 'required|boolean',
            'publishers' => 'required|array|min:1',
            'creators' => 'required|array|min:1',
            'mechanics' => 'required|array|min:1',
            'categories' => 'required|array|min:1',
        ];
    }
}
