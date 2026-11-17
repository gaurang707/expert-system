<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class BulkUserActionRequest extends FormRequest
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
            'action' => ['required', Rule::in(['activate', 'deactivate', 'delete'])],
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['required', 'integer', 'distinct', 'exists:users,id'],
        ];
    }


    public function messages(): array
    {

        return [
            'action.required' => 'Please select a bulk action.',
            'action.in' => 'The selected action is invalid.',

            'user_ids.required' => 'Please select at least one user.',
            'user_ids.array' => 'Invalid user selection.',
            'user_ids.min' => 'Please select at least one user.',

            'user_ids.*.required' => 'A selected user ID is missing.',
            'user_ids.*.integer' => 'Invalid user ID provided.',
            'user_ids.*.distinct' => 'Duplicate users are not allowed.',
            'user_ids.*.exists' => 'One or more selected users do not exist.',
        ];
    }
}
