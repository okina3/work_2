<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMemoRequest extends FormRequest
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
            'content' => 'required | string | max:1000',
            'new_tag' => 'string | nullable | max:25 | unique:tags,name',
            'image1' => 'nullable | exists:images,id',
            'image2' => 'nullable | exists:images,id',
            'image3' => 'nullable | exists:images,id',
            'image4' => 'nullable | exists:images,id',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'content.required' => 'メモの内容が、入力されていません。',
            'content.max' => '文字数は、1000文字以内にしてください。',
            'new_tag.max' => 'タグは、25文字以内で入力してください。',
            'new_tag.unique' => 'このタグは、すでに登録されています。',
        ];
    }
}
