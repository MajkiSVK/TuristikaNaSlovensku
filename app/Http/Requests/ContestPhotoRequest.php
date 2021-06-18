<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|string|max:100',
            'photo' => 'required|mimes:jpg,jpeg,png'
        ];
    }

    public function messages()
    {
        return [
        'description.required' => 'Nezadal si žiadny popis fotky',
        'photo.mimes' => 'Je dovolené nahrať fotky iba nasledujúcich formátoch: :values',
        'photo.required' => 'Nenahral si žiadny súbor'
        ];
    }
}
