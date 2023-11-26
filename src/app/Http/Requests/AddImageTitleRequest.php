<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddImageTitleRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title' => 'string | max:25'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.string' => '文字列では、ありません',
            'title.max' => 'タイトルは、25文字以内で入力してください。',
        ];
    }
}
