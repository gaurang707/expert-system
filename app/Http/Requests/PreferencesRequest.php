<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreferencesRequest extends FormRequest
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
            'timezone' => [
                'required',
                'timezone',
            ],

            'language' => [
                'required',
                'string',
                Rule::in(['english', 'hindi', 'gujarati']),
            ],

            'email_notification' => [
                'required',
                'boolean',
            ],

            'task_reminder' => [
                'required',
                'boolean',
            ],

            'product_announcement' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'timezone.required' => 'Please select your timezone.',
            'timezone.timezone' => 'Please select a valid timezone.',

            'language.required' => 'Please select your preferred language.',
            'language.string' => 'Invalid language format.',
            'language.in' => 'Please select a supported language.',

            'email_notification.required' => 'Please select your email notification preference.',
            'email_notification.boolean' => 'Invalid email notification value.',

            'task_reminder.required' => 'Please select your task reminder preference.',
            'task_reminder.boolean' => 'Invalid task reminder value.',

            'product_announcement.required' => 'Please select your product announcement preference.',
            'product_announcement.boolean' => 'Invalid product announcement value.',
        ];
    }
}
