<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email|string|min:2|max:100',//|unique:users,email
            'phone' => 'required|regex:/^[\+]{0,1}380([0-9]{9})$/i',//|unique:users,phone
            'position_id' => 'required|exists:App\Position,id',
            'photo' => 'required|mimes:jpg,jpeg|file|max:5000',
        ];
    }
}
