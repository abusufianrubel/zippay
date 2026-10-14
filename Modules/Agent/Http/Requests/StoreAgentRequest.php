<?php

namespace Modules\Agent\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Agent\Rules\NoUrls;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Agent\Rules\NoSpecialCharacters;

class StoreAgentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required','string','max:50','min:3','regex:/^[a-zA-Z\s]*$/',
             new NoUrls, new NoSpecialCharacters],
            'last_name' => ['required','string','max:50','min:3','regex:/^[a-zA-Z\s]*$/', 
            new NoUrls, new NoSpecialCharacters],
            'email' => ['required','email','max:191','unique:agents,email'],
            'iso2' => ['required','string','max:2'],
            'dial_code' => ['required','string','max:10'],
            'phone' => ['required','string','max:20','unique:agents,phone'],
            'formatted_phone' => ['required','string','max:20'],
            'password' => ['required','min:6', 'confirmed'],
            'password_confirmation' => ['required','min:6'],
            'address' => ['required','string','max:255', new NoUrls],
            'state' => ['required','string','max:255', new NoUrls],
            'city' => ['required','string','max:255', new NoUrls],
            'status' => ['required', Rule::in(config('agent.agent_status'))],
            'country_id' => ['required','integer'],
            'agent_package_id' => ['required','integer'],
            'business_name' => ['required','string','max:255','regex:/^[a-zA-Z\s]*$/', 
            new NoUrls, new NoSpecialCharacters, 'regex:/^[a-zA-Z\s]*$/'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
