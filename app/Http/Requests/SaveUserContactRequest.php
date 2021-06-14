<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserContactRequest extends FormRequest
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
            'contact_mail' => 'email|required',
            'user_phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'contact_mail.required' => 'Kontaktný E-mail nesmie ostať prázdny',
            'contact_mail.email' => 'Kontaktný E-mail musí byť reálna e-mailová adresa',
            'user_phone.required' => 'Telefónne číslo nesmie ostať prázdne'
        ];
    }
}
