<?php

namespace Modules\Agent\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Agent\Rules\NoUrls;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Agent\Rules\NoSpecialCharacters;

class UpdateAgentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required','string','max:50','min:3', 
            new NoUrls, new NoSpecialCharacters, 'regex:/^[a-zA-Z\s]*$/'],
            'last_name' => ['required','string','max:50','min:3', 
            new NoUrls, new NoSpecialCharacters, 'regex:/^[a-zA-Z\s]*$/'],
            'email' => ['required','email','max:191','unique:agents,email,'. $this->agent],
            'iso2' => ['required','string','max:2'],
            'dial_code' => ['required','string','max:10'],
            'phone' => ['required','string','max:20','unique:agents,phone,'. $this->agent],
            'formatted_phone' => ['required','string','max:20'],
            'password' => ['nullable','min:6'],
            'password_confirmation' => ['nullable','min:6','same:password'],
            'address' => ['required','string','max:255', new NoUrls],
            'state' => ['required','string','max:255', new NoUrls],
            'city' => ['required','string','max:255', new NoUrls],
            'status' => ['required', Rule::in(config('agent.agent_status'))],
            'country_id' => ['required','integer'],
            'agent_package_id' => ['required','integer'],
            'business_name' => ['required','string','max:255', 
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
