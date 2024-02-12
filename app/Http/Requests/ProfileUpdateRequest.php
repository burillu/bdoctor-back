<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages(){
        return [
            'email.unique'=>'L\'indirizzo email è già utilizzato.',
            'email.required' => 'Il campo email è obbligatorio.',
            'email.string' => 'Il campo email deve essere testuale.',
            'email.max' => 'Il campo email deve essere lungo massimo :max caratteri.',
            'email.email' => "Il campo email deve essere un'email valida.",
            
        ];
    }
}
