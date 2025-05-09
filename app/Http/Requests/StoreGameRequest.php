<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreGameRequest extends FormRequest
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
        return [
            'name' => 'required|unique:games|max:100',
            'description' => 'required',
            'published_at' => 'required|date',
            'imgurl' => 'required|image|mimes:png,jpg',
            'min_players' => 'required|integer|min:1|max:150',
            'max_players' => 'required|integer|min:1|max:150',
            'average_duration' => 'required|integer|min:1|max:1000',
            'EAN' => 'nullable|digits:13',
            'suggestedage' => 'required|integer|min:1|max:70',
            'is_expansion' => 'required|boolean',
            'publishers' => 'required|array|min:1',
            'creators' => 'required|array|min:1',
            'mechanics' => 'required|array|min:1',
            'categories' => 'required|array|min:1',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $min = $this->input('min_players');
            $max = $this->input('max_players');

            if (!is_null($min) && !is_null($max) && $min > $max) {
                $validator->errors()->add('min_players', 'Le nombre minimum de joueurs doit être inférieur ou égal au nombre maximum.');
                $validator->errors()->add('max_players', 'Le nombre maximum de joueurs doit être supérieur ou égal au nombre minimum.');
            }
        });
    }
}
