<?php

namespace Modules\Agent\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Agent\Rules\NoUrls;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Agent\Rules\NoSpecialCharacters;

class UpdateAgentPackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:agent_packages,name,'. $this->package, 
            'max:50', new NoUrls, new NoSpecialCharacters, 'regex:/^[a-zA-Z\s]*$/'],
            'description' => ['required', 'string', 'max:191', new NoUrls],
            'commission' => ['required','numeric'],
            'is_default' => ['required', Rule::in(['Yes', 'No'])],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'is_default' => 'Default value',
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
