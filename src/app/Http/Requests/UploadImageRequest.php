<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
            'files' => 'required',
            'files.*.image' => 'image | mimes:jpg,jpeg,png | max:2048',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'files.required' => '画像が指定されていません。',
            'files.*.image.image' => '指定されたファイルが画像ではありません。',
            'files.*.image.mimes' => '指定された拡張子(jpg/jpeg/png)ではありません。',
            'files.*.image.max' => 'ファイルサイズは2MB以内にしてください。',
        ];
    }
}
