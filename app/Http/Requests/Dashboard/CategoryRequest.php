<?php

namespace App\Http\Requests\Dashboard;

use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name.*'=>['required','string','max:100' ,UniqueTranslationRule::for('categories')->ignore($this->id) ],
            'status'=>['required','in:0,1'],
            'parent'=>['nullable','exists:categories,id'],
        ];
    }
}
