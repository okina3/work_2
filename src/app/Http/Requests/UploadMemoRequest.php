<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMemoRequest extends FormRequest
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
            'content' => 'required | string | max:1000',
            'new_tag' => 'string | nullable | max:25',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'メモの内容が、入力されていません。',
            'content.max' => '文字数は、1000文字以内にしてください。',
            'new_tag.max' => 'タグは、25文字以内で入力してください。',
        ];
    }
}
