<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCreatorRequest extends FormRequest
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
            'firstname' => 'required|max:100',
            'lastname' => [
                'required',
                'max:100',
                Rule::unique('creators')->where(function ($query) {
                    return $query->where('firstname', $this->input('firstname'));
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'lastname.unique' => 'Un créateur avec ce prénom et ce nom existe déjà.',
        ];
    }
}
