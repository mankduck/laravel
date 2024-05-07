<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
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
            'keyword' => 'required|unique:slides,keyword, ' . $this->id . '',
            'slide.image' => 'required'
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào tên Slide.',
            'keyword.required' => 'Bạn cần nhập vào từ khóa của Slide',
            'slide.image.required' => 'Bạn chưa chọn hình ảnh nào cho Slide'
        ];
    }
}
