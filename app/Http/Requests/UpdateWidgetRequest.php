<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWidgetRequest extends FormRequest
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
            'name' => 'required',
            'keyword' => 'required|unique:widgets,keyword, ' . $this->id . '',
            'short_code' => 'required|unique:widgets,short_code, ' . $this->id . '',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào tên Widget.',
            'keyword.required' => 'Bạn cần nhập vào từ khóa của Widget',
            'keyword.unique' => 'Từ khóa đã tồn tại!',
            'short_code.required' => 'Short Code đã tồn tại!',
        ];
    }
}
