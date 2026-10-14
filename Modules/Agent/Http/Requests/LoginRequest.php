<?php

namespace Modules\Agent\Http\Requests;

use App\Exceptions\Api\V2\LoginException;
use Exception;
use Illuminate\Support\Str;
use Modules\Agent\Entities\Agent;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomFormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends CustomFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $login_type = filter_var($this->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'formatted_phone';

        if (! Auth::guard('agent')->attempt([$login_type => $this->input('email'), 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw new LoginException(__("Invalid email & credentials"));
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }

    /**
     * Get login method
     *
     * @param string $email
     * @return array
     */
    public function getLoginVia($email)
    {
        $loginVia = settings('login_via');
        $agent = null;
    
        switch ($loginVia) {
            case 'phone_only':
                $agent = Agent::getByPhone($email);
                break;
    
            case 'email_or_phone':
                if (strpos($email, '@') !== false) {
                    $agent = Agent::getByEmail($email);
                } else {
                    $agent = Agent::getByPhone($email);
                }
                break;
    
            default:
                $agent = Agent::getByEmail($email);
                break;
        }
    
        return $agent;
    }

    protected function prepareForValidation()
    {
        try {
            $this->merge([
                'email' => $this->getLoginVia($this->input('email')),
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
