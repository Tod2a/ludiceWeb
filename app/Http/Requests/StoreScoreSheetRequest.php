<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScoreSheetRequest extends FormRequest
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
            'game_id' => 'required|exists:games,id',
            'sections' => 'required|array|min:1',
            'sections.*.name' => ['required', 'string', 'max:255'],
            'sections.*.scores' => 'required|array|min:1',
            'sections.*.scores.*.score' => 'nullable|numeric',
            'sections.*.scores.*.user_id' => 'nullable|exists:users,id',
            'sections.*.scores.*.guest_id' => 'nullable|exists:guests,id',
        ];
    }
}
