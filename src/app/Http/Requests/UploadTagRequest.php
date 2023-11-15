<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadTagRequest extends FormRequest
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
            'new_tag' => 'required | string | max:25 | unique:tags,name',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'new_tag.required' => 'タグが、入力されていません。',
            'new_tag.max' => 'タグは、25文字以内で入力してください。',
            'new_tag.unique' => 'このタグは、すでに登録されています。',
        ];
    }
}
