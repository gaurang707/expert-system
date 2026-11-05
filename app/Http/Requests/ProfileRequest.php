<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => [
                
                'sometimes',
                'nullable',

                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max('2mb'),

            ],
            'name' => ['required', 'string', 'max:200'],
            'display_name' => ['sometimes','nullable', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user())],
            'bio' => ['sometimes','nullable', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.image' => 'Please upload a valid image.',
            'avatar.mimes' => 'Only JPG, PNG, and WebP images are allowed.',
            'avatar.max' => 'Profile image must not exceed 2 MB.',
        ];
    }
}
