<?php

namespace Modules\Agent\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $agentId = auth('agent-v2')->user()->id ?? auth()->guard('agent')->user()->id;
        return [
            'first_name' => ['required', 'min:3', 'max:50',
            'regex:/^[a-zA-Z\s]*$/'],
            'last_name' => ['required', 'min:3', 'max:50', 
            'regex:/^[a-zA-Z\s]*$/'],
            'password' => ['nullable', 'min:6'],
            'confirm_password' => ['nullable', 'min:6', 'same:password'],
            'phone' => ['required','string','max:20','unique:agents,phone,'.$agentId],

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
